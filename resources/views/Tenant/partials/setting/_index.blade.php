<div class="px-4 sm:px-6 lg:px-8">
<div>
    <div class="mt-2 text-xl text-gray-200">
        Settings
    </div>
</div>

<div class="bg-white rounded-md md:flex md:items-center md:mt-2 py-6 px-2 ">
    <table class="w-full">
        @can('read set academic session')
            <tr>
                <td>
                    <a href="{{route('academicSession')}}">
                        <span>Set Academic Session</span>
                    </a>
                    <p class="text-sm text-gray-100 py-3">
                        Current Academic Session: {{$currentAcademicSession}}
                    </p>
                </td>
                <td>
                    @if($currentAcademicSession != '')
                        <a href="{{route('listAcademicCalendar')}}">
                            <button class="bg-blue-100 text-white rounded-md px-5 py-3 text-sm flex items-center">
                                View all sessions
                            </button>
                        </a>
                    @endif
                </td>
            </tr>
        @endcan

        @can('update school details')
            <tr>
                <td>
                    <a href="{{route('schoolDetailsSettings')}}">
                        <span>School Details</span>
                    </a>
                </td>
            </tr>
        @endcan

        @can('update admission')
            <tr>
                <td>
                    <a href="{{route('admissionSetting')}}">
                        <span>Change Admission Setting</span>
                    </a>
                </td>
            </tr>
        @endcan
            <tr>
                <td>
                    <a href="{{route('changeAuthPassword')}}">
                        <span>Change password</span>
                    </a>
                </td>
            </tr>
    </table>
</div>
</div>
