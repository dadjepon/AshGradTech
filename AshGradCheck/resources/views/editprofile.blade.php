<!-- resources/views/edit_profile.blade.php -->




    <div class="container">
        <h1>Edit Profile</h1>
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div>
                <label for="major">Major</label>
                <input type="text" name="major" value="{{ old('major', $user->major) }}">
                @error('major')
                    <span>{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="studentId">Student ID</label>
                <input type="text" name="studentId" value="{{ old('studentId', $user->studentId) }}">
                @error('studentId')
                    <span>{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="password">Password</label>
                <input type="password" name="password">
                @error('password')
                    <span>{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" name="password_confirmation">
            </div>

            <div>
                <label for="profile_image">Profile Image</label>
                <input type="file" name="profile_image">
                @error('profile_image')
                    <span>{{ $message }}</span>
                @enderror
            </div>

            <button type="submit">Update Profile</button>
        </form>
    </div>


    <!-- File List Container -->
