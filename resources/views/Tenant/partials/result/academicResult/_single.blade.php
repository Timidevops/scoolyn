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
    <a href="{{route('listAcademicResult')}}"><span class="mt-2  text-sm text-gray-300">/!/ Academic Result</span></a>
</div>

<div class="h-screen py-10">
    <div class="bg-white rounded-md ">
        <div>
            @if( $broadsheetStatus != \App\Models\Tenant\AcademicBroadSheet::APPROVED_STATUS )

                @if( $broadsheetStatus != \App\Models\Tenant\AcademicBroadSheet::NOT_APPROVED_STATUS )
                    <form class="flex justify-end px-4 py-4" action="{{route('academicResultApproval',$classSubject->uuid)}}" method="post">
                        @csrf
                        <button name="{{\App\Models\Tenant\AcademicBroadSheet::NOT_APPROVED_STATUS}}" type="submit" class="text-gray-200 border border-gray-20 rounded py-2 px-4  text-sm flex items-center mx-2">
                            <span class="mx-1">Disapprove</span>
                            <span class="mx-1">
                          /!/
                    </span>
                        </button>
                        <button name="{{\App\Models\Tenant\AcademicBroadSheet::APPROVED_STATUS}}" type="submit" class="text-white bg-blue-100 rounded py-2 px-4  text-sm flex items-center mx-2">
                            <span class="mx-1">Approve</span>
                            <span class="mx-1">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-100" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </span>
                        </button>
                    </form>
                @endif

            @else
                <div class="px-4 py-4">
                    <p class="capitalize">Broadsheet approved.</p>
                </div>
            @endif
        </div>
        @if( $broadsheetStatus == \App\Models\Tenant\AcademicBroadSheet::NOT_APPROVED_STATUS )
            @include('Tenant.partials.result.helpers.form.editBroadsheetWithSaveAndSubmitButton')
        @else
            <!-- broadsheet table with grades -->
            @include('Tenant.partials.result.helpers.table.broadsheetTableWithGrade')
            <!--/: broadsheet table with grades -->
        @endif
    </div>
</div>

