@extends('tenant.layouts.main')
@section('headerMeta')
@endsection
@section('topNav')
@endsection
@section('content')
    <div class="h-screen  md:flex md:overflow-hidden overflow-scroll bg-purple-100">
        <div>
            @include('tenant.partials._sidebar')
        </div>
            <div class="flex-1 overflow-auto bg-purple-100 focus:outline-none px-4 py-8" >
            @include('tenant.partials.users.teacher._uploadExcel')
        </div>
{{--        @include('tenant.partials._notification')--}}
    </div>
@endsection
