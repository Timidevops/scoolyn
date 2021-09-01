
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
                Reset password
            </span>
                    </div>
                </div>

                <div class="mt-8">
                    <div class="mt-6">
                        <form action="{{route('resetPassword')}}" method="post" class="space-y-6">
                            @csrf
                            <input type="hidden" name="token" value="{{$token}}">
                            <div>
                                <label for="password" class="block text-sm font-normal text-gray-300">
                                    Password
                                </label>
                                <div class="mt-1">
                                    <input id="password" name="password" type="password" required placeholder="Enter new password" class="appearance-none block w-full px-3 py-2 border @error('password') border-red-100 @else border-gray-300 @enderror rounded-full shadow-sm placeholder-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    @error('password')
                                    <p class="text-red-100 text-sm font-bold">
                                        {{$message}}
                                    </p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="passwordConfirmation" class="block text-sm font-normal text-gray-300">
                                    Confirm new password
                                </label>
                                <div class="mt-1">
                                    <input id="passwordConfirmation" name="password_confirmation" type="password" placeholder="Enter confirm password" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-full shadow-sm placeholder-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                            </div>

                            <div>
                                <input type="submit" value="Reset Password" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-full shadow-sm text-sm font-medium text-white bg-blue-100 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="hidden lg:block relative w-0  flex-1 bg-blue-100">
            <div class="">
                <img class="absolute inset-0 py-8 px-8 h-full" src="{{asset('images/Group 281.png')}}" alt="">
            </div>
        </div>
    </div>
@endsection
