<div class="px-4 sm:px-6 lg:px-8">
  <div class="md:mt-8 mb-4">
    <div class="mt-2 text-xl text-gray-200">
        Classes
    </div>
    <span class="mt-2 text-base text-gray-300">{{$totalClass}} Total Classes</span>
</div>
<div class="bg-white rounded-md">
<div class="md:flex md:items-center md:mt-2 ">
<div class="py-6 px-2 relative w-full">
    <div class="">
     <input type="search" name="" id="" class="py-3 px-10 w-full border border-purple-100 rounded-md  bg-white"  placeholder="Search">
     <span class="absolute inset-y-0 left-0 pl-6 py-10"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
     </svg>
   </span>
    </div>

   </div>
    {{-- modal --}}
    <livewire:tenant.classes.add-class-section />
    {{-- modal --}}
</div>

@include('Tenant.partials.class._classTable')
</div>
</div>
