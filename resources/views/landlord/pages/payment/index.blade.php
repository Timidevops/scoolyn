@extends('Tenant.layouts.main')
@section('headerMeta')
@endsection
@section('topNav')
@endsection
@section('content')
        @include('Landlord.pages.payment.partials._payment')
 {{--    @include('Tenant.partials._notification')--}}
@endsection
