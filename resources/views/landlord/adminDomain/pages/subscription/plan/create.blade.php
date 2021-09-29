@extends('Landlord.layouts.main')

@section('pageContent')
    <div class="mt-2 text-xl text-gray-200">
        Add New Plan
    </div>
    <div>
        <a href="{{route('listPlan')}}" class="relative">
                    <span class=" text-sm text-gray-300 absolute">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                      </svg>
                    </span>
            <span class="px-7 text-sm text-gray-300">Plans</span>
        </a>
    </div>

    <div class="mt-8 bg-white">
        <div class=" sm:block">
            <div class="max-w-6xl mx-auto  sm:px-6 ">
                <div class="flex flex-col mt-2 py-10 rounded-md">
                    <form action="{{route('storePlan')}}" method="post">
                        @csrf
                        @if($errors->any())
                            <div class="mt-1 mb-5 bg-red-100 p-5">
                                @foreach ($errors->all() as $error)
                                    <p class="text-white">
                                        {!! $error !!}
                                    </p>
                                @endforeach
                            </div>
                        @endif
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-300">Name of Plan <span class="text-red-100">*</span></label>
                                <div class="mt-1">
                                    <input value="{{old('name')}}" type="text" name="name" id="name" class="border-purple-100  shadow-sm capitalize focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md p-2 border" required>
                                </div>
                            </div>
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-300">Price of Plan <span class="text-red-100">*</span></label>
                                <div class="mt-1">
                                    <input value="{{old('price')}}" type="text" name="price" id="price" class="border-purple-100  shadow-sm capitalize focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md p-2 border" required>
                                </div>
                            </div>
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-300">Description</label>
                                <div class="mt-1">
                                    <input value="{{old('description')}}" type="text" name="description" id="description" class="border-purple-100  shadow-sm capitalize focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md p-2 border">
                                </div>
                            </div>
                            <div>
                                <label for="signupFee" class="block text-sm font-medium text-gray-300">Sign Up Fee <span class="text-red-100">*</span></label>
                                <div class="mt-1">
                                    <input value="{{old('signupFee') ?? 0}}" type="text" name="signupFee" id="signupFee" class="border-purple-100  shadow-sm capitalize focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md p-2 border" required>
                                </div>
                            </div>
                            <div>
                                <label for="invoicePeriod" class="block text-sm font-medium text-gray-300">Invoice Period <span class="text-red-100">*</span></label>
                                <div class="mt-1">
                                    <input value="{{old('invoicePeriod') ?? 0}}" type="text" name="invoicePeriod" id="invoicePeriod" class="border-purple-100  shadow-sm capitalize focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md p-2 border" required>
                                </div>
                            </div>
                            <div>
                                <label for="invoiceInterval" class="block text-sm font-medium text-gray-300">Invoice Interval <span class="text-red-100">*</span></label>
                                <div class="mt-1">
                                    <input value="{{old('invoiceInterval')}}" type="text" name="invoiceInterval" id="invoiceInterval" class="border-purple-100  shadow-sm capitalize focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md p-2 border" placeholder="hour / day /week /month" required>
                                </div>
                            </div>
                            <div>
                                <label for="trialPeriod" class="block text-sm font-medium text-gray-300">Trial Period <span class="text-red-100">*</span></label>
                                <div class="mt-1">
                                    <input value="{{old('trialPeriod') ?? 0}}" type="text" name="trialPeriod" id="trialPeriod" class="border-purple-100  shadow-sm capitalize focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md p-2 border" required>
                                </div>
                            </div>
                            <div>
                                <label for="trialInterval" class="block text-sm font-medium text-gray-300">Trial Interval <span class="text-red-100">*</span></label>
                                <div class="mt-1">
                                    <input value="{{old('trialInterval') ?? 'day'}}" type="text" name="trialInterval" id="trialInterval" placeholder="hour / day /week /month" class="border-purple-100  shadow-sm capitalize focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md p-2 border" required>
                                </div>
                            </div>
                            <div>
                                <label for="sortOrder" class="block text-sm font-medium text-gray-300">Sort Order</label>
                                <div class="mt-1">
                                    <input value="{{old('sortOrder')}}" type="text" name="sortOrder" id="sortOrder" placeholder="ordering" class="border-purple-100  shadow-sm capitalize focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md p-2 border">
                                </div>
                            </div>
                            <div>
                                <label for="currency" class="block text-sm font-medium text-gray-300">Currency <span class="text-red-100">*</span></label>
                                <div class="mt-1">
                                    <input value="{{old('currency')}}" type="text" name="currency" id="currency" class="border-purple-100  shadow-sm capitalize focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md p-2 border" required>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-bottom-end  pb-52 md:py-4">
                            <button type="submit" class="bg-blue-100 text-white px-6 py-2 rounded-md text-sm">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
