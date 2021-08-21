

<div class="mx-2 md:w-1/4 ">
    <button class="bg-blue-100 text-white rounded-md py-3 text-sm flex items-center" wire:click="$set('addClassModal', true)">
    <span class="mx-2">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
    </span>
        <span class="mx-2">Add Section</span>
    </button>
    <form wire:submit.prevent="store" class="overflow-auto @if($addClassModal) absolute inset-0 z-10 flex items-center justify-center @else hidden @endif" style="background-color:rgba(190,192,201,0.7);"  >
        @csrf

        <div class="mt-12 sm:mx-auto sm:w-full sm:max-w-md md:max-w-md  bg-white rounded-lg shadow-md">
            <div class="flex items-center justify-between mt-3 text-gray-200 text-base mx-4 ">
                <div class="block">
                    <span> Create Class</span>
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
            <div class="mx-4" >

                <div class="mt-6">
                    <label for="service" class="block text-xs font-normal text-gray-100">Class name</label>
                    <button wire:click="toggleClassDropdown('{{!$classDropdown}}', '{{!$classDropdownOption}}')" type="button" name="className"
                            class="cursor-pointer z-0 w-full py-2 pl-3 pr-10 text-left text-gray-100 font-normal border border-purple-100 rounded-md cursor-default focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5">
                        {{$classLabel}}
                    </button>
                    <div class="border border-purple-100 @if(!$classDropdown)  hidden @endif">
                        <div>
                            <div>
                                <div class="flex items-center py-2 cursor-pointer" >
                              <span class="mx-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-100 border border-green-100 rounded-full" viewBox="0 0 20 20" fill="currentColor">
                                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                                </svg>
                            </span>
                                    <span wire:click="toggleDefaultClassDropdown('{{!$defaultClassOptionDropdown}}')" class="text-xs font-normal text-gray-100">Choose default class</span>
                                </div>
                            </div>
                            <ul class="@if(!$defaultClassOptionDropdown) hidden @endif py-1 overflow-auto h-32 text-base leading-6 border border-purple-100
              rounded-md shadow-xs max-h-60 focus:outline-none sm:text-sm sm:leading-5">
                                @foreach($defaultClassOptions as $defaultClassOption)
                                    <li wire:click="selectDefaultClass('{{$defaultClassOption}}')" class="relative py-2 pl-3  text-gray-200 cursor-pointer select-none pr-9">{{$defaultClassOption}}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div>
                            <ul class="@if(!$classDropdownOption) hidden @endif py-1 overflow-auto h-32 text-base leading-6 border border-purple-100
              rounded-md shadow-xs max-h-60 focus:outline-none sm:text-sm sm:leading-5">
                                @foreach($schoolClasses as $schoolClass)
                                    <li wire:click="selectClass('{{$schoolClass->uuid}}', '{{$schoolClass->class_name}}')" class="relative py-2 pl-3  text-gray-200 cursor-pointer select-none pr-9">{{$schoolClass->class_name}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="my-6">
                    <label for="service" class="block text-xs font-normal text-gray-100">Section name</label>
                    <button wire:click="toggleClassSection('{{!$sectionDropdown}}', '{{!$sectionDropdownOption}}')" type="button" name="className"
                            class="cursor-pointer z-0 w-full py-2 pl-3 pr-10 text-left text-gray-100 font-normal border border-purple-100 rounded-md cursor-default focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5">
                        {{$sectionLabel}}
                    </button>
                    <div class="border border-purple-100 @if(!$sectionDropdown) hidden @endif">
                        <div>
                            <div>
                                <div class="flex items-center py-2 cursor-pointer" >
                              <span class="mx-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-100 border border-green-100 rounded-full" viewBox="0 0 20 20" fill="currentColor">
                                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                                </svg>
                            </span>
                                    <span wire:click="toggleAddNewSection('{{!$addNewSection}}')" class="text-xs font-normal text-gray-100">Create new class section</span>
                                </div>
                            </div>
                            <div class="@if(!$addNewSection) hidden @endif px-4 mb-3">
                                <label for="addNewSection" class="block text-xs font-normal text-gray-100">New section name</label>
                                <input wire:model="newClassSection" id="addNewSection" type="text" class="w-full py-2 text-xs px-2 text-left text-gray-100 font-normal border border-purple-100 rounded-md">
                                @error('newClassSection')
                                    {{$message}}
                                @enderror
                            </div>
                        </div>
                        <div class="@if(!$sectionDropdownOption) hidden @endif">
                            <ul class="py-1 overflow-auto h-32 text-base leading-6 border border-purple-100
              rounded-md shadow-xs max-h-60 focus:outline-none sm:text-sm sm:leading-5">
                                @foreach($classSectionTypes as $classSectionType)
                                    <li wire:click="selectClassSection('{{$classSectionType->uuid}}', '{{$classSectionType->section_name}}')" class="relative py-2 pl-3  text-gray-200 cursor-pointer select-none pr-9">{{$classSectionType->section_name}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="my-6">
                    <label for="service" class="block text-xs font-normal text-gray-100">Section category name</label>
                    <button wire:click="toggleClassSectionCategory('{{!$sectionCategoryDropdown}}', '{{!$sectionCategoryDropdownOption}}')" type="button" name="className"
                            class="cursor-pointer z-0 w-full py-2 pl-3 pr-10 text-left text-gray-100 font-normal border border-purple-100 rounded-md cursor-default focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5">
                        {{$sectionCategoryLabel}}
                    </button>
                    <div class="border border-purple-100 @if(!$sectionCategoryDropdown) hidden @endif">
                        <div>
                            <div>
                                <div class="flex items-center py-2 cursor-pointer" >
                              <span class="mx-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-100 border border-green-100 rounded-full" viewBox="0 0 20 20" fill="currentColor">
                                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                                </svg>
                            </span>
                                    <span wire:click="toggleAddNewSectionCategory('{{!$addNewSectionCategory}}')" class="text-xs font-normal text-gray-100">Create new class section category</span>
                                </div>
                            </div>
                            <div class="@if(!$addNewSectionCategory) hidden @endif px-4 mb-3">
                                <label for="addNewSectionCategory" class="block text-xs font-normal text-gray-100">New section category name</label>
                                <input wire:model="newClassSectionCategory" id="addNewSectionCategory" type="text" class="w-full py-2 text-xs px-2 text-left text-gray-100 font-normal border border-purple-100 rounded-md">
                                @error('newClassSectionCategory')
                                {{$message}}
                                @enderror
                            </div>
                        </div>
                        <div class="@if(!$sectionCategoryDropdownOption) hidden @endif">
                            <ul class="py-1 overflow-auto h-32 text-base leading-6 border border-purple-100
              rounded-md shadow-xs max-h-60 focus:outline-none sm:text-sm sm:leading-5">
                                @foreach($classSectionCategoryTypes as $classSectionCategoryType)
                                    <li wire:click="selectClassSectionCategory('{{$classSectionCategoryType->uuid}}', '{{$classSectionCategoryType->category_name}}')" class="relative py-2 pl-3  text-gray-200 cursor-pointer select-none pr-9">{{$classSectionCategoryType->category_name}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <button type="submit" class="bg-blue-100 text-white px-4 py-2 rounded-md text-base" x-on:click="addClass">
                        Create Class
                    </button>
                </div>
            </div>

        </div>
    </form>
</div>
