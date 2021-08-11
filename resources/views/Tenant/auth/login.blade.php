{{-- 
<h3>Login</h3>

<form action="{{route('login')}}" method="post">
    @csrf
    <input type="email" placeholder="email" name="email">
    <input type="password" placeholder="password" name="password">
    <input type="submit" value="Login">
</form> --}}

  

  @extends('Tenant.layouts.main')
@section('headerMeta')
@endsection
@section('topNav')
@endsection
@section('content')
<div class="min-h-screen bg-white flex">
   
    <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
        <div class="my-6 text-3xl text-blue-100">Scoolyn</div>
      <div class="mx-auto w-full max-w-sm lg:w-96">
        <div>
          
         <div class="flex items-center mt-6">
            <span class=" text-3xl font-extrabold text-blue-100">
                Login 
            </span>
            <span><img src="/images/icons8-hand-peace-skin-type-4-100.png" alt=""></span>
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
                  Email address
                </label>
                <div class="mt-1">
                  <input id="email" name="email" type="email" autocomplete="email" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-full shadow-sm placeholder-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Enter your email">
                </div>
              </div>
  
              <div class="space-y-1">
                <label for="password" class="block text-sm font-medium text-gray-300">
                  Password
                </label>
                <div class="mt-1">
                  <input id="password" name="password" type="password" autocomplete="current-password" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-full shadow-sm placeholder-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Enter your password">
                </div>
              </div>
  
              <div class="flex items-center justify-end">  
                <div class="text-sm">
                  <a href="#" class="font-medium text-blue-100 hover:text-indigo-500">
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
        <img class="absolute inset-0 py-8 px-8 h-full" src="images/Group 281.png" alt="">
     </div>
    </div>
  </div>
@endsection