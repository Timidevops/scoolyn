<div class="mx-2 md:w-1/4">
    <button wire:click="$set('isOpenAddSubjectModal', true)" class="bg-blue-100 text-white rounded-md py-3 text-sm flex items-center">
                <span class="mx-2">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </span>
        <span class="mx-2">Add Subject</span>
    </button>
    <form x-data="addSubject()" wire:submit.prevent="store" class="overflow-auto @if($isOpenAddSubjectModal) absolute inset-0 z-10 flex items-center justify-center @else hidden @endif" style="background-color:rgba(190,192,201,0.7);">
        @csrf
        <div class="mt-12 sm:mx-auto sm:w-full sm:max-w-md md:max-w-md  bg-white rounded-lg shadow-md">
            <div class="flex items-center justify-between mt-3 text-gray-200 text-base mx-4 ">
                <div class="block">
                    <span> Add Class Subject</span>
                    <span>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
            </svg>
          </span>
                </div>
                <button type="button" wire:click="$set('isOpenAddSubjectModal', false)" class="focus:outline-none">
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
            <div class=" mx-4" >

                <div class="mt-6">
                    <label for="service" class="block text-xs font-normal text-gray-100">Section name</label>
                    <button wire:click="$set('classSectionDropdown', {{!$classSectionDropdown}})" type="button"
                            class="cursor-pointer z-0 w-full py-2 pl-3 pr-10 text-left text-gray-100 font-normal border border-purple-100 rounded-md cursor-default focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5">
                        {{$classSectionLabel}}
                    </button>
                    <div class="border border-purple-100 @if(!$classSectionDropdown)  hidden @endif">
                        <ul class="py-1 overflow-auto h-32 text-base leading-6 border border-purple-100
              rounded-md shadow-xs max-h-60 focus:outline-none sm:text-sm sm:leading-5">
                            <li wire:click="selectClassSection('all', 'All Sections')" class="relative py-2 pl-3  text-gray-200 cursor-pointer select-none pr-9">
                                All Section
                            </li>
                            @foreach($classSections as $classSection)
                                <li wire:click="selectClassSection('{{$classSection->classSection->uuid}}', '{{$classSection->classSection->section_name}}')" class="relative py-2 pl-3  text-gray-200 cursor-pointer select-none pr-9">
                                    {{$classSection->classSection->section_name}}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="my-6 @if(!$isClassSectionCategory) hidden @endif">
                    <label for="service" class="block text-xs font-normal text-gray-100">Class Section Category</label>
                    <button wire:click="$set('classSectionCategoryDropdown', {{!$classSectionCategoryDropdown}})" type="button"
                            class="cursor-pointer z-0 w-full py-2 pl-3 pr-10 text-left text-gray-100 font-normal border border-purple-100 rounded-md cursor-default focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5">
                        {{$classSectionCategoryLabel}}
                    </button>
                    <div class="border border-purple-100 @if(!$classSectionCategoryDropdown)  hidden @endif">
                        <ul class="py-1 overflow-auto h-32 text-base leading-6 border border-purple-100
              rounded-md shadow-xs max-h-60 focus:outline-none sm:text-sm sm:leading-5">
                            <li wire:click="selectClassSectionCategory('all', 'All Section Categories')" class="relative py-2 pl-3  text-gray-200 cursor-pointer select-none pr-9">
                                All Section Categories
                            </li>
                            @foreach($classSectionCategories as $classSectionCategory)
                                <li wire:click="selectClassSectionCategory('{{$classSectionCategory['classSectionCategory']['uuid']}}', '{{$classSectionCategory['classSectionCategory']['category_name']}}')" class="relative py-2 pl-3  text-gray-200 cursor-pointer select-none pr-9">
                                    {{$classSectionCategory['classSectionCategory']['category_name']}}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="my-6">
                    <label for="service" class="block text-xs font-normal text-gray-100">Subjects</label>
                    <button wire:click="$set('isSubjectDropdownOpen', {{!$isSubjectDropdownOpen}})" type="button"
                            class="cursor-pointer z-0 w-full py-2 pl-3 pr-10 text-left text-gray-100 font-normal border border-purple-100 rounded-md cursor-default focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5">
                        <span x-text="subjectLabel"></span>
                    </button>
                    <div x-show="isSubjectDropdownOpen" class="border border-purple-100">
                        <ul class="py-1 overflow-auto h-32 text-base leading-6 border border-purple-100
              rounded-md shadow-xs max-h-60 focus:outline-none sm:text-sm sm:leading-5">
                            <li class="relative py-2 pl-3  text-gray-200 cursor-default select-none pr-9 hover:text-blue-100 hover:bg-purple-100">
                                <label>
                                    <input id="selectAllSubjects"
                                           type="checkbox"
                                           x-on:change="$wire.onToggleAll(event.target.checked)"
                                    >
                                    <span class="px-1">Select All</span>
                                </label>
                            </li>
                            @foreach($subjects as $subject)
                                <li wire:click="selectSubject()" class="relative py-2 pl-3  text-gray-200 cursor-default select-none pr-9 hover:text-blue-100 hover:bg-purple-100">
                                    <label>
                                        <input class="subjectCheckbox"
                                               type="checkbox"
                                               wire:model="subjectIds"
                                               value="{{$subject->uuid}}"
                                               x-on:change="onToggleSubject()"
                                        >
                                        <span class="px-1 capitalize">{{$subject->subject_name}}</span>
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="mb-6">
                    <button type="submit" class="bg-blue-100 text-white px-4 py-2 rounded-md text-base">
                        Add Subject
                    </button>
                </div>

            </div>
        </div>
    </form>
</div>

<script>
    function addSubject() {
        return{
            subjectLabel: @entangle('subjectLabel'),
            isSubjectDropdownOpen: @entangle('isSubjectDropdownOpen'),
            onToggleAll(event){
                // let checked = event.checked;
                // document.querySelectorAll('.subjectCheckbox').forEach(e => e.checked = checked);
                // this.subjectLabel = 'Select all';
                // this.isSubjectDropdownOpen = ! checked;
            },
            onToggleSubject(){
                let allSubjectCount = document.querySelectorAll('.subjectCheckbox').length;
                let selectedSubjectCount = 0;
                document.querySelectorAll('.subjectCheckbox').forEach(e => selectedSubjectCount += e.checked ? 1 : 0);

                if(allSubjectCount === selectedSubjectCount){
                    document.getElementById('selectAllSubjects').checked = true;
                    this.subjectLabel = 'Selected all';
                    this.isSubjectDropdownOpen = false;

                    return;
                }
                document.getElementById('selectAllSubjects').checked = false;
            },
        }
    }
</script>
