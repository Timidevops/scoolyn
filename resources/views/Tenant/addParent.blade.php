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
        <div>
            <div class="mt-2 text-xl text-gray-200">
                Parents
            </div>
            <span class="mt-2 text-base text-gray-300"> Total Parents</span>
        </div>
        @include('Tenant.partials.users.parents._addParent')
    </div>
    @include('Tenant.partials._notification')
</div>
@endsection