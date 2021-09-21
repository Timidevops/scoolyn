<div class="">
    <div class="bg-white rounded-md">
        <form wire:submit.prevent="storeParent">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4">
                <div class="mt-2">
                    <label for="firstName" class="block text-sm font-normal text-gray-100">First name</label>
                    <input type="text"  wire:model="parentFirstName" id="firstName" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100" required>
                </div>

                <div class="mt-2">
                    <label for="lastName" class="block text-sm font-normal text-gray-100">Last name</label>
                    <input type="text" wire:model="parentLastName" id="lastName" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100 " required>
                </div>

                <div class="mt-2">
                    <label for="email" class="block text-sm font-normal text-gray-100">Email</label>
                    <input type="text" wire:model="parentEmail" id="email" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100" required>
                </div>

                <div class="mt-2">
                    <label for="phoneNumber" class="block text-sm font-normal text-gray-100">Phone number</label>
                    <input type="text" wire:model="parentPhoneNumber" id="phoneNumber" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100 " required>
                </div>

                <div class="mt-2 relative">
                    <label for="Gender" class="block text-sm font-normal text-gray-100">Gender</label>
                    <div class="relative inline-block w-full rounded-md ">
                        <button wire:click="$set('parentGenderDropdown', {{!$parentGenderDropdown}})" type="button" class=" z-0 w-full py-2 pl-3 pr-10 text-left text-gray-100 font-normal border border-purple-100 rounded-md cursor-default focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5">
                        <span class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 my-2 "  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                          </svg>
                          </span>
                            {{$parentGenderLabel}}
                        </button>
                    </div>
                    <div class="@if(! $parentGenderDropdown) hidden @endif border border-purple-100 absolute w-full bg-white">
                        <ul class="py-1 overflow-auto h-32 text-base leading-6
                       shadow-xs max-h-60 focus:outline-none sm:text-sm sm:leading-5">
                            <li wire:click="selectParentGender('Female')" class="relative py-2 pl-3  text-blue-100 hover:bg-purple-100 cursor-default select-none pr-9">Female</li>
                            <li wire:click="selectParentGender('Male')" class="relative py-2 pl-3  text-blue-100 hover:bg-purple-100 cursor-default select-none pr-9">Male</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="mt-2 mx-4 ">
                <label for="address" class="block text-sm font-normal text-gray-100">Address</label>
                <textarea wire:model="parentAddress" id="address" class="text-gray-100 rounded-md  w-full px-2 py-3 border border-purple-100" rows="5"></textarea>
            </div>

            <div class="px-4 py-4">
                <button type="submit" class="bg-blue-100 text-white rounded-md py-3 px-3  text-sm">
                    Add parent
                </button>
            </div>
        </form>

    </div>
</div>
