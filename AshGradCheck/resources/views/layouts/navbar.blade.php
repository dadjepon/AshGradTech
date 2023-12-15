<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POST-IT</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Include Dropzone.js CSS -->
    <link href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('resources/css/admin.css') }}">    
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
</head>


<body>
<div class="w-full z-10">
    <div class="lg:bg-transparent bg-gray-200 flex flex-row justify-between p-5 lg:px-15 px-5"> 
        <div class="flex flex-row items-center cursor-pointer gap-2 ml-2"> 
        <span>
        <!-- You can replace this with your actual icon or logo -->
        <img src="/images/graduate.svg" alt="Logo" class="w-12 h-8">
    </span>
    <h1 class="text-xl font-semibold">AshGradCheck</h1>
</div>

    

<div class="hidden md:flex items-center justify-center gap-20">
    @auth
        <a href="{{route('dashboard')}}"
            class="group relative inline-block cursor-pointer hover:text-gray-700">
            Dashboard
            <span
                class="absolute inset-x-0 bottom-0 h-0.5 bg-black transform scale-x-0 origin-left transition-transform group-hover:scale-x-100"></span>
        </a>
        <a href="#advisorportal"
            class="group relative inline-block cursor-pointer hover:text-gray-700">
            Reports
            <span
                class="absolute inset-x-0 bottom-0 h-0.5 bg-black transform scale-x-0 origin-left transition-transform group-hover:scale-x-100"></span>
        </a>
    @endauth
</div>


            <div class="hidden lg:flex items-center ml-4">
                @auth
                    <img id="avatarButton" type="button" data-dropdown-toggle="userDropdown"
                        data-dropdown-placement="bottom-start"
                        class="w-10 h-10 p-1 rounded-full ring-2 ring-gray-300 dark:ring-gray-500 ml-6"
                        src="images/Thomas' profile.jpg" alt="User dropdown">
                    
                    <div data-dropdown-toggle="userDropdown"
                        data-dropdown-placement="bottom-start" type="button" id="avartarButton"class="mr-2 ml-2 p-2" style="cursor:pointer">{{ auth()->user()->name }}</div>

                    <!-- Dropdown menu -->
                    <div id="userDropdown"
                        class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                        <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                            <div>{{ auth()->user()->name }}</div>
                            <div class="font-medium truncate overflow-ellipsis max-w-[155px]">{{ auth()->user()->email }}</div>
                        </div>
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="avatarButton">
                            <li>
                                <a href="{{route('dashboard')}}}}"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Dashboard</a>
                            </li>
                            <li>
                                <a href="{{route('profile.edit')}}"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Settings</a>
                            </li>
                        </ul>
                        <div class="py-1">
                            <form action="{{ route('logout')}}" method="POST">
                                @csrf
                                <button class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <button class="p-3">Login</button>
                @endauth
            </div>

            <div class="md:hidden ml-8"> 
            @auth
                <img id="mobileAvatarButton" type="button" data-dropdown-toggle="mobileUserDropdown"
                data-dropdown-placement="bottom-start"
                class="w-10 h-10 p-1 rounded-full ring-2 ring-gray-300 dark:ring-gray-500"
                src="images/Thomas' profile.jpg" alt="User dropdown">

                    <!-- Dropdown menu -->
                    <div id="mobileUserDropdown"
                        class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                        <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                            <div>{{ auth()->user()->name }}</div>
                            <div class="font-medium truncate overflow-ellipsis max-w-[155px]">{{ auth()->user()->email }}</div>
                        </div>
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="avatarButton">
                            <li>
                                <a href="{{route('dashboard')}}}}"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Dashboard</a>
                            </li>
                            <li>
                                <a href="#"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Settings</a>
                            </li>
                        </ul>
                        <div class="py-1">
                            <form action="{{ route('logout')}}" method="POST">
                                @csrf
                                <button class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <button id="menuToggleBtn" class="p-3" onclick="toggleMenu()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            class="h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                    </button>
                @endauth
            </div>
        </div>

        <div id="mobileMenu"
            class="lg:hidden flex flex-col absolute bg-orange-100 text-black-800 left-0 top-16 font-light text-2xl text-center pt-8 pb-4 gap-8 w-full h-fit transition-transform duration-300 transform translate-x-full hidden">
            @auth
                <a href="#graduationtracker"
                    class="hover:text-gray-700 text-black transition-all cursor-pointer"
                    onclick="closeMenu()">
                    Dashboard
                </a>
                <a href="#advisorportal"
                    class="hover:text-gray-700 text-black transition-all cursor-pointer"
                    onclick="closeMenu()">
                    Reports
                </a>
            @else
                <a href="#graduationtracker"
                    class="hover:text-gray-700 text-black transition-all cursor-pointer"
                    onclick="closeMenu()">
                    Graduation Tracker
                </a>
                <a href="#advisorportal"
                    class="hover:text-gray-700 text-black transition-all cursor-pointer"
                    onclick="closeMenu()">
                    Advisor Portal
                </a>
                <a href="#transcriptupload"
                    class="hover:text-gray-700 text-black transition-all cursor-pointer"
                    onclick="closeMenu()">
                    Transcript Upload
                </a>
                <a href="{{route('login')}}"><button class="p-3">Login</button></a>
            @endauth
        </div>
    </div>
    @yield('content')

    <script>
        function toggleMenu() {
            var mobileMenu = document.getElementById('mobileMenu');
            mobileMenu.classList.toggle('hidden');
            mobileMenu.classList.toggle('translate-x-full');

            var menuToggleBtn = document.getElementById('menuToggleBtn');
            menuToggleBtn.innerHTML = mobileMenu.classList.contains('hidden') ?
                '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">' +
                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>' :
                'X';
        }

        function closeMenu() {
            var mobileMenu = document.getElementById('mobileMenu');
            mobileMenu.classList.add('hidden');
            mobileMenu.classList.add('translate-x-full');

            var menuToggleBtn = document.getElementById('menuToggleBtn');
            menuToggleBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">' +
                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>';
        }
    </script>

    <!-- Include Dropzone.js script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/6.0.0-beta.2/dropzone-min.js"
        integrity="sha512-FFyHlfr2vLvm0wwfHTNluDFFhHaorucvwbpr0sZYmxciUj3NoW1lYpveAQcx2B+MnbXbSrRasqp43ldP9BKJcg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Your custom scripts section -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript" src="filterTable.js"></script>
    @yield('scripts')

</body>

</html>