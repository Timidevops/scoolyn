@extends('Tenant.layouts.main')
@section('headerMeta')
@endsection
@section('topNav')
@endsection
@section('content') 
       <div class="max-h-full">
        @include('Tenant.welcome.welcomePage.partials._welcome')
       </div>
@endsection