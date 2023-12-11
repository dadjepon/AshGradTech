@extends('layouts.navbar')

@section('content')
<div style="height:100vh">
    <div class="flex flex-col md:flex-row md:items-center justify-between p-8 md:mt-8">
        <div class="flex items-center"> 
            <h1 class="text-4xl font-bold mb-4 md:mb-0">My Files</h1>

            <!-- Mobile Upload Icon -->
        <button id="mobile-upload-icon" class="md:hidden mb-4 ml-auto" onclick="toggleMobileUpload()">
            <img src="/images/upload.svg" alt="Logo" class="w-8 h-6">
        </button>
    </div>

        <!-- Upload Button (Hidden on Mobile) -->
        <button id="open-dropzone" class="hidden md:inline-block bg-blue-500 text-white px-4 py-2 rounded-md">Upload File</button>
    </div>

    <!-- Dropzone Container (Initially Hidden) -->
    <div id="dropzone-modal" class="fixed inset-0 z-10 hidden flex items-center justify-center bg-opacity-80 bg-gray-600">
        <div class="bg-gray-200 p-7 rounded-lg md:w-6/12 w-full relative">
            <button id="close-dropzone" class="text-gray-500 hover:text-gray-700 text-4xl font-bold absolute top-0 right-1 cursor-pointer">×</button>

            <!-- Dropzone Form -->
            <form id="upload-form" action="{{ route('storeupload') }}" method="POST" class="dropzone" style="border: 2px solid #000;">
                @csrf
                <div class="fallback">
                    <input name="file" type="file" />
                </div>
                <div class="dz-message">
                    <h2 class="text-lg font-semibold mb-4">Upload your Transcript</h2>
                    <p class="text-sm text-gray-500">Drag & drop or click to upload PDF files</p>
                </div>
            </form>
            <div id="submit-container" class="mb-8"></div>
        </div>
    </div>

   <div id="file-list" class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5 p-4">
    @foreach($files as $file)
        <div class=" file-container w3-card-4 w3-margin bg-gray-300 p-2 rounded-md flex flex-col items-start justify-between w-full md:w-64 transform hover:shadow-lg transition-transform duration-300">
            <div class="file-container bg-gray-200">
                <img src="{{ asset('images/ashesi.jpeg') }}" alt="Preview" style="width:100%">
                <div class="w3-xlarge w3-display-bottomleft w3-padding">{{ $file->name }}</div>
            </div>
            <div class="flex items-center justify-between w-full">
                <span class="text-gray-500 text-xs">File Size: {{ $file->size }} KB</span>
                <div class="mt-8 flex items-center gap-8">
                    <img src="{{ asset('images/audit.svg') }}" alt="Preview" class="w-6 h-5 cursor-pointer">
                <button data-file-id="{{ $file->id }}" class="delete-icon bg-red-500 text-white px-2 py-1 rounded-md">
                    <img src="{{ asset('images/delete.svg') }}" alt="Delete">
                </button>

                </div>
            </div>
        </div>
    @endforeach
</div>


    <!-- Empty State -->
    <div id="empty-state" class="{{ count($files) > 0 ? 'hidden' : '' }} mt-32 md:mt-32 flex flex-col items-center gap-2">
        <div class="h-8 w-8 text-blue-500">
            <!-- Placeholder for Ghost icon -->
            <svg xmlns="http://www.w3.org/2000/svg" height="2em" viewBox="0 0 512 512"><path d="M416 398.9c58.5-41.1 96-104.1 96-174.9C512 100.3 397.4 0 256 0S0 100.3 0 224c0 70.7 37.5 133.8 96 174.9c0 .4 0 .7 0 1.1v64c0 26.5 21.5 48 48 48h48V464c0-8.8 7.2-16 16-16s16 7.2 16 16v48h64V464c0-8.8 7.2-16 16-16s16 7.2 16 16v48h48c26.5 0 48-21.5 48-48V400c0-.4 0-.7 0-1.1zM96 256a64 64 0 1 1 128 0A64 64 0 1 1 96 256zm256-64a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"/></svg>
        </div>
        <h3 class="font-semibold text-2xl">
            Pretty empty around here
        </h3>
        <p>Let's upload your first PDF.</p>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function updateEmptyState(count) {
        var emptyState = document.getElementById('empty-state');
        if (count > 0) {
            emptyState.classList.add('hidden');
        } else {
            emptyState.classList.remove('hidden');
        }
    }

    // Function to fetch file count from the server
    function fetchFileCount() {
        fetch("{{ route('filecount') }}")
            .then(response => response.json())
            .then(data => {
                updateEmptyState(data.count);
            })
            .catch(error => {
                console.error("Error fetching file count:", error.message);
            });
    }
    // Function to toggle mobile upload visibility
        function toggleMobileUpload() {
            document.getElementById('dropzone-modal').classList.remove('hidden');
            document.getElementById('empty-state').classList.add('hidden');
        }

    document.addEventListener('DOMContentLoaded', function () {
        var myDropzone = new Dropzone("#upload-form", {
            paramName: "file",
            maxFilesize: 1,
            acceptedFiles: ".pdf,.docx",
            dictDefaultMessage: "Drag & drop or click to upload PDF files",
            init: function () {
                var submitButton = Dropzone.createElement('<button id="audit-file" class="bg-blue-500 text-white px-4 py-2 rounded-md absolute bottom-2 right-4 hidden">Audit</button>');
                document.getElementById('submit-container').appendChild(submitButton);

                // Fetch initial file count
                fetchFileCount();

                this.on("addedfile", function (file) {
                    // Remove existing files before uploading a new file
                    if (this.files.length > 1) {
                        // Remove the existing file from the dropzone
                        this.removeFile(this.files[0]);

                        // Remove the existing file from the database
                        var existingFileId = document.querySelector('.file-container').getAttribute('data-file-id');
                        if (existingFileId) {
                            fetch("/deletefile/" + existingFileId, {
                                method: "DELETE",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                },
                            })
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error(`HTTP error! Status: ${response.status}`);
                                    }
                                    return response.json();
                                })
                                .then(data => {
                                    console.log("Existing file deleted:", data);
                                })
                                .catch(error => {
                                    console.error("Error deleting existing file:", error.message);
                                });
                        }
                    }

                    var fileContainer = document.createElement('div');
                    fileContainer.classList.add('file-container', 'bg-gray-300', 'p-2', 'rounded-md', 'flex', 'items-center', 'justify-between', 'w-64');

                    fileContainer.innerHTML = `
                        <span>${file.name}</span>
                        <button class="delete-icon bg-red-500 text-white px-2 py-1 rounded-md">&#10006;</button>
                    `;

                    document.getElementById('file-list').appendChild(fileContainer);

                    fileContainer.querySelector('.delete-icon').addEventListener('click', function () {
                        var fileId = this.getAttribute('data-file-id');

                        fetch("/deletefile/" + fileId, {
                            method: "DELETE",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            },
                        })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error(`HTTP error! Status: ${response.status}`);
                                }
                                return response.json();
                            })
                            .then(data => {
                                console.log("File deleted:", data);

                                var fileContainer = this.closest('.file-container');
                                fileContainer.remove();

                                var files = document.querySelectorAll('.file-container');
                                var emptyState = document.getElementById('empty-state');
                                if (files.length === 0) {
                                    emptyState.classList.remove('hidden');
                                }
                            })
                            .catch(error => {
                                console.error("Error deleting file:", error.message);
                            });
                    });

                    submitButton.classList.remove('hidden');
                    // Update empty state after file upload
                    fetchFileCount();
                });

                this.on("success", function (file, response) {
                    console.log("File uploaded:", file);
                    console.log("Server response:", response);
                    // Update empty state after file upload
                    fetchFileCount();
                });

                this.on("dragover", function () {
                    document.getElementById('upload-form').style.border = '3px dotted #3b82f6';
                });

                this.on("dragleave", function () {
                    document.getElementById('upload-form').style.border = '2px solid #000';
                });
            },
        });

        document.getElementById('open-dropzone').addEventListener('click', function () {
            document.getElementById('dropzone-modal').classList.remove('hidden');
            document.getElementById('empty-state').classList.add('hidden');
        });

        document.getElementById('close-dropzone').addEventListener('click', function () {
            document.getElementById('dropzone-modal').classList.add('hidden');
            fetchFileCount(); // Update empty state when closing dropzone
            location.reload();
        });
        

        var files = {!! json_encode($files) !!};
        if (!files || files.length === 0) {
            document.getElementById('empty-state').classList.remove('hidden');
        } else {
            document.getElementById('file-list').classList.remove('hidden');
        }

        document.querySelectorAll('.delete-icon').forEach(function (deleteIcon) {
            deleteIcon.addEventListener('click', function () {
                var fileId = this.getAttribute('data-file-id');

                fetch("/deletefile/" + fileId, {
                    method: "DELETE",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! Status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log("File deleted:", data);

                        var fileContainer = deleteIcon.closest('.file-container');
                        fileContainer.remove();

                        var files = document.querySelectorAll('.file-container');
                        var emptyState = document.getElementById('empty-state');
                        if (files.length === 0) {
                            emptyState.classList.remove('hidden');
                        }
                    })
                    .catch(error => {
                        console.error("Error deleting file:", error.message);
                    });
            });
        });

        document.getElementById('audit-file').addEventListener('click', function () {
            var fileData = myDropzone.files.map(function (file) {
                return {
                    name: file.name,
                    size: file.size,
                    type: file.type,
                    lastModified: file.lastModified,
                };
            });

            fetch("{{ route('storeupload') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                },
                body: JSON.stringify({ files: fileData }),
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log("Server response:", data);
                    // Update empty state after audit-file action
                    fetchFileCount();
                })
                .catch(error => {
                    console.error("Error submitting file data:", error.message);
                });
        });
    });
</script>
@endsection
