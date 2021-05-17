@extends('Tenant.layouts.main')
@section('headerMeta')
@endsection
@section('topNav')
@endsection
@section('content')
<div class="h-screen flex overflow-hidden bg-gray-100">
    @include('Tenant.partials._sidebar')
    <div class="flex-1 overflow-auto bg-white focus:outline-none" tabindex="0">
       hh
    </div>

</div>
@endsection
