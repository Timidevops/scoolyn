@extends('tenant.layouts.main')
@section('headerMeta')
@endsection
@section('topNav')
@endsection
@section('content')
       <div class="max-h-full">
        @include('tenant.welcome.admissionForm.partials._admissionForm')
       </div>
@endsection
