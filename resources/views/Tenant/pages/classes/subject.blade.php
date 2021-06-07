@extends('Tenant.layouts.main')
@section('headerMeta')
@endsection
@section('topNav')
@endsection
@section('content')
    <div class="h-screen md:flex md:overflow-hidden overflow-scroll bg-purple-100">
        @include('Tenant.partials._sidebar')
        <div class="flex-1 overflow-auto bg-purple-100 focus:outline-none px-4 py-8" tabindex="0" x-data="activeEmployee()" @keydown.escape="showModal = false" @keydown.escape="showSuccess = false" x-cloak id="tab_wrapper">
            @include('Tenant.partials.class._subject')
        </div>
        @include('Tenant.partials._notification')
    </div>
@endsection
