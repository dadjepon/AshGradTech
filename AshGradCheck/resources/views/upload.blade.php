@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-8/12 bg-white p-6 rounded-lg">
            <h2 class="text-lg font-semibold mb-4">Dashboard</h2>

            <!-- Your existing dashboard content goes here -->

            <!-- Upload Transcript Button -->
            <button id="upload-button" class="bg-blue-500 text-white px-4 py-2 rounded font-medium">Upload PDF</button>
            <div id="dropzone-container" style="display: none;">
                <!-- Dropzone Container -->
                <form id="upload-form" action="{{ route('storeupload') }}" method="POST" enctype="multipart/form-data" class="dropzone">
                    @csrf
                    <div class="fallback">
                        <input name="file" type="file" accept=".pdf" />
                    </div>
                    <!-- You can customize the Dropzone appearance further if needed -->
                </form>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const uploadButton = document.getElementById('upload-button');
                const dropzoneContainer = document.getElementById('dropzone-container');

                uploadButton.addEventListener('click', function () {
                    dropzoneContainer.style.display = 'block';
                });
            });
        </script>
    @endsection
@endsection
