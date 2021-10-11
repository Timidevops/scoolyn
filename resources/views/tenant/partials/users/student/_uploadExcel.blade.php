<div>
    <div class="lg:mt-2 mt-8 mb-4 lg:px-8">
        <div class="mt-2 text-xl text-gray-200">
            Upload Student
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
    <livewire:tenant.student.upload-student />
</div>

