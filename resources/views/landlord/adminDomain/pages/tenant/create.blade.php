@extends('Landlord.layouts.main')

@section('pageContent')
    <div class="mt-2 text-xl text-gray-200">
        Add New School
    </div>
    <div>
        <a href="{{route('listSchool')}}" class="relative">
                    <span class=" text-sm text-gray-300 absolute">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                      </svg>
                    </span>
            <span class="px-7 text-sm text-gray-300">Schools</span>
        </a>
    </div>

    <div class="mt-8 bg-white">
        <div class=" sm:block">
            <div class="max-w-6xl mx-auto  sm:px-6 ">
                <div class="flex flex-col mt-2 py-10 rounded-md">
                    <form action="{{route('storeSchool')}}" method="post" x-data="createSchool()">
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
                        <div class="my-5">
                            <h4>School Details</h4>
                        </div>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label for="schoolName" class="block text-sm font-medium text-gray-300">Name of School</label>
                                <div class="mt-1">
                                    <input x-model="schoolName" value="{{old('schoolName')}}" @input="getDomain(event)" type="text" name="schoolName" id="schoolName" class="border-purple-100  shadow-sm capitalize focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md p-2 border" required>
                                </div>
                            </div>
                            <div>
                                <label for="schoolType" class="block text-sm font-medium text-gray-300">Private/Government</label>
                                <div class="mt-1">
                                    <select name="schoolType" id="schoolType" class="border-purple-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md p-2 border" required>
                                        <option value="">-- Select Option --</option>
                                        <option value="private">Private</option>
                                        <option value="public">Government</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label for="schoolEmail" class="block text-sm font-medium text-gray-300">School Email Address</label>
                                <div class="mt-1">
                                    <input type="text" name="schoolEmail" id="schoolEmail" value="{{old('schoolEmail')}}" class="border-purple-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md p-2 border" required>
                                </div>
                            </div>
                            <div>
                                <label for="contactNumber" class="block text-sm font-medium text-gray-300">School Contact Number</label>
                                <div class="mt-1">
                                    <input type="text" name="contactNumber" id="contactNumber" value="{{old('contactNumber')}}" class="border-purple-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md p-2 border" required>
                                </div>
                            </div>
                            <div>
                                <label for="schoolLocation" class="block text-sm font-medium text-gray-300">School Address</label>
                                <div class="mt-1">
                                    <input type="text" name="schoolLocation" id="schoolLocation" value="{{old('schoolLocation')}}" class="border-purple-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md p-2 border" required>
                                </div>
                            </div>
                            <div>
                                <label for="hasPayment" class="block text-sm font-medium text-gray-300">Does the school accept payment?</label>
                                <div class="mt-1">
                                    <select x-model="hasPayment" name="hasPayment" id="hasPayment" class="border-purple-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md p-2 border" required>
                                        <option value="">-- Select Option --</option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </div>
                                <div x-show="hasPayment === 'yes' ">
                                    <div class="mt-1">
                                        <label for="paymentCurrency" class="block text-sm font-medium text-gray-300">Payment Currency</label>
                                    </div>
                                    <div class="mt-1">
                                        <select x-model="paymentCurrency" name="paymentCurrency" id="paymentCurrency" class="border-purple-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md p-2 border" required>
                                            <option value="">-- Select Currency --</option>
                                            <option value="ngn">NGN</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label for="domainName" class="block text-sm font-medium text-gray-300">Domain</label>
                                <div class="mt-1 flex items-center">
                                    <input  @input="getDomain(event, true)" type="text" placeholder="school-name" name="domainName" id="domainName" value="{{old('domainName')}}" class="border-purple-100 shadow-sm focus:ring-indigo-500 w-1/2 focus:border-indigo-500 sm:text-sm rounded-md p-2 border"  required>
                                    <p class="w-1/2">
                                        .{{$domain}}
                                    </p>
                                </div>
                            </div>
                            <div class="mt-1">
                                <label for="plan" class="block text-sm font-medium text-gray-300">Plan</label>
                                <div class="mt-1">
                                    <select name="plan" id="plan" class="border-purple-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md p-2 border">
                                        <option value="">-- Select Plan --</option>
                                        @foreach($plans  as $plan)
                                            <option value="{{$plan['id']}}">{{$plan['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mt-1">
                                <label for="marketerCode" class="block text-sm font-medium text-gray-300">Marketer Code</label>
                                <div class="mt-1">
                                    <input type="text" name="marketerCode" id="marketerCode" value="{{old('marketerCode')}}" class="border-purple-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md p-2 border">
                                </div>
                            </div>
                        </div>
                        <div class="my-5">
                            <h4>School Admin Details</h4>
                        </div>
                        <div class="relative grid grid-cols-1 gap-6 max-w-md">
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-300">Admin Email</label>
                                <div class="mt-1">
                                    <input type="text" id="email" name="adminEmail" value="{{old('adminEmail')}}" placeholder="" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-purple-100 rounded-md p-2 border" required>
                                </div>
                            </div>
                            <div>
                                <label for="adminPassword" class="block text-sm font-medium text-gray-300">Set Password</label>
                                <div class="mt-1">
                                    <input type="password" name="adminPassword" id="adminPassword" class="border-purple-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md p-2 border" required>
                                </div>
                            </div>
                            <div>
                                <label for="confirmPassword" class="block text-sm font-medium text-gray-300">Confirm Password  </label>
                                <div class="mt-1">
                                    <input type="password" name="adminPassword_confirmation" id="confirmPassword" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-purple-100 rounded-md p-2 border" required>
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

@section('pageJs')
    <script>
        function createSchool() {
            return{
                hasPayment: 'yes',
                paymentCurrency: 'ngn',
                schoolName: '{{old('schoolName')}}',
                schoolDomain: '',
                getDomain(input, value=false){
                    let url;
                    url =  ! this.schoolDomain  ? this.schoolName : this.schoolDomain;
                    if(value){
                        url = input.target.value ? input.target.value : this.schoolName;
                        this.schoolDomain = url;
                    }
                    document.getElementById('domainName').value = url.toLowerCase().replace(' ', '-');
                }
            }
        }
    </script>
@endsection
