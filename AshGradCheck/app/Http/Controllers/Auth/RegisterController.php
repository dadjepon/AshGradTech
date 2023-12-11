<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;

class RegisterController extends Controller
{
    // Applying a middleware such that we won't be able 
    // to register again if we are already signed in.
    public function __construct()
    {
        $this->middleware(['guest']);
    }

    // Defining a function to view the register page
    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $request)
{
    try {
        $this->validate($request, [
            'name' => 'required|max:255|unique:users',
            'email' => 'required|email|max:255|regex:/@ashesi\.edu\.gh$/i|unique:users',
            'major' => 'required',
            'StudentId' => [
                'required',
                function ($attribute, $value, $fail) use ($request) {
                    // Check if StudentId is 10001000 or matches the regex
                    if ($value !== '10001000' && !preg_match('/^\d{4}(202[4-9])$/', $value)) {
                        $fail('The ' . $attribute . ' is invalid.');
                    }
                },
                'digits:8',
                'unique:users',
                // 'after:2023',
            ],
            'password' => 'required|min:5|regex:/^(?=.*[a-zA-Z0-9])(?=.*[\W_]).+$/|confirmed|unique:users',
        ], [
            'StudentId.required' => 'Student ID is required.',
            'StudentId.digits' => 'Student ID must be 8 digits.',
            'StudentId.after' => 'Student ID year must be 2024 or later.',
        ]);

        $isAdmin = $request->StudentId === '10001000';

        // Set default values
        $major = $isAdmin ? null : $request->major;
        $yearGroup = $isAdmin ? null : substr($request->StudentId, -4);

        // Set the username based on the first name
        $username = strtok($request->name, ' ');

        // Store user's information with role
        $user = User::create([
            'name' => $request->name,
            'username' => $username,
            'email' => $request->email,
            'major' => $major,
            'yearGroup' => $yearGroup,
            'StudentId' => $request->StudentId,
            'password' => Hash::make($request->password),
            'role' => $isAdmin ? 'admin' : 'user', // Set the role based on the condition
        ]);

        // Attempt to sign in
        if (auth()->attempt($request->only('email', 'password'))) {
            return redirect()->route('dashboard');
        }

        // Handle any exception that occurs during user creation or sign-in
        return redirect()->back()->with('error', 'Error creating user.');
    } catch (QueryException $e) {
        // Handle database exceptions
        if ($e->errorInfo[1] == 1062) {
            // 1062 is the MySQL error code for a duplicate entry
            return redirect()->back()->with('error', 'User with the same email, name, password, or student ID already exists.');
        }

        // Handle other database exceptions as needed
        return redirect()->back()->with('error', 'Database error.');
    }
}
}