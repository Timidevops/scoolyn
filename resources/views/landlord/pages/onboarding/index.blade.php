@extends('tenant.layouts.main')
@section('headerMeta')
@endsection
@section('topNav')
@endsection
@section('content')
    <div class="max-h-full">
        @include('landlord.pages.onboarding.partials._schoolDetails')
    </div>
@endsection
