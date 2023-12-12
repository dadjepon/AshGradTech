@extends('layouts.appLR')

@section('content')
    
        <!-- Form -->
        <div class="sm:w-1/2 px-16 sm:mt-8">
            <img class="w-20 ml-20 mb-5" src="images/symbol1.png" alt="Logo"/>
            <h1 class="font-extrabold text-3xl text-center">Sign up!</h1>
            <p class="mt-5 font-normal">Enter your details below to create</p>
            <p class="font-normal">an account and get started!</p>

            <!-- Input form -->
            <form action="{{route('register')}}" method="POST" class="flex flex-col gap-4 mt-6" >
            @csrf
            <div>
                <label for="name" class="sr-only">Name</label>
                <input id="name" class="w-full p-2 rounded-xl border bg-inputColor @error('name') border-red-500 @enderror" value="{{old('name')}}" type="text" name="name" placeholder="Your name" />
                @error('name')
                <div class="text-red-500 mt-2 text-sm">
                    {{$message}}
                </div>
                @enderror
            </div> 

            <div>
                <label for="email" class="sr-only">Email</label>
                <input type="email" id="email" class=" w-full p-2 rounded-xl border bg-inputColor @error('email') border-red-500 @enderror" value="{{old('email')}}" name="email" placeholder="Email" />
                @error('email')
                <div class="text-red-500 mt-2 text-sm">
                    {{$message}}
                </div>
                @enderror
            </div> 
            <div>
                <label for="password" class="sr-only">Password</label>
                <input type="password" id="password" class="p-2 w-full rounded-xl border bg-inputColor @error('password') border-red-500 @enderror" value="" name="password" placeholder="Your Password" />
                @error('password')
                <div class="text-red-500 mt-2 text-sm">
                    {{$message}}
                </div>
                @enderror
            </div> 

            <div>
                <label for="password_confirmation" class="sr-only">Password Again</label>
                <input type="password" id="password_confirmation" class="p-2 w-full rounded-xl border bg-inputColor @error('password_confirmation') border-red-500 @enderror" value="" name="password_confirmation" placeholder="Repeat Password" />
                @error('password_confirmation')
                <div class="text-red-500 mt-2 text-sm">
                    {{$message}}
                </div>
                @enderror
            </div> 
                <div class="grid gap-2 grid-cols-2 w-64">
                    <label for="StudentId" class="sr-only">StudentID</label>
                    <input value="" class="p-2 rounded-xl border bg-inputColor @error('StudentId') border-red-500 @enderror" type="text" name="StudentId" placeholder="StudentId"/>
                    @error('StudentId')
                        <div class="text-red-500 mt-2 text-sm">
                            {{$message}}
                        </div>
                    @enderror
                    <label for="major" class="sr-only">Major</label>
                    <select name="major" id="majors" class="p-2 rounded-xl border bg-inputColor @error('major') border-red-500 @enderror">
                        <option selected disabled hidden>Majors</option>
                        <option value="CS">Computer Science</option>
                        <option value="MIS">Management Information Systems</option>
                        <option value="CE">Computer Engineering</option>
                        <option value="ME">Mechanical Engineering</option>
                        <option value="EE">Electrical Engineering</option>
                        <option value="BA">Business Administration</option>
                    </select>
                </div>
                <div class="mt-8">
                    <button type="submit" class=" mt-1 px-4 py-3 rounded
                    font-medium w-full bg-[#63474D] p-2 text-backgroundColor rounded-xl text-white">SignUp</button>
            </div>
            </form>
        </div>

        <div class="sm:block hidden sm:w-96 w-1/2">
            <img class="rounded-2xl" src="images/LoginImage.jpeg" alt="Temporary Image"/>
        </div>
    </div>
@endsection