<div class="px-8">
    <div>
        <div class="mt-2 text-xl text-gray-200">
            Add New Teacher
        </div>
        <a href="{{route('listTeacher')}}">
            <span class="relative mt-2 text-sm text-gray-300">
            <span class="absolute">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
          </svg>
            </span>
        <span class="px-8"> Back to teachers</span>
            </span>
        </a>
    </div>
    <div class="h-screen py-10 ">
        <div class="bg-white rounded-md ">
            <livewire:tenant.teacher.add-teacher />
        </div>
    </div>
</div>

