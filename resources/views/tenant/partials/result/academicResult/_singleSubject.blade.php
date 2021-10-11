<div>
    <div class="mt-2 text-xl text-gray-200">
        <div class="flex ">
            Broadsheet:
            <div class="pl-2">
                <span>{{$classSubject->subject->subject_name}}</span>
                <span class="font-medium text-xs text-gray-200">
                    {{$classSubject->schoolClass->class_name}}
{{--                    {{$classSubject->classSectionType ? "| {$classSubject->classSectionType->section_name}" : ''}}--}}
{{--                    {{$classSubject->classSectionCategoryType ? "| {$classSubject->classSectionCategoryType->category_name}" : ''}}--}}
                </span>
            </div>
        </div>
    </div>
    <a href="{{route('singleAcademicResult',$classArm)}}" class="flex items-center space-x-1 mt-2">
        <span class=" text-sm text-gray-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
            </svg>
        </span>
        <span class="text-sm text-gray-300">Academic Result</span>
    </a>
</div>

<div class="h-screen py-10">
    <div class="bg-white rounded-md ">
        <div>
            @if( $broadsheetStatus != \App\Models\tenant\AcademicBroadSheet::APPROVED_STATUS )

                @if( $broadsheetStatus != \App\Models\tenant\AcademicBroadSheet::NOT_APPROVED_STATUS )
                    <form class="flex justify-end px-4 py-4" action="{{route('academicResultApproval',[$classArm, $classSubject->uuid])}}" method="post">
                        @csrf
                        <button name="{{\App\Models\tenant\AcademicBroadSheet::NOT_APPROVED_STATUS}}" type="submit" class="text-gray-200 border border-gray-20 rounded py-2 px-4  text-sm flex items-center mx-2">
                            <span class="mx-1">Disapprove</span>
                            <span class="mx-1">
                          <svg class="h-4 w-4 text-blue-100 mx-2" fill="red" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                               viewBox="0 0 511.76 511.76" style="enable-background:new 0 0 511.76 511.76;" xml:space="preserve">
                                <path d="M436.896,74.869c-99.84-99.819-262.208-99.819-362.048,0c-99.797,99.819-99.797,262.229,0,362.048
                                    c49.92,49.899,115.477,74.837,181.035,74.837s131.093-24.939,181.013-74.837C536.715,337.099,536.715,174.688,436.896,74.869z
                                     M361.461,331.317c8.341,8.341,8.341,21.824,0,30.165c-4.16,4.16-9.621,6.251-15.083,6.251c-5.461,0-10.923-2.091-15.083-6.251
                                    l-75.413-75.435l-75.392,75.413c-4.181,4.16-9.643,6.251-15.083,6.251c-5.461,0-10.923-2.091-15.083-6.251
                                    c-8.341-8.341-8.341-21.845,0-30.165l75.392-75.413l-75.413-75.413c-8.341-8.341-8.341-21.845,0-30.165
                                    c8.32-8.341,21.824-8.341,30.165,0l75.413,75.413l75.413-75.413c8.341-8.341,21.824-8.341,30.165,0
                                    c8.341,8.32,8.341,21.824,0,30.165l-75.413,75.413L361.461,331.317z"/>

                            </svg>
                            </span>
                        </button>
                        <button name="{{\App\Models\tenant\AcademicBroadSheet::APPROVED_STATUS}}" type="submit" class="text-white bg-blue-100 rounded py-2 px-4  text-sm flex items-center mx-2">
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
                    <p class="capitalize">{{\App\Models\tenant\Setting::getCurrentCardBreakdownFormat(true)}} Broadsheet approved.</p>
                </div>
            @endif
        </div>
        @if( $broadsheetStatus == \App\Models\tenant\AcademicBroadSheet::NOT_APPROVED_STATUS )
            @include('tenant.partials.result.helpers.form.editBroadsheetWithSaveAndSubmitButton')
        @else
            <!-- broadsheet table with grades -->
            @include('tenant.partials.result.helpers.table.broadsheetTableWithGrade')
            <!--/: broadsheet table with grades -->
        @endif
    </div>
</div>

