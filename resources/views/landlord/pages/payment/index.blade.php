@extends('tenant.layouts.main')
@section('headerMeta')
@endsection
@section('topNav')
@endsection
@section('content')
        @include('landlord.pages.payment.partials._payment')
 {{--    @include('tenant.partials._notification')--}}
@endsection
