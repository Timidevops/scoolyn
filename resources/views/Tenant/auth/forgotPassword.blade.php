
@extends('Tenant.layouts.main')
@section('headerMeta')
@endsection
@section('topNav')
@endsection
@section('content')
    <div class="min-h-screen bg-white flex">

        <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
            <h1 class="my-6 text-3xl text-blue-100 uppercase">
                {{$schoolName}}
            </h1>
            <div class="mx-auto w-full max-w-sm lg:w-96">
                <div>

                    <div class="flex items-center mt-6">
            <span class=" text-3xl font-extrabold text-blue-100">
                Forgot password
            </span>
                    </div>
                    <p class="mt-2 text-sm text-gray-300">
                        Enter account email to get reset password link.
                    </p>
                </div>

                <div class="mt-8">
                    <div class="mt-6">
                        <form action="{{route('forgotPassword')}}" method="post" class="space-y-6">
                            @csrf
                            <div>
                                <label for="email" class="block text-sm font-normal text-gray-300">
                                    Email address
                                </label>
                                <div class="mt-1">
                                    <input id="email" name="email" type="email" autocomplete="email" required class="appearance-none block w-full px-3 py-2 border @error('email') border-red-100 @else border-gray-300 @enderror rounded-full shadow-sm placeholder-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Enter your email">
                                    @error('email')
                                    <p class="text-red-100 text-sm font-bold">
                                        {{$message}}
                                    </p>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex items-center justify-end">
                                <div class="text-sm">
                                    <a href="{{route('loginForm')}}" class="font-medium text-blue-100 hover:text-indigo-500">
                                        Back to Login
                                    </a>
                                </div>
                            </div>

                            <div>
                                <input type="submit" value="Submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-full shadow-sm text-sm font-medium text-white bg-blue-100 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="hidden lg:block relative w-0  flex-1 bg-blue-100">
            <div class="">
                <img height="490"  class="absolute inset-0 py-8 px-8 h-full" src="{{ $sideImage ? $sideImage->setting_value : asset('images/Group 281.png')}}" alt="side image">
            </div>
        </div>
    </div>
@endsection
