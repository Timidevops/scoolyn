@extends('Landlord.layouts.main')

@section('pageContent')
    <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
        <div class="bg-purple-300 overflow-hidden rounded-lg ">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 text-3xl font-light text-blue-100">
                        {{$totalTenants}}
                    </div>

                    <div class="ml-5 w-0 flex-1">

                        <dl>
                            <dd>
                                <div class="text-lg font-medium text-gray-900">
                                    Total Schools
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

