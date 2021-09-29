<div>
    <div class="mt-2 text-xl text-gray-200">
        <div class="flex ">
            Payment Details
        </div>
    </div>
    <a href="{{route('listSetting')}}"><span class="mt-2  text-sm text-gray-300">/!/ Settings</span></a>
</div>

<div class="py-10">
    <div class="bg-white rounded-md px-4 py-4">
        <div>
            <p>
                Accepting Payment:
                <span class="text-blue-100 font-light capitalize">
                {{ (array_key_exists('flutterwaveBankCode', $schoolDetails))? 'Yes' : 'no'}}
            </span>
            </p>
        </div>
        <div class="mt-3">
            <p>Add school's account details below so you can start receiving payments.</p>
            <form action="{{route('savePaymentSettings')}}" method="post">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-1 gap-6 p-4">
                    <div class="mt-2">
                        <input type="hidden" value="{{$setting}}" name="setting">
                        <label for="bank" class="block text-sm font-normal text-gray-100">Select Bank</label>
                        <select name="bank" id="bank" class="text-gray-100 rounded-md py-2 px-2 border @error('schoolLocation') border-red-100 @else border-purple-100 @enderror" required>
                            @foreach($banks->data as $bank)
                                <option value="{{$bank->code}}" {{($bank->code == $bankCode)? 'selected' : ''}}>{{$bank->name}}</option>
                            @endforeach
                        </select>
                        @error('bank')
                            <div>
                                <p class="text-red-100">
                                    {{$message}}
                                </p>
                            </div>
                        @enderror
                    </div>
                    <div class="mt-2">
                        <label for="accountNumber" class="block text-sm font-normal text-gray-100">Account Number</label>
                        <input type="text" value="{{old('accountNumber', $accountNumber)}}" name="accountNumber" id="accountNumber" class="text-gray-100 rounded-md py-2 px-2 border @error('accountNumber') border-red-100 @else border-purple-100 @enderror" required>
                        @error('accountNumber')
                            <div>
                            <p class="text-red-100">
                                {{$message}}
                            </p>
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="px-4 py-4">
                    <button type="submit" class="bg-blue-100 text-white rounded-md py-3 px-3  text-sm" >
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
