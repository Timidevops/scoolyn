
<div class="grid grid-cols-1 gap-6 sm:grid-cols-2"
        x-show="accountRegistration"
        x-transition:enter="transition-transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-end="opacity-0 translate-y-1">
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
                    <option value="public">Public</option>
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
                   <select x-model="paymentCurrency" name="paymentCurrency" id="paymentCurrency" class="border-purple-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md p-2 border">
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

    </div>
    <div class="flex justify-end py-4">
        <button type="button" class="bg-blue-100 text-white px-6 py-2 rounded-md text-sm"
        x-on:click="Open=true">
           Proceed
        </button>
    </div>
