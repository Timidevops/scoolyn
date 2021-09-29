<div x-data="schoolDetails()">
  <div class="md:flex bg-purple-100" >
    <div class="bg-white md:w-96">
        <div class="py-8 ">
          <div class="flex items-center flex-shrink-0 md:px-10 px-4 md:py-12 text-blue-100 medium text-3xl">
            {{-- <img class="h-8 w-auto" src="" alt="Scoolyn"> --}}
          Scoolyn
          </div>
          <nav class="hidden md:block mt-28 flex-1" aria-label="Sidebar">
            <div class="md:px-8 px-2 space-y-8">
              <button class="text-gray-300 flex items-center px-2 py-2 space-x-4 text-sm font-medium rounded-md"
              x-on:click="Open=false">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" :class="{'text-green-200': Open==true}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>School's Information</span>
              </button>

              <button class="text-gray-300 flex items-center px-2 py-2 space-x-4 text-sm font-medium rounded-md"
              >
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" :class="{'text-green-200': submit==true, 'text-gray-300': Open==false,}" :class="{'text-gray-300': Open==true}"   fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  <span>Account Information</span>
              </button>
            </div>
          </nav>
          <nav class="md:hidden pb-4 px-2" aria-label="Sidebar">
            <div class="flex items-center w-full ">
              <button class="text-gray-300 flex items-center px-2 py-2 space-x-4 text-sm font-medium rounded-md"
               x-on:click="Open=false">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" :class="{'text-green-200': Open==true}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>School's Information</span>
              </button>

              <button class="text-gray-300 flex items-center px-2 py-2 space-x-4 text-sm font-medium rounded-md"
              x-on:click="submit=false">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" :class="{'text-green-200': submit==true}" fill="none"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  <span>Account Information</span>
              </button>
            </div>
          </nav>
        </div>
      </div>
    <div class="bg-purple-100 w-full h-full md:h-screen">
        <div class="px-4 sm:px-6 lg:px-8 pt-8">
            <div class="md:mt-14 mb-4">
              <div class="mt-2 text-xl text-blue-100 medium">
                Onboarding Setup
              </div>
          </div>
       <form action="{{route('storeAppOnboarding',$id)}}" method="post">
           @if($errors->any())
           <div class="mt-1 mb-5 bg-red-100 p-5">
               @foreach ($errors->all() as $error)
                   <p class="text-white">
                       {!! $error !!}
                   </p>
               @endforeach
           </div>
           @endif
           @csrf
           <div :class="{'hidden': Open}">
             @include('tenant.welcome.schoolDetails.partials._accountRegistration')
            </div>
        <div>
          @include('tenant.welcome.schoolDetails.partials._signUp')
        </div>
       </form>
    </div>
      </div>
</div>
</div>
<script>
  function schoolDetails() {
      return {
          Open: false,
          submit: false,
          accountRegistration: true,
          hasPayment: 'yes',
          paymentCurrency: 'ngn',
          schoolName: '{{old('schoolName')}}',
          schoolDomain: '',
          getDomain(input, value=false){
              let url;
              url =  ! this.schoolDomain  ? this.schoolName : this.schoolDomain;
              if(value){
                   url = input.target.value ? input.target.value : this.schoolName;
                   this.schoolDomain = url;
              }
              document.getElementById('domainName').value = url.toLowerCase().replace(' ', '-');
          }
      }
  }
</script>
