@extends('tenant.layouts.main')
@section('headerMeta')
@endsection
@section('topNav')
@endsection
@section('content')
    <div class="max-h-full">
        @include('tenant.guestDomain.admission.partials._admissionForm')
    </div>
@endsection
