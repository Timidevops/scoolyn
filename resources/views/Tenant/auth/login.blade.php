
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
          @if(session()->has('flashMessage'))
             <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
              <div class="flex">
                  <div class="flex-shrink-0">
                      <!-- Heroicon name: solid/exclamation -->
                      <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                          <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                      </svg>
                  </div>
                  <div class="ml-3">
                      <p class="text-sm text-blue-700">
                          {{ session()->get('flashMessage') }}
                      </p>
                  </div>
              </div>
          </div>
          @endif
        <div>

         <div class="flex items-center mt-6">
            <span class=" text-3xl font-extrabold text-blue-100">
                Login
            </span>
            <span><img src="{{asset('/images/icons8-hand-peace-skin-type-4-100.png')}}" alt=""></span>
         </div>
          <p class="mt-2 text-sm text-gray-300">
            Welcome back, enter details to continue.
          </p>
        </div>
        <div class="mt-8">
          <div class="mt-6">
            <form action="{{route('login')}}" method="post" class="space-y-6">
                @csrf
              <div>
                <label for="email" class="block text-sm font-normal text-gray-300">
                  Email or Phone number
                </label>
                <div class="mt-1">
                  <input id="email" name="email" required class="appearance-none block w-full px-3 py-2 border @error('email') border-red-100 @else border-gray-300 @enderror rounded-full shadow-sm placeholder-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Enter your email">
                    @error('email')
                        <p class="text-red-100 text-sm font-bold">
                            {{$message}}
                        </p>
                    @enderror
                </div>
              </div>

              <div class="space-y-1">
                <label for="password" class="block text-sm font-medium text-gray-300">
                  Password
                </label>
                <div class="mt-1">
                  <input id="password" name="password" type="password" autocomplete="current-password" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-full shadow-sm placeholder-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Enter your password">
                    @error('password')
                    <p class="text-red-100 text-sm font-bold">
                        {{$message}}
                    </p>
                    @enderror
                </div>
              </div>

              <div class="flex items-center justify-end">
                <div class="text-sm">
                  <a href="{{route('forgotPasswordForm')}}" class="font-medium text-blue-100 hover:text-indigo-500">
                    Forgot your password?
                  </a>
                </div>
              </div>

              <div>
                <input type="submit" value="Login" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-full shadow-sm text-sm font-medium text-white bg-blue-100 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
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
