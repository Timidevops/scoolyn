<div class="px-4 sm:px-6 lg:px-8">
    <div>
        <div class="mt-2 text-xl text-gray-200">
            Settings
        </div>
    </div>
    <div class="bg-white rounded-md md:flex md:items-center md:mt-2 py-6 px-2 ">
        <div class="w-full space-y-4 px-5">
            @can('read set academic session')
                <div>
                    <table class="w-full">
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
                    </table>
                </div>
            @endcan

            @can('update school details')
                <div>
                    <table>
                        <tr>
                            <td>
                                <a href="{{route('schoolDetailsSettings')}}">
                                    <span>School Details</span>
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
                <div>
                        <table>
                            <tr>
                                <td>
                                    <a href="{{route('paymentSettings')}}">
                                        <span>Payment Settings</span>
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </div>
            @endcan

            @if(\App\Models\Landlord\FeatureChecker::hasAdmissionAutomationFeature())
                    @can('update admission')
                        <div>
                            <table>
                                <tr>
                                    <td>
                                        <a href="{{route('admissionSetting')}}">
                                            <span>Change Admission Setting</span>
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    @endcan
            @endif

            @can('read report card assessment format')
                <div>
                    <table>
                        <tr>
                            <td>
                                <a href="{{route('reportCardBreakdownFormatSetting')}}">
                                    <span>Report Card Breakdown Format</span>
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
            @endcan

            @can('update admission')
                <div>
                    <table>
                        <tr>
                            <td>
                                <a href="{{route('frontendSetting')}}">
                                    <span>Frontend settings</span>
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
            @endcan

                @can('update admission')
                    <div>
                        <table>
                            <tr>
                                <td>
                                    <a href="{{route('subscriptionSetting')}}">
                                        <span>Subscription Information</span>
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </div>
                @endcan

                <div>
                    <table>
                        <tr>
                            <td>
                                <a href="{{route('changeAuthPassword')}}">
                                    <span>Change Password</span>
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
        </div>
    </div>
</div>
