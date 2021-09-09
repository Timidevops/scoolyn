@extends('Landlord.layouts.auth')

@section('pageContent')
    <div class="flex justify-center">
        <div class="">
            <h2>No active subscription</h2>
            @can('update admission')
                <a href="{{route('subscriptionSetting')}}">
                    <button class="bg-blue-100 text-white rounded-md py-3 px-3  text-sm">
                        Renew Subscription
                    </button>
                </a>
            @endcan
        </div>
    </div>
@endsection
