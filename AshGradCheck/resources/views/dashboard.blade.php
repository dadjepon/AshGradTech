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


<!-- Audit Form -->
<div id="audit-form-modal" class="fixed inset-0 z-10 hidden flex items-center justify-center bg-opacity-80 bg-gray-600">
    <div class="bg-gray-200 p-7 rounded-lg md:w-6/12 w-full relative">
        <form id="audit-form" class="mb-8">
            <label for="semester" class="block text-sm font-medium text-gray-700">Select Semester:</label>
            <select id="semester" name="semester" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                <option value="1">Semester 1</option>
                <option value="2">Semester 2</option>
                
            </select>
            
            <button id="audit-ok" class="bg-blue-500 text-white px-4 py-2 rounded-md mt-4">Ok</button>
            <button id="close-audit-form" class="text-gray-500 hover:text-gray-700 text-4xl font-bold absolute top-0 right-1 cursor-pointer">×</button>
        </form>

        <!-- Loader Container -->
        <div id="progressContainer" class="flex flex-col items-center" style="display: none;">
            <div class="w-40 bg-gray-200 rounded-md h-1 dark:bg-gray-700 mb-6">
                <div id="progressBar" class="bg-blue-600 h-1 rounded-md" style="width: 0"></div>
            </div>
            <div id="progressText" class="text-gray-600 dark:text-gray-400">📂Initializing.....</div>
        </div>
    </div>
</div>

<!--modal-->
<div class="relative z-10" id="modal-container" style="display: none;" aria-labelledby="modal-title" role="dialog" aria-modal="true">  
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-green-500 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                            <h3 class="text-base font-bold leading-6 text-gray-900" id="modal-title">You're on Track!</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Kudos to you!! Great work done. You're all set to graduate on time. </p>
                            </div>
                            <div class="flex justify-between mb-1 text-gray-500 mt-4 dark:text-gray-400">
                                <span class="text-base font-normal">Your progress</span>
                                <span class="text-sm font-semibold text-gray-900 dark:text-red"><span class="bg-red-100 creditsValue"> </span> of 33.5 credits</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-600">
                                <div class="bg-green-500 h-2.5 rounded-full" style="width: 85%"></div>
                            </div>
                            <div class="text-sm mt-8 text-gray-500">
                                {{auth()->user()->major}} Major in class of {{auth()->user()->yearGroup}} should have:
                                <ul class="list-disc ml-2">
                                    <span>
                                        <li>
                                            <p class="font-bold">Semester <span class="font-bold SemValue" > </span>: <span class="font-bold required_credits"> </span> Credits</p>
                                        </li>
                                    </span>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="button" id="cancel" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Ok Thanks!</button>
                </div>
            </div>
        </div>
    </div>
</div>


<!--not on track modal-->
<div class="relative z-10" id="not-on-track-modal-container" style="display: none;" aria-labelledby="modal-title" role="dialog" aria-modal="true">
      
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-500 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 15h-1v-1h1v1zm0-2h-1V7h1v8z"/>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                            <h3 class="text-base font-bold leading-6 text-gray-900" id="not-on-track-modal-title">You're not on Track!</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Looks like you have some catching up to do. It's either you missed some courses or did not get the pass mark. See the academic advisor on how best to progress with your academic journey. </p>
                            </div>
                            <div class="flex justify-between mb-1 text-gray-500 mt-4 dark:text-gray-400">
                                <span class="text-base font-normal">Your progress</span>
                                <span class="text-sm font-semibold text-gray-900 dark:text-red"><span class="bg-red-100 not-creditsValue"> </span> of 33.5 credits</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-600">
                                <div class="bg-red-500 h-2.5 rounded-full" style="width: 75%"></div>
                            </div>
                            <div class="text-sm mt-8 text-gray-500">
                                {{auth()->user()->major}} Major in class of {{auth()->user()->yearGroup}} should have:
                                <ul class="list-disc ml-2">
                                    <span>
                                        <li>
                                            <p class="font-bold">Semester <span class="font-bold not-SemValue"> </span>: <span class="font-bold not-required_credits"> </span> Credits</p>
                                        </li>
                                    </span>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="button" id="not-on-track-cancel" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Ok Thanks!</button>
                </div>
            </div>
        </div>
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
    var currentFile = null;
    var fileId;
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
                        var fileId = document.querySelector('.file-container').getAttribute('data-file-id');
                        if (fileId) {
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
                        fileId = this.getAttribute('data-file-id');

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
        
        
var files;


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

                // Call the updateOnTrackStatus function with fileId and trackStatus
                updateOnTrackStatus(fileId, trackStatus);
            })
            .catch(error => {
                console.error("Error deleting file:", error.message);
            });
    });
});



function updateOnTrackStatus(fileId, trackStatus) {
    fetch("/updateontrack/" + fileId, {
        method: "PUT",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
        },
        body: JSON.stringify({
            track_status: trackStatus,
        }),
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log("On Track status updated:", data);
    })
    .catch(error => {
        console.error("Error updating On Track status:", error.message);
    });
}


// Note: fileId may still be undefined here if the delete-icon hasn't been clicked yet.



        
        

        document.getElementById('audit-file').addEventListener('click', function () {
            // Show the audit form modal
            document.getElementById('audit-form-modal').classList.remove('hidden');
            
            // Get the fileId from the currently selected file
            // fileId = document.querySelector('.file-container').getAttribute('data-file-id');
            console.log("Audit-file FileId:", fileId);
        });

        // Function to trigger the audit



        document.getElementById('audit-ok').addEventListener('click', function () {
            // Prevent the default form submission that would refresh the page
            event.preventDefault();

            document.getElementById('dropzone-modal').classList.add('hidden');

        
            // Display the progress bar container
            document.getElementById('progressContainer').style.display = 'flex';
        
            // Declare progress outside the function
            let progress = 10;
        
            // Start updating the progress bar
            updateProgressBar();
        
            var selectedSemester = document.getElementById('semester').value;
            
            console.log(document.getElementById('semester').innerHTML)
            // Prepare data for API request
            var formData = new FormData();
            formData.append('year_group', @json(auth()->user()->yearGroup));
            formData.append('major', @json(auth()->user()->major));
            formData.append('semester', selectedSemester);
            formData.append('transcript', myDropzone.files[0]);
        
            console.log("files: ", myDropzone.files[0].upload.uuid);
        
            // Display FormData entries in the console for debugging
            var pair = null;
            for (pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
            }
        
            // Send data to the API endpoint
            fetch("https://us-central1-ashgradcheck.cloudfunctions.net/degree-audit-function/audit", {
                method: "POST",
                body: formData
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log("Audit successful:", data);

                    // Retrieve the credits earned by the student on report
                    var credits = data.total_credits
                    document.querySelector('.creditsValue').textContent = credits;
                    
                    document.querySelector('.not-creditsValue').textContent = credits;
                    // Sem value based on what the user selected
                    document.querySelector('.SemValue').textContent = selectedSemester;
                    

                    document.querySelector('.not-SemValue').textContent = selectedSemester;

                    var requiredCredits = data.required_credits
                    document.querySelector('.required_credits').textContent = requiredCredits;
                    
                    document.querySelector('.not-required_credits').textContent = requiredCredits;
                    
                    var trackStatus = data.track_status;
                    updateOnTrackStatus(fileId, trackStatus);

                    
                    // Width of Progress Bar
                    // const progresslength = credits / 33.5;
                    // document.getElementById('widthvalue').textContent = progresslength;

                     // Close the audit form modal
                    document.getElementById('audit-form-modal').classList.add('hidden');
                    if(data.track_status == "On Track"){
                        showOnTrackModal();
                    }
                    else{
                        showNotOnTrackModal();
                    }
                    
                    // Show whether student is on track or not


                    // Update empty state after audit
                    fetchFileCount();
                })
                .catch(error => {
                    console.error("Error auditing:", error.message);
                })
                .finally(() => {
                    // Hide the progress bar container
                    document.getElementById('progressContainer').style.display = 'none';
                });

//     function updateOnTrackStatus(fileId, trackStatus) {
//     fetch("/updateontrack/" + fileId, {
//         method: "PUT",
//         headers: {
//             "Content-Type": "application/json",
//             "X-CSRF-TOKEN": "{{ csrf_token() }}",
//         },
//         body: JSON.stringify({
//             track_status: trackStatus,
//         }),
//     })
//     .then(response => {
//         if (!response.ok) {
//             throw new Error(`HTTP error! Status: ${response.status}`);
//         }
//         return response.json();
//     })
//     .then(data => {
//         console.log("On Track status updated:", data);
//     })
//     .catch(error => {
//         console.error("Error updating On Track status:", error.message);
//     });
// }

            
            // Function to update the progress bar
            function updateProgressBar() {
                const progressBar = document.getElementById('progressBar');
                const progressText = document.getElementById('progressText');
                // Define an array of text messages
                const textMessages = [
                    "📂Initializing.....",
                    "Extracting Data from Transcript.....",
                    "🔄Comparing extract with database.....",
                    "Checking any failed courses.....",
                    "Getting results ready.....",
                    "Process complete!"
                ];
                
            
                // Increase progress by a small amount
                progress += 0.2; // Use a smaller increment
            
                // Update the width of the progress bar
                progressBar.style.width = `${progress}%`;
            
                // Change color to green when reaching 100
                if (progress >= 100) { // Adjust the condition to check for >= 100
                    progressBar.classList.remove('bg-blue-600');
                    progressBar.classList.add('bg-green-500');
                }
            
                // Update the text content based on the progress
                const currentStep = Math.floor(progress / 20);
                progressText.textContent = textMessages[currentStep];
            
                // Stop when reaching 100
                if (progress < 100) {
                    // Schedule the next update after a delay
                    setTimeout(updateProgressBar, 45); // 20 milliseconds for smoother progress
                }
            }

            // showing the modal
            function showOnTrackModal() {
                // Your code to show the modal here
                let modalContainer = document.getElementById("modal-container");
                modalContainer.style.display = "block";
            
                let removeModal = document.getElementById("cancel");
                removeModal.addEventListener("click", function (){
                    // Hide the modal on cancel button click
                    modalContainer.style.display = "none";
                    location.reload();
                });
            
            }
        
            function showNotOnTrackModal() {
                // Your code to show the modal here
                let modalContainer = document.getElementById("not-on-track-modal-container");
                modalContainer.style.display = "block";
            
                let removeModal = document.getElementById("not-on-track-cancel");
                removeModal.addEventListener("click", function (){
                    // Hide the modal on cancel button click
                    modalContainer.style.display = "none";
                    location.reload();
                });
            
            }
                });
            
        // Close the audit form modal on "x" button click
        document.getElementById('close-audit-form').addEventListener('click', function () {
            document.getElementById('audit-form-modal').classList.add('hidden');
        });
            });
        


</script>
@endsection



