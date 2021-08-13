@extends('Tenant.layouts.main')
@section('headerMeta')
@endsection
@section('topNav')
@endsection
@section('content')
    <div class="h-screen md:flex md:overflow-hidden overflow-scroll bg-purple-100 ">
        <div>
            @include('Tenant.partials._sidebar') </div>
        <div class="flex-1 overflow-auto bg-purple-100 focus:outline-none px-4 py-8" >
            <div class="lg:px-8">
                <div class="mt-2 text-xl text-gray-200">
                    Parents
                </div>
                <a href="{{route('listParent')}}" class="relative">
                    <span class=" text-sm text-gray-300 absolute">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                      </svg>
                    </span>
                    <span class="px-7 text-sm text-gray-300"> Parents</span>
                </a>
            </div>
            @include('Tenant.partials.users.parents._addParent')
        </div>
{{--        @include('Tenant.partials._notification')--}}
    </div>
@endsection
