<div>
    <div class="mt-2 text-xl text-gray-200">
      Student
    </div>
    <span class="mt-2 text-base text-gray-300">{{$totalStudents}} Total Subjects</span>
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
   <a href="{{route('createStudent')}}" class="bg-blue-100 text-white rounded-md py-3 mx-2 md:w-1/4   text-sm flex items-center" >
    <span class="mx-2">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
    </span>
      <span class="mx-2">Add Student</span>
  </a>
</div>

@include('Tenant.partials.users.student._studentTable')
</div>
