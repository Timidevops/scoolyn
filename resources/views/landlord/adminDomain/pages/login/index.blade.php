@extends('landlord.layouts.auth')

@section('pageContent')
    <div class="min-h-screen bg-white flex">
        <div class="w-full flex flex-wrap justify-center content-center">
            <div class="w-1/3">
                <div>
                    <h1 class="my-6 text-3xl text-blue-100 uppercase">
                        Login
                    </h1>
                </div>
                <div class="mt-6">
                    <form action="{{route('landlordLogin')}}" method="post">
                        @csrf
                        <div class="space-y-6">
                            <div>
                                <label for="email" class="block text-sm font-normal text-gray-300">
                                    Email address
                                </label>
                                <div class="mt-1">
                                    <input id="email" name="email" type="email" autocomplete="email" required class="appearance-none block w-full px-3 py-2 border @error('email') border-red-100 @else border-gray-300 @enderror rounded-full shadow-sm placeholder-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    @error('email')
                                    <p class="text-red-100 text-sm font-bold">
                                        {{$message}}
                                    </p>
                                    @enderror
                                </div>
                            </div>
                            <div>
                                <label for="password" class="block text-sm font-normal text-gray-300">
                                    Password
                                </label>
                                <div class="mt-1">
                                    <input id="password" name="password" type="password" autocomplete="email" required class="appearance-none block w-full px-3 py-2 border @error('password') border-red-100 @else border-gray-300 @enderror rounded-full shadow-sm placeholder-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    @error('password')
                                    <p class="text-red-100 text-sm font-bold">
                                        {{$message}}
                                    </p>
                                    @enderror
                                </div>
                            </div>
                            <div>
                                <input type="submit" value="Login" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-full shadow-sm text-sm font-medium text-white bg-blue-100 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
