@extends('Tenant.layouts.main')
@section('headerMeta')
@endsection
@section('topNav')
@endsection
@section('content')
<div class="h-screen flex overflow-hidden bg-purple-100 " >
   <div>
    @include('Tenant.partials._sidebar') </div>
    <div class="flex-1 overflow-auto bg-purple-100 focus:outline-none px-4 py-8" tabindex="0" >
        {{-- @include('Tenant.partials._menu') --}}
        @include('Tenant.partials.subject._subject')
    </div>
    @include('Tenant.partials._notification')
</div>
@endsection