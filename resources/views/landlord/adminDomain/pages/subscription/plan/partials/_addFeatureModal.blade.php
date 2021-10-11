<div class="overflow-auto" style="background-color:rgba(190,192,201,0.7); display:none" x-show="isAddFeatureModalOpen" :class="{ 'absolute inset-0 z-10 flex items-center justify-center': isAddFeatureModalOpen }">
    <div class="mt-12 sm:mx-auto sm:w-full sm:max-w-md md:max-w-md  bg-white rounded-lg shadow-md">
        <div class="flex items-center justify-between mt-3 text-gray-200 text-base mx-4 ">
            <div class="block">
                <span>Add new feature</span>
                <span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
              </svg>
            </span>
            </div>
            <button type="button" x-on:click="isAddFeatureModalOpen = false;" class="focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </button>
        </div>
        <div class="w-full">
            <form action="{{route('storePlanFeature',$plan['uuid'])}}" method="post">
                @csrf
                <div class="mx-4">
                    <div class="my-6">
                        <label for="feature" class="block text-xs font-normal text-gray-100">Feature:</label>
                        <div>
                            <select x-on:change="onSelectFeature()" x-model="selectedFeature" id="feature" name="featureId" class="py-1 px-2 w-full text-base leading-6 border border-purple-100
                  rounded-md shadow-x max-h-60 focus:outline-none sm:text-sm sm:leading-5" required>
                                <option value="">-- Select Plan --</option>
                                @foreach($newFeatures as $feature)
                                    <option value="{{$feature['uuid']}}">{{$feature['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="my-6">
                        <label for="value" class="block text-xs font-normal text-gray-100">Value:</label>
                        <input id="value" name="value" type="text" x-model="featureValue" class="py-1 px-2 w-full text-base leading-6 border border-purple-100
                  rounded-md shadow-x max-h-60 focus:outline-none sm:text-sm sm:leading-5">
                    </div>
                    <div class="my-6">
                        <p class="text-sm" x-text="featureDescription"></p>
                    </div>
                    <div class="mb-6">
                        <button type="submit" class="bg-blue-100 text-white px-4 py-2 rounded-md text-base">
                            Submit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
