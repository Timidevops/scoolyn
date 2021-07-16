{{--<div>--}}
{{--    <div class="mt-2 text-xl text-gray-200">--}}
{{--        <div class="flex ">--}}
{{--            Broadsheet:--}}
{{--            <div class="pl-2">--}}
{{--                <span>{{$classSubject->subject->subject_name}}</span>--}}
{{--                <span class="font-medium text-xs text-gray-200">--}}
{{--                    {{$classSubject->schoolClass->class_name}}--}}
{{--                    {{$classSubject->classSectionType ? "| {$classSubject->classSectionType->section_name}" : ''}}--}}
{{--                    {{$classSubject->classSectionCategoryType ? "| {$classSubject->classSectionCategoryType->category_name}" : ''}}--}}
{{--                </span>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <a href="{{route('listAcademicBroadsheet')}}"><span class="mt-2  text-sm text-gray-300">/!/ Broadsheets</span></a>--}}
{{--</div>--}}

<div class="h-screen">
    <div class="bg-white rounded-md ">
        @include('Tenant.partials.result.helpers.form.editBroadsheetWithSaveAndSubmitButton')
    </div>
</div>

