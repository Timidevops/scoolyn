<div class="overflow-auto" style="background-color:rgba(190,192,201,0.7); display:none" x-show="isConfirmAddonSelectionModalOpen" :class="{ 'absolute inset-0 z-10 flex items-center justify-center': isConfirmAddonSelectionModalOpen }">
    <div class="mt-12 sm:mx-auto sm:w-full sm:max-w-md md:max-w-md  bg-white rounded-lg shadow-md">
        <div class="flex items-center justify-between mt-3 text-gray-200 text-base mx-4 ">
            <div class="w-full text-center mx-4 my-4">
                <div>
                    <h3 class="text-lg font-bold text-blue-100">Are you sure?</h3>
                </div>
                <h5 class="py-6">
                    Addon: <span x-text="selectedAddon.name"></span>
                </h5>
                <h6>
                    Amount: NGN <span x-text="selectedAddon.amount"></span>
                </h6>
                <form :action=`{{route('postSubscriptionStudentAddon','')}}/${selectedAddon.uuid}` method="post">
                    @csrf
                    <div class="py-10 flex space-x-5 justify-center">
                        <button type="submit" class="bg-blue-100 text-white px-4 py-2 rounded-md text-base">Proceed to payment</button>
                        <button type="button" class="bg-blue-200 text-gray-200 px-4 py-2 rounded-md text-base"  x-on:click="isConfirmAddonSelectionModalOpen = false;" class="focus:outline-none">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
