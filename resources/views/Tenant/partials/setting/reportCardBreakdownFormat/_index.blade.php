<div class="lg:px-8">
    <div>
        <div class="mt-2 text-xl text-gray-200">
            <div class="flex ">
                Report card breakdown format
            </div>
        </div>
        <a href="{{route('listSetting')}}" class="flex items-center space-x-1 mt-2">
            <span class=" text-sm text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                </svg>
            </span>
            <span class="text-sm text-gray-300">Settings</span>
        </a>
    </div>

    <div class="mt-8">
        <div class="bg-white rounded-md py-6 px-2 ">
            @if( ! $isReportCardAssessmentFormatSet )
                @include('Tenant.partials.setting.reportCardBreakdownFormat._create')
            @else
                @include('Tenant.partials.setting.reportCardBreakdownFormat._edit')
            @endif
        </div>
    </div>

</div>
