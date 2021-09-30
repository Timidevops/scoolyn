<div class="lg:px-8">
    <div class="mt-2 text-xl text-gray-200">
        <div class="flex ">
            Add new student
        </div>
    </div>
    <a href="{{route('listStudent')}}" class="flex space-x-1 items-center mt-2">
        <span class=" text-sm text-gray-300 ">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
            </svg>
        </span>
        <span class="text-sm text-gray-300">Students</span>
    </a>
</div>


<div class="h-screen py-10 lg:px-8">
<div class="bg-white rounded-md " >
    <div class="flex justify-end px-4 py-4">
       <a href="{{route('uploadStudent')}}" class="bg-blue-100 text-white rounded-md py-3 px-2 mx-2 md:w-1/5 text-sm text-center">
           Bulk upload
      </a>
    </div>
    <livewire:tenant.student.add-student />
</div>
</div>

