<div class="lg:px-8">
    <div>
        <div class="mt-2 text-xl text-gray-200">
            <div class="flex ">
                Report card breakdown format
            </div>
        </div>
        <a href="{{route('listSetting')}}"><span class="mt-2  text-sm text-gray-300">/!/ Settings</span></a>
    </div>

    <div class="mt-5">
        <div class="bg-white rounded-md py-6 px-2 ">
            @if( ! $isReportCardAssessmentFormatSet )
                @include('Tenant.partials.setting.reportCardBreakdownFormat._create')
            @else
                @include('Tenant.partials.setting.reportCardBreakdownFormat._edit')
            @endif
        </div>
    </div>

</div>
