
<form wire:submit.prevent="store">
    @csrf

    @if($errorDiv)
        <div class="mx-8 bg-red-100 p-4">
            <p class="text-white text-sm">
                {{$errorMessage}}
            </p>
        </div>
    @endif

    @if($errors->any())
        <div class="mx-8 bg-red-100 p-4">
            @foreach ($errors->all() as $error)
                <p class="text-white">
                    {!! $error !!}
                </p>
            @endforeach
        </div>
    @endif

    <div class="p-4 lg:px-8">
        <div class="grid grid-cols-1 bg-white md:grid-cols-2 gap-6 p-3">
            <div class="mt-2 ">
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
            <div class="mt-2">
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
            <div class="mt-2 relative @if(!$isClassSectionCategory) hidden @endif">
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
        </div>
    </div>

    <div class="md:flex mt-5 mb-5 lg:px-8">
        <div class="w-full p-3 bg-white rounded-sm">
        <div class=" relative  h-48 rounded-md bg-purple-100  ">
            <x-forms.filepond
                wire:model="file"
                allowFileTypeValidation
                allowFileSizeValidation
                maxFileSize="4mb"
            />
        </div>

        <div class="flex justify-center items-center my-6">
            <button type="button" class="relative px-2 py-2 bg-gray-100 text-white mx-2 rounded-md">
                <span class="absolute inset-y-0 left-0 my-3 mx-2 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                  </svg>
                </span>
                <span class="mx-5">Download Excel Format</span>
            </button>
            <button type="button"  class="relative px-2 py-2 bg-gray-100 text-white mx-2 rounded-md">
                <span class="absolute inset-y-0 left-0 my-3 mx-2 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                </span>
                <a href="{{route('createStudent')}}">
                    <span class="mx-5">Add by student via form </span>
                </a>
            </button>
        </div>

    </div>
    </div>

    <div class="px-4 py-4 lg:px-8">
        <button type="submit" class="bg-blue-100 text-white rounded-md py-3 px-3  text-sm">
            Submit
        </button>
    </div>

</form>


