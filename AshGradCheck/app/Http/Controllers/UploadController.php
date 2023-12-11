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

        // Save file information to the database
        $user = Auth::user(); // Assuming you are using authentication
        $newFile = new File([
            'user_id' => $user->id,
            'name' => $filename,
            // Add other fields as needed
        ]);
        $newFile->save();

        return response()->json(['success' => true, 'message' => 'File uploaded successfully']);
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
}

