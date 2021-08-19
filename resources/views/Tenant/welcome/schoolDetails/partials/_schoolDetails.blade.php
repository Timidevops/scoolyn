<div x-data="schoolDetails()">
  <div class="md:flex bg-purple-100" :class="{'lg:hidden md:hidden sm:hidden': submit==true}">
    <div class="bg-white md:w-96">
        <div class="py-8 ">
          <div class="flex items-center flex-shrink-0 md:px-10 px-4 md:py-12 text-blue-100 medium text-3xl">
            {{-- <img class="h-8 w-auto" src="" alt="Scoolyn"> --}}
          Scoolyn
          </div>
          <nav class="hidden md:block mt-28 flex-1" aria-label="Sidebar">
            <div class="md:px-8 px-2 space-y-8"> 
              <div class="text-gray-300 flex items-center px-2 py-2 space-x-4 text-sm font-medium rounded-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" :class="{'text-green-200 bold': Open==true}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Account Registration</span>
              </div>
 
              <div class="text-gray-300 flex items-center px-2 py-2 space-x-4 text-sm font-medium rounded-md">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" :class="{'text-green-200 bold': submit==true}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  <span>Signup details</span>
              </div>

                <div class="text-gray-300 flex items-center px-2 py-2 space-x-4 text-sm font-medium rounded-md"> 
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" :class="{'text-green-200 bold': submit==true}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  <span>Dashboard</span>
              </div> 
            </div>
          </nav>
          <nav class="md:hidden pb-4 px-2" aria-label="Sidebar">
            <div class="flex items-center w-full "> 
              <div class="text-gray-300 flex items-center px-2 py-2 space-x-4 text-sm font-medium rounded-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Account Registration</span>
              </div>
    
              <div class="text-gray-300 flex items-center px-2 py-2 space-x-4 text-sm font-medium rounded-md">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  <span>Signup details</span>
              </div>
    
                <div class="text-gray-300 flex items-center px-2 py-2 space-x-4 text-sm font-medium rounded-md"> 
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  <span>Dashboard</span>
              </div> 
            </div>
          </nav>
        </div> 
      </div> 
    <div class="bg-purple-100 w-full h-full md:h-screen">
        <div class="px-4 sm:px-6 lg:px-8 pt-8">
            <div class="md:mt-14 mb-4">
              <div class="mt-2 text-xl text-blue-100 medium">
                School Details
              </div> 
          </div> 
       <form>
           <div :class="{'hidden': Open}">
             @include('Tenant.welcome.schoolDetails.partials._accountRegistration')
            </div>
        <div
        >
          @include('Tenant.welcome.schoolDetails.partials._signUp')
        </div>
       </form> 
    </div> 
      </div> 
</div>
      <div 
      x-show="submit" 
      x-transition:enter="transition-transition ease-out duration-200" 
      x-transition:enter-start="opacity-0 translate-y-1" 
      x-transition:enter-end="opacity-100 translate-y-0"
      x-transition:leave="transition ease-in duration-150"
      x-transition:leave-end="opacity-0 translate-y-1">
        @include('Tenant.welcome.schoolDetails.partials._welcome')
    </div>
</div>
<script> 
  function schoolDetails(){
      return{
      Open:false,  
      submit:false,
      // Show:false,
      }
      }
</script>