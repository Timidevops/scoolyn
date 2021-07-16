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
    <a href="{{route('listAcademicResult')}}"><span class="mt-2  text-sm text-gray-300">/!/ Academic results</span></a>
</div>


<div class="h-screen py-10">
    <div class="bg-white rounded-md ">
        <livewire:tenant.result.academic-result.index :classArm="$classArm" :classSubjects="$classSubjects" />
    </div>
</div>
