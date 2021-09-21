<div class="lg:px-8">
    <div class="mt-2 text-xl text-gray-200">
        <div class="flex ">
            Upload Student
        </div>
    </div>
    <a href="{{route('listStudent')}}"><span class="mt-2  text-sm text-gray-300">/!/ Students</span></a>
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

