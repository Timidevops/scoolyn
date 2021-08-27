<div>

    <div class="px-4 py-4">
        <button wire:click="$set('addClassModal', true)" type="button" class="bg-blue-100 text-white rounded-md py-3 px-2  md:w-1/5 text-sm">
            Add To Class Arm
        </button>
    </div>

    <!-- Model -->

    <form wire:submit.prevent="store" class="overflow-auto @if($addClassModal) absolute inset-0 z-10 flex items-center justify-center @else hidden @endif" style="background-color:rgba(190,192,201,0.7);"  >
        @csrf

        <div class="mt-12 sm:mx-auto sm:w-full sm:max-w-md md:max-w-md  bg-white rounded-lg shadow-md">
            <div class="flex items-center justify-between mt-3 text-gray-200 text-base mx-4 ">
                <div class="block">
                    <span> Add to class arm</span>
                    <span>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
            </svg>
          </span>
                </div>
                <button type="button" wire:click="$set('addClassModal', false)" class="focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </button>
            </div>
            @if($errorDiv)
                <div class="mx-4 bg-red-100 p-4">
                    <p class="text-white text-sm">
                        {{$errorMessage}}
                    </p>
                </div>
            @endif
            <div class="mx-4">
                <div class="mt-6 ">
                    <label class="block text-sm font-normal text-gray-100">Class name</label>
                    <div class="relative inline-block w-full rounded-md">
                        <button wire:click="$set('schoolClassDropdown', {{!$schoolClassDropdown}})" type="button"
                                class="cursor-pointer z-0 w-full py-2 pl-3 pr-10 text-left text-gray-100 font-normal border border-purple-100 rounded-md cursor-default focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5">
                    <span class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 my-2 "  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                      </svg>
                      </span>
                            {{$schoolClassLabel}}
                        </button>
                    </div>
                    <div class="border border-purple-100 @if(!$schoolClassDropdown)  hidden @endif">
                        <ul class="py-1 overflow-auto h-32 text-base leading-6 border border-purple-100
              rounded-md shadow-xs max-h-60 focus:outline-none sm:text-sm sm:leading-5">
                            @foreach($schoolClasses as $schoolClass)
                                <li wire:click="selectSchoolClass('{{$schoolClass->uuid}}', '{{$schoolClass->class_name}}')" class="relative py-2 pl-3  text-gray-200 cursor-pointer select-none pr-9">
                                    {{$schoolClass->class_name}}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="mt-6">
                    <label for="Second name" class="block text-sm font-normal text-gray-100">Class section</label>
                    <div class="relative inline-block w-full rounded-md">
                        <button @if(!$classSections) disabled @endif wire:click="$set('classSectionDropdown', {{!$classSectionDropdown}})" type="button"
                                class="cursor-pointer z-0 w-full py-2 pl-3 pr-10 text-left text-gray-100 font-normal border border-purple-100 rounded-md cursor-default focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5">
                    <span class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 my-2 "  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                      </svg>
                      </span>
                            {{$classSectionLabel}}
                        </button>
                    </div>
                    <div class="border border-purple-100  w-full bg-white @if(!$classSectionDropdown)  hidden @endif">
                        <ul class="py-1 overflow-auto h-32 text-base leading-6
                   shadow-xs max-h-60 focus:outline-none sm:text-sm sm:leading-5">
                            @foreach($classSections as $classSection)
                                <li wire:click="selectClassSection('{{$classSection->classSection->uuid}}', '{{$classSection->uuid}}', '{{$classSection->classSection->section_name}}')" class="relative py-2 pl-3  text-gray-200 cursor-default select-none pr-9 text-blue-100 hover:bg-purple-100">
                                    {{$classSection->classSection->section_name}}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="mt-6 relative @if(!$isClassSectionCategory) hidden @endif">
                    <label class="block text-sm font-normal text-gray-100">Class section category</label>
                    <div class="relative inline-block w-full rounded-md">
                        <button @if(!$classSectionCategories) disabled @endif wire:click="$set('classSectionCategoryDropdown', {{!$classSectionCategoryDropdown}})" type="button"
                                class="cursor-pointer z-0 w-full py-2 pl-3 pr-10 text-left text-gray-100 font-normal border border-purple-100 rounded-md cursor-default focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5">
                            {{$classSectionCategoryLabel}}
                        </button>
                    </div>
                    <div class="border border-purple-100 absolute w-full bg-white @if(!$classSectionCategoryDropdown)  hidden @endif">
                        <ul class="py-1 overflow-auto h-32 text-base leading-6
                   shadow-xs max-h-60 focus:outline-none sm:text-sm sm:leading-5">
                            @foreach($classSectionCategories as $classSectionCategory)
                                <li wire:click="selectClassSectionCategory('{{$classSectionCategory->uuid}}', '{{$classSectionCategory->category_name}}')" class="relative py-2 pl-3  text-gray-200 cursor-default select-none pr-9 text-blue-100 hover:bg-purple-100">
                                    {{$classSectionCategory->category_name}}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="mb-6 mt-6">
                    <button type="submit" class="bg-blue-100 text-white px-4 py-2 rounded-md text-base">
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </form>


    <!-- Model -->

</div>
