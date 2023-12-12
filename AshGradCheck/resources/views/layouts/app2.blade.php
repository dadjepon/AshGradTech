<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POST-IT</title>
    
    @vite('resources/css/app.css')

    <!-- Include Dropzone.js CSS -->
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.css"> -->
<link href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
</head>
<body class="bg-gray-200 min-h-screen m-0">
    <nav class="p-6 bg-white flex justify-between mb-10">
        <ul class="flex items-center">
            <li>
                <a href="/" class="p-3">Home</a>
            </li>
            <li>
                <a href="{{ route('dashboard')}}" class="p-3">Dashboard</a>
            </li>
            <li>
                <a href="{{route('posts')}}" class="p-3">Post</a>
            </li>
        </ul>

        <!-- User Account details -->
        <ul class="flex items-center">
            @if (auth() -> user())
                <li>
                    <a href="" class="p-3">{{auth()->user()->name}}</a>
                </li>
                <li>
                    <form action="{{route('logout')}}" method="post">
                    @csrf
                    <button type="submit" class="p-3">Logout</button>
                    </form>
                </li>
            @else
                <li>
                    <a href="{{route('login')}}" class="p-3">Login</a>
                </li>
                <li>
                    <a href="{{route('register')}}" class="p-3">Register</a>
                </li>
            @endif
        </ul>
    </nav>
    @yield('content')

    <!-- Include Dropzone.js script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/6.0.0-beta.2/dropzone-min.js" integrity="sha512-FFyHlfr2vLvm0wwfHTNluDFFhHaorucvwbpr0sZYmxciUj3NoW1lYpveAQcx2B+MnbXbSrRasqp43ldP9BKJcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @yield('scripts')
</body>
</html>
