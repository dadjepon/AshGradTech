@extends('layouts.appLR')

@section('content')
        <!-- Form -->
        <div class="sm:w-1/2 px-16 sm:mt-8">
            <img class="w-20 flex items-center ml-20 mb-5" src="images/symbol2.png" alt="Logo"/>
            <h1 class="font-extrabold text-3xl text-center">Welcome back!</h1>
            <p class="mt-3 font-normal">Already have an account?</p>
            <p class="font-normal">Enter your details below to log in</p>
            @if (session('status'))
                <div class="bg-red-500 p-4 rounded-lg mb-6 text-white text-center">
                    {{ session('status') }}
                </div>
            @endif 
            <!-- Input form -->
            <form action="{{route('login')}}" method="POST" class="flex flex-col gap-5 mt-6">
            
            <!-- Cross site request forgery -->
            @csrf
            <div>
                <label for="email" class="sr-only">Email</label> 
                <input class="p-2 w-full rounded-xl border-2 bg-inputColor @error('email') border-red-500 @enderror" value="{{old('email')}}" type="text" name="email" id="email" placeholder="Your email" >
            
                @error('email')
                    <div class="text-red-500 mt-2 text-sm">
                        {{$message}}
                    </div>
                @enderror
            </div>

            <div>
                <label for="password" class="sr-only">Password</label> 
                <input class="p-2 w-full rounded-xl border-2 bg-inputColor @error('password') border-red-500 @enderror" type="password" name="password" id="password"placeholder="Password" value="">
            
            @error('password')
                <div class="text-red-500 mt-2 text-sm">
                    {{$message}}
                </div>
            @enderror
            </div>
            <div>
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="mr-2">
                    <label for="remember">Remember me</label>
                </div>
            </div>
            <div>
                <button type="submit" class=" mt-1 px-4 py-3 rounded
                    font-medium w-full bg-[#63474D] p-2 text-backgroundColor rounded-xl text-white">Login</button>
            </div>
            
            </form>


            <!-- Don't have an account? -->
            <div class="mt-5">Don't have an account? <a href="{{route('register')}}" class="inline font-bold">Sign up</div>
        </div>

        <!-- Image -->
        <div class="sm:block hidden sm:w-96 w-1/2">
            <img class="rounded-2xl" src="images/LoginImage.jpeg" alt="Temporary Image"/>
        </div>
    </div>
@endsection