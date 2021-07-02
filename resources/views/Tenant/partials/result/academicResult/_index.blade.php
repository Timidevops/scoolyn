<div class="mt-2 text-xl text-gray-200">
    <div class="flex ">
        Academic Result:
        <div class="pl-2">
            <span>{{$classTeacher->schoolClass->class_name}}</span>
            <span class="font-medium text-xs text-gray-200">
                {{$classTeacher->classSectionType ? "| {$classTeacher->classSectionType->section_name}" : ''}}
                {{$classTeacher->classSectionCategoryType ? "| {$classSubject->classSectionCategoryType->category_name}" : ''}}
                </span>
        </div>
    </div>
</div>

<div class="h-screen py-10">
    <div class="bg-white rounded-md ">
        <livewire:tenant.result.academic-result.index :classArm="$classTeacher" :classSubjects="$classSubjects" />
    </div>
</div>
