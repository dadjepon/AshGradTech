<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EditProfileController extends Controller
{
        public function edit()
    {
        $user = auth()->user();
        return view('editprofile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'major' => 'required',
            'studentId' => 'required|digits:8|regex:/^.*(?<year>\d{4})$/|after_or_equal:2024',
            'password' => 'nullable|confirmed',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust as needed
        ]);

        // Update user's information
        $user->update([
            'major' => $request->major,
        ]);

        // Update password if provided
        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('profile_images', $imageName, 'public');
            $user->update([
                'profile_image' => $imageName,
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Profile updated successfully');
    }
}
