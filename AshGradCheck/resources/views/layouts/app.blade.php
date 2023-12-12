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
<body>

    <!-- Navbar HTML -->
    <div class="fixed w-full z-10">
        <div>
            <div class="lg:bg-transparent bg-gray-200 flex flex-row justify-between p-5 lg:px-32 px-5">
                <div class="flex flex-row items-center cursor-pointer gap-2">
                    <span>
                        <!-- You can replace this with your actual icon or logo -->
                        <img src="/images/graduate.svg" alt="Logo" class="w-12 h-8">
                    </span>
                    <h1 class="text-xl font-semibold">AshGradCheck</h1>
                </div>

                <nav class="hidden md:flex flex-row items-center text-sm font-small gap-8">
                    <a href="#graduationtracker" class="group relative inline-block cursor-pointer hover:text-gray-700">
                        Graduation Tracker
                        <span class="absolute inset-x-0 bottom-0 h-0.5 bg-black transform scale-x-0 origin-left transition-transform group-hover:scale-x-100"></span>
                    </a>
                    <a href="#advisorportal" class="group relative inline-block cursor-pointer hover:text-gray-700">
                        Advisor Portal
                        <span class="absolute inset-x-0 bottom-0 h-0.5 bg-black transform scale-x-0 origin-left transition-transform group-hover:scale-x-100"></span>
                    </a>
                    <a href="#transcriptupload" class="group relative inline-block cursor-pointer hover:text-gray-700">
                        Transcript Upload
                        <span class="absolute inset-x-0 bottom-0 h-0.5 bg-black transform scale-x-0 origin-left transition-transform group-hover:scale-x-100"></span>
                    </a>
                </nav>

                <div class="hidden lg:flex">
                    <!-- Replace this with your actual button or login functionality -->
                <a href="{{route('login')}}"><button class="p-3">Login</button></a>
                </div>

                <div class="md:hidden flex items-center">
                    <!-- Replace this with your actual menu toggle functionality -->
                    <button id="menuToggleBtn" class="p-3" onclick="toggleMenu()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            class="h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <div id="mobileMenu"
                class="lg:hidden flex flex-col absolute bg-orange-100 text-black-800 left-0 top-16 font-light text-2xl text-center pt-8 pb-4 gap-8 w-full h-fit transition-transform duration-300 transform translate-x-full hidden">
                <a href="#graduationtracker"
                    class="hover:text-gray-700 text-black transition-all cursor-pointer" onclick="closeMenu()">
                    Graduation Tracker
                </a>
                <a href="#advisorportal"
                    class="hover:text-gray-700 text-black transition-all cursor-pointer" onclick="closeMenu()">
                    Advisor Portal
                </a>
                <a href="#transcriptupload"
                    class="hover:text-gray-700 text-black transition-all cursor-pointer" onclick="closeMenu()">
                    Transcript Upload
                </a>
                <a href="{{route('login')}}"><button class="p-3">Login</button></a>
            </div>
        </div>
    </div>
    <!-- Hero HTML -->
    <div class="bg-cover bg-no-repeat h-screen flex flex-col justify-center lg:flex-row lg:justify-between items-center lg:px-32 px-5 gap-10 bg-backgroundColor overflow-hidden" style="background-image: url('/images/LandingPage.jpeg');">
        <div class="w-full space-y-8 mt-14 lg:mt-0">
            <h1 class="font-extrabold text-5xl text-center lg:text-start leading-tight sm:text-6xl">
                Uncover and explore the path that leads to your ultimate success and fulfillment.
            </h1>
            <!-- <span class="font-semibold text-5xl text-center">
                  to Success
                </span> -->
            <p class="font-regular text-sm text-center lg:text-end leading-tight">
                Empowering Your Academic Journey at Ashesi University. Simplifying
                Degree Auditing,<br/> Enhancing Advisor Interaction, and Streamlining
                Graduation Tracking. Our Aim is to<br/> Empower Students with Seamless
                Academic Progression and Success
            </p>
            <p class="font-bold text-sm text-center lg:text-end leading-tight">
                <!-- Replace this with your actual button or link for signup -->
                <a href="{{route('login')}}"><button class="bg-blue-500 text-white px-4 py-2 rounded-md">Join Us. Get Started</button></a>
            </p>
        </div>
    </div>

    <script>
        function toggleMenu() {
            var mobileMenu = document.getElementById('mobileMenu');
            mobileMenu.classList.toggle('hidden');
            mobileMenu.classList.toggle('translate-x-full');

            // Toggle menu icon based on menu visibility
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

            // Reset menu icon to the default menu icon
            var menuToggleBtn = document.getElementById('menuToggleBtn');
            menuToggleBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">' +
                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>';
        }
    </script>

<!-- @yield('content') -->

<!-- Include Dropzone.js script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/6.0.0-beta.2/dropzone-min.js" integrity="sha512-FFyHlfr2vLvm0wwfHTNluDFFhHaorucvwbpr0sZYmxciUj3NoW1lYpveAQcx2B+MnbXbSrRasqp43ldP9BKJcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>    <!-- Your custom scripts section -->
<!-- @yield('scripts') -->
</body>
</html>

