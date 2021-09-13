
<form action="{{route('recordStudentSchoolFees',$student->uuid)}}" method="post" class="overflow-auto" style="background-color:rgba(190,192,201,0.7); display:none" x-show="isRecordStudentSchoolFeesModalOpen" :class="{ 'absolute inset-0 z-10 flex items-center justify-center': isRecordStudentSchoolFeesModalOpen }">
@csrf
    <div class="mt-12 sm:mx-auto sm:w-full sm:max-w-md md:max-w-md  bg-white rounded-lg shadow-md">
        <div class="flex items-center justify-between mt-3 text-gray-200 text-base mx-4 ">
            <div class="block">
                <span>Record new payment</span>
                <span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
              </svg>
            </span>
            </div>
            <button type="button" x-on:click="isRecordStudentSchoolFeesModalOpen = false" class="focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </button>
        </div>

        <div class="mx-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4">
                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-300">Amount <span class="text-red-100">*</span></label>
                    <div class="mt-1">
                        <input type="number" name="amount" id="amount" class="border-purple-100  shadow-sm capitalize focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md p-2 border" required>
                    </div>
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-300">Description</label>
                    <div class="mt-1">
                        <input type="text" name="description" id="description" placeholder="optional" class="border-purple-100  shadow-sm capitalize focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md p-2 border">
                    </div>
                </div>
            </div>
            <div class="px-4 py-4">
                <button type="submit" class="bg-blue-100 text-white rounded-md py-3 px-2  md:w-1/3 text-sm">
                    Submit
                </button>
            </div>
        </div>
    </div>
</form>
