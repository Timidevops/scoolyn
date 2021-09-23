

<div class="lg:px-8">
    <div>
        <div class="mt-2 text-xl text-gray-200">
            Set new academic session
        </div>
        <a href="{{route('listSetting')}}"><span class="mt-2  text-sm text-gray-300">/!/ Settings</span></a>
    </div>

    <div class="bg-white rounded-md md:flex md:items-center md:mt-2 py-6 px-2 ">
        <div class="mt-12 sm:mx-auto sm:w-full sm:max-w-md md:max-w-md  bg-white rounded-lg shadow-md">
            @include('Tenant.partials.setting.academicCalendar.partials._createForm')
        </div>
    </div>

</div>
