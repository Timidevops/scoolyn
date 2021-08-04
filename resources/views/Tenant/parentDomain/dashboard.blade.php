@extends('Tenant.layouts.main')
@section('headerMeta')
@endsection
@section('topNav')
@endsection
@section('content')
    <div class="h-screen flex overflow-hidden bg-gray-100">
        @include('Tenant.parentDomain._sidebar')
        <div class="flex-1 overflow-auto bg-purple-100 focus:outline-none px-4 py-8" tabindex="0" @keydown.escape="showModal = false" @keydown.escape="showSuccess = false" x-cloak id="tab_wrapper">
           Dashboard
        </div>
        @include('Tenant.partials._notification')
    </div>
@endsection
