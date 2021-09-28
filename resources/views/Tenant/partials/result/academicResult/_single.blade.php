            <div>
    <div class="mt-2 text-xl text-gray-200">
        <div class="flex ">
            Academic Result:
            <div class="pl-2">
                <span class="capitalize">{{$classArm->schoolClass->class_name}}</span>
                <span class="font-medium text-xs text-gray-200 capitalize">
                    {{$classArm->classSection ? "| {$classArm->classSection->section_name}" : ''}}
                    {{$classArm->classSectionCategory ? "| {$classArm->classSectionCategory->category_name}" : ''}}
                </span>
            </div>
        </div>
    </div>
    <a href="{{route('listAcademicResult')}}" class="flex items-center space-x-1 mt-2">
        <span class=" text-sm text-gray-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
            </svg>
        </span>
        <span class="text-sm text-gray-300">Academic results</span>
    </a>
</div>


<div class="h-screen py-10">
    <div class="bg-white rounded-md ">
        <livewire:tenant.result.academic-result.index :classArm="$classArm" :classSubjects="$classSubjects" />
    </div>
</div>
