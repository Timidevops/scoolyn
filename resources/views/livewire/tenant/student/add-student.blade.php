<div>
    <form wire:submit.prevent="store">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4">
            <div class="mt-2 select-none">
                <label for="firstName" class="block text-sm font-normal text-gray-100">First name</label>
                <input type="text" wire:model="first_name" id="firstName" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100" required>
            </div>
            <div class="mt-2">
                <label for="lastName" class="block text-sm font-normal text-gray-100">Last name</label>
                <input type="text" wire:model="last_name" id="lastName" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100" required>
            </div>
            <div class="mt-2">
                <label for="otherNames" class="block text-sm font-normal text-gray-100">Other names</label>
                <input type="text" wire:model="other_name" id="otherNames" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100" required>
            </div>
            <div class="mt-2 relative">
                <label for="Gender" class="block text-sm font-normal text-gray-100">Gender</label>
                <div class="relative inline-block w-full rounded-md ">
                    <button wire:click="$set('genderDropdown', {{!$genderDropdown}})" type="button" class=" z-0 w-full py-2 pl-3 pr-10 text-left text-gray-100 font-normal border border-purple-100 rounded-md cursor-default focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5">
                    <span class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 my-2 "  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                      </svg>
                      </span>
                        {{$genderLabel}}
                    </button>
                </div>
                <div class="@if(!$genderDropdown) hidden @endif border border-purple-100 absolute w-full bg-white">
                    <ul class="py-1 overflow-auto h-32 text-base leading-6
                   shadow-xs max-h-60 focus:outline-none sm:text-sm sm:leading-5">
                        <li wire:click="selectGender('Male')" class="relative py-2 pl-3  text-gray-200 cursor-default select-none pr-9 text-blue-100 hover:bg-purple-100">
                            <p class="inline-flex">Male</p>
                        </li>
                        <li wire:click="selectGender('Female')" class="relative py-2 pl-3  text-gray-200 cursor-default select-none pr-9 text-blue-100 hover:bg-purple-100">
                            <p class="inline-flex">Female</p>
                        </li>
                        <li wire:click="selectGender('Others')" class="relative py-2 pl-3  text-gray-200 cursor-default select-none pr-9 text-blue-100 hover:bg-purple-100">
                            <p class="inline-flex">Others</p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="mt-2">
                <label for="dob" class="block text-sm font-normal text-gray-100">Date of birth</label>
                <input type="date" wire:model="dob" id="dob" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100 ">
            </div>
            <div class="mt-2">
                <label for="address" class="block text-sm font-normal text-gray-100">Address</label>
                <input type="text" wire:model="address" id="address" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100 " required>
            </div>
            <div class="mt-2">
                <label class="block text-sm font-normal text-gray-100">Class name</label>
                <button wire:click="$set('schoolClassDropdown', {{!$schoolClassDropdown}})" type="button"
                        class="cursor-pointer z-0 w-full py-2 pl-3 pr-10 text-left text-gray-100 font-normal border border-purple-100 rounded-md cursor-default focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5">
                    <span class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 my-2 "  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                      </svg>
                      </span>
                    {{$schoolClassLabel}}
                </button>
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
            <div class="mt-2 relative">
                <label for="Second name" class="block text-sm font-normal text-gray-100">Class section</label>
                <button @if(!$classSections) disabled @endif wire:click="$set('classSectionDropdown', {{!$classSectionDropdown}})" type="button"
                        class="cursor-pointer z-0 w-full py-2 pl-3 pr-10 text-left text-gray-100 font-normal border border-purple-100 rounded-md cursor-default focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5">
                    <span class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 my-2 "  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                      </svg>
                      </span>
                    {{$classSectionLabel}}
                </button>
                <div class="border border-purple-100 absolute w-full bg-white @if(!$classSectionDropdown)  hidden @endif">
                    <ul class="py-1 overflow-auto h-32 text-base leading-6
                   shadow-xs max-h-60 focus:outline-none sm:text-sm sm:leading-5">
                        @foreach($classSections as $classSection)
                            <li wire:click="selectClassSection('{{$classSection->uuid}}', '{{$classSection->classSectionType->section_name}}')" class="relative py-2 pl-3  text-gray-200 cursor-default select-none pr-9 text-blue-100 hover:bg-purple-100">
                                {{$classSection->classSectionType->section_name}}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="mt-2 relative @if(!$isClassSectionCategory) hidden @endif">
                <label class="block text-sm font-normal text-gray-100">Class section category</label>
                <button @if(!$classSectionCategories) disabled @endif wire:click="$set('classSectionCategoryDropdown', {{!$classSectionCategoryDropdown}})" type="button"
                        class="cursor-pointer z-0 w-full py-2 pl-3 pr-10 text-left text-gray-100 font-normal border border-purple-100 rounded-md cursor-default focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5">
                    {{$classSectionCategoryLabel}}
                </button>
                <div class="border border-purple-100 absolute w-full bg-white @if(!$classSectionCategoryDropdown)  hidden @endif">
                    <ul class="py-1 overflow-auto h-32 text-base leading-6
                   shadow-xs max-h-60 focus:outline-none sm:text-sm sm:leading-5">
                        @foreach($classSectionCategories as $classSectionCategory)
                            <li wire:click="selectClassSectionCategory('{{$classSectionCategory->uuid}}', '{{$classSectionCategory->classSectionCategoryType->category_name}}')" class="relative py-2 pl-3  text-gray-200 cursor-default select-none pr-9 text-blue-100 hover:bg-purple-100">
                                {{$classSectionCategory->classSectionCategoryType->category_name}}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="mt-2 relative">
                <label for="Select Parent" class="block text-sm font-normal text-gray-100">Parent</label>
                <div class="relative inline-block w-full rounded-md ">
                    <button wire:click="$set('parentDropdown', {{!$parentDropdown}})" type="button" class=" z-0 w-full py-2 pl-3 pr-10 text-left text-gray-100 font-normal border border-purple-100 rounded-md cursor-default focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5">
                    <span class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 my-2 "  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                      </svg>
                      </span>
                        {{$parentLabel}}
                    </button>
                    <div class="border border-purple-100 absolute w-full bg-white @if(!$parentDropdown)  hidden @endif">
                        <div class=" py-2 cursor-pointer" >
                            <button type="button" wire:click="$set('addParentModal', true)" class="flex items-center">
                                <span class="mx-2">
                              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-100 border border-green-100 rounded-full" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                              </svg>
                          </span>
                                <span class="text-xs font-normal text-gray-100">Add new parent {{$addParentModal}}</span>
                            </button>
                        </div>
                        <ul class="py-1 overflow-auto h-32 text-base leading-6
                   shadow-xs max-h-60 focus:outline-none sm:text-sm sm:leading-5">
                            @foreach($parents as $parent)
                                <li wire:click='selectParent("{{$parent->uuid}}", "{{$parent->first_name}} {{$parent->last_name}}")' class="relative py-2 pl-3  text-gray-200 cursor-default select-none pr-9 text-blue-100 hover:bg-purple-100">
                                    {{$parent->first_name}} {{$parent->last_name}}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-4 py-4">
            <button type="submit" href="" class="bg-blue-100 text-white rounded-md py-3 px-3  text-sm">
                Add student
            </button>
        </div>
    </form>



    <!--Add Parent Modal -->

    <div class="overflow-auto @if($addParentModal) absolute inset-0 z-10 flex items-center justify-center @else hidden @endif" style="background-color:rgba(190,192,201,0.7);"  >
        @csrf
        <div class="mt-12 sm:mx-auto sm:w-full sm:max-w-md md:max-w-lg  bg-white rounded-lg shadow-md">
            <div class="flex items-center justify-between mt-3 text-gray-200 text-base mx-4 ">
                <div class="block">
                    <span>Create Parent</span>
                    <span>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
            </svg>
          </span>
                </div>
                <button type="button" wire:click="$set('addParentModal', false)" class="focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </button>
            </div>
            <div class="mx-4">
                @include('livewire.tenant.parent.add-parent')
            </div>
        </div>
    </div>

    <!--:/ Add Parent Modal -->
</div>

