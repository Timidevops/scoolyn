@extends('Tenant.layouts.main')
@section('headerMeta')
@endsection
@section('topNav')
@endsection
@section('content')
<div class="h-screen md:flex md:overflow-hidden overflow-scroll bg-purple-100 " >
   <div>
    @include('Tenant.partials._sidebar') 
   </div>
    <div class="flex-1 overflow-auto bg-purple-100 focus:outline-none px-4 py-8" tabindex="0">
        @include('Tenant.partials.admin._dashboard')
    </div>
{{--@include('Tenant.partials._notification')--}}
</div>
@endsection
