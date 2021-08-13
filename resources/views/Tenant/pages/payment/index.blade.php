@extends('Tenant.layouts.main')
@section('headerMeta')
@endsection
@section('topNav')
@endsection
@section('content')  
        @include('Tenant.pages.payment.partials._payment') 
 {{--    @include('Tenant.partials._notification')--}}
 </div>
@endsection