<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function storeUpload(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'file' => 'required|mimes:pdf|max:4096', // Adjust the validation rules as needed
        ]);

        // Handle the file upload
        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('uploads', $filename, 'public'); // Save the file in the "public/uploads" directory


        // Check a condition to determine on_track status
        $onTrack = $this->checkOnTrackCondition($file);
        // Save file information to the database
        $user = Auth::user(); // Assuming you are using authentication

        $newFile = new File([
            'user_id' => $user->id,
            'name' => $filename,
            'filepath' => asset('uploads/'.$filename), // Store the file path
            'on_track' => $onTrack, // Default value for on_track status
        ]);

    $newFile->save();

        return response()->json(['success' => true, 'message' => 'File uploaded successfully']);
    }

    private function checkOnTrackCondition($file){
        return strpos($file->getClientOriginalName(), 'on_track') !== false;
    }

    public function getFiles()
    {
        $user = Auth::user();
        $files = $user->files()->get(['id', 'name']); // Adjust the fields as needed

        return response()->json(['files' => $files]);
    }

    public function deleteFile($id)
    {
        $user = Auth::user();
        $file = $user->files()->findOrFail($id);

        // Delete the file from storage
        Storage::disk('public')->delete('uploads/' . $file->name);

        // Delete the file from the database
        $file->delete();

        return response()->json(['message' => 'File deleted successfully']);
    }

    public function getFileCount()
    {
        $user = Auth::user();
        $fileCount = $user->files()->count();

        return response()->json(['count' => $fileCount]);
    }


    /**
     * Update on_track status for a specific file.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateTrackStatus($id)
{
    $user = Auth::user();
    $file = $user->files()->findOrFail($id);

    // Assuming that the API response contains a field named 'track_status'
    $trackStatus = request()->input('track_status');

    // Update the on_track status in the database
    $file->update(['on_track' => ($trackStatus === 'On Track')]);

    return response()->json(['message' => 'On Track status updated successfully']);
}

}