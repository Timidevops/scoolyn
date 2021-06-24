<div>
    <div class="mt-2 text-xl text-gray-200">
        <div class="flex ">
            Broadsheet:
            <div class="pl-2">
                <span>{{$classSubject->subject->subject_name}}</span>
                <span class="font-medium text-xs text-gray-200">
                    {{$classSubject->schoolClass->class_name}}
                    {{$classSubject->classSectionType ? "| {$classSubject->classSectionType->section_name}" : ''}}
                    {{$classSubject->classSectionCategoryType ? "| {$classSubject->classSectionCategoryType->category_name}" : ''}}
                </span>
            </div>
        </div>
    </div>
    <a href="{{route('listAcademicBroadsheet')}}"><span class="mt-2  text-sm text-gray-300">/!/ Broadsheets</span></a>
</div>

<div class="h-screen py-10">
    <div class="bg-white rounded-md ">
        <div class="px-4 py-4">
            @if( $broadsheetStatus != \App\Models\Tenant\AcademicBroadSheet::APPROVED_STATUS )
                <p class="text-gray-300">Broadsheet submitted, <span class="italic text-blue-100">awaiting approval from class teacher.</span></p>
            @else
                <p>Broadsheet submitted and approved.</p>
            @endif
        </div>
        <!-- broadsheet table with grades -->
            @include('.Tenant.partials.result.helpers.table.broadsheetTableWithGrade')
        <!--/: broadsheet table with grades -->
    </div>
</div>


