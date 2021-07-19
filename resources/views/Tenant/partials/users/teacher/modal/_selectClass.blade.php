<div x-show="isSelectClassModalOpen" class="overflow-auto absolute inset-0 z-10 flex items-center justify-center" style="background-color:rgba(190,192,201,0.7);">
    <div class="mt-12 sm:mx-auto sm:w-full sm:max-w-md md:max-w-md  bg-white rounded-lg shadow-md">
        <div class="flex items-center justify-between mt-3 text-gray-200 text-base mx-4 ">
            <div class="block">
                <span>Select Class</span>
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                    </svg>
                </span>
            </div>
            <button @click="isSelectClassModalOpen = false;" type="button" class="focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </button>
        </div>
        <div class="mx-4" x-data="selectClass()">
            <div class="mt-6">
                <label for="schoolClass" class="block text-xs font-normal text-gray-100">Class name</label>
                <button type="button" x-on:click="schoolClassDropdown = ! schoolClassDropdown;"
                        class="cursor-pointer z-0 w-full py-2 pl-3 pr-10 text-left text-gray-100 font-normal border border-purple-100 rounded-md cursor-default focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5">
                    <span x-text="schoolClassLabel"></span>
                </button>
                <div x-show="schoolClassDropdown" class="relative border border-purple-100">
                    <ul  class="absolute bg-white w-full py-1 overflow-auto  text-base leading-6 border border-purple-100
              rounded-md shadow-xs focus:outline-none sm:text-sm sm:leading-5">
                        <template x-for="(item, index) in schoolClass" :key="index">
                            <li x-on:click="selectSchoolClass(item.class_name); $wire.getClassSection(item.uuid)"
                                class="relative py-2 pl-3  text-gray-200 cursor-pointer select-none pr-9">
                                <span x-text="item.class_name"></span>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>
            <div class="my-6">
                <label class="block text-xs font-normal text-gray-100">Class Section</label>
                <button type="button" @if(!$isClassSectionEnabled) disabled @endif x-on:click="classSectionDropdown = ! classSectionDropdown;"
                        class="cursor-pointer z-0 w-full py-2 pl-3 pr-10 text-left text-gray-100 font-normal border border-purple-100 rounded-md cursor-default focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5">
                    <span x-text="classSectionLabel"></span>
                </button>
                <div x-show="classSectionDropdown" class="border relative border-purple-100">
                    <ul  class="absolute bg-white w-full py-1 overflow-auto  text-base leading-6 border border-purple-100
              rounded-md shadow-xs focus:outline-none sm:text-sm sm:leading-5">
                        <li wire:click="getSectionCategory('all')"
                            x-on:click="selectClassSection();"
                            class="relative py-2 pl-3  text-gray-200 cursor-pointer select-none pr-9">
                            All Sections
                        </li>
                        @foreach($classSections as $classSection)
                            <li wire:click="getSectionCategory('{{$classSection->classSection->uuid}}', '{{$classSection->uuid}}', '{{$classSection->classSection->section_name}}')"
                                x-on:click="selectClassSection();"
                                class="relative py-2 pl-3  text-gray-200 cursor-pointer select-none pr-9">
                                <span>
                                    {{$classSection->classSection->section_name}}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="my-6 @if(!$isSectionCategoryVisible) hidden @endif">
                <label class="block text-xs font-normal text-gray-100">Section Category</label>
                <button type="button" x-on:click="sectionCategoryDropdown = ! sectionCategoryDropdown" class="cursor-pointer z-0 w-full py-2 pl-3 pr-10 text-left text-gray-100 font-normal border border-purple-100 rounded-md cursor-default focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5">
                                    <span x-text="sectionCategoryLabel"></span>
                </button>
                <div x-show="sectionCategoryDropdown" class="relative border border-purple-100">
                    <ul  class="absolute bg-white w-full py-1 overflow-auto  text-base leading-6 border border-purple-100
              rounded-md shadow-xs focus:outline-none sm:text-sm sm:leading-5">
                        <li wire:click="selectSectionCategory('all', 'All Section')"
                            x-on:click="sectionCategoryDropdown = false;"
                            class="relative py-2 pl-3  text-gray-200 cursor-pointer select-none pr-9">
                            All Section
                        </li>
                        @foreach($sectionCategories as $sectionCategory)
                            <li wire:click="selectSectionCategory('{{$sectionCategory->uuid}}', '{{$sectionCategory->category_name}}')"
                                x-on:click="sectionCategoryDropdown = false;"
                                class="relative py-2 pl-3  text-gray-200 cursor-pointer select-none pr-9">
                                <span>{{$sectionCategory->category_name}}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="mx-4 mb-6">
            <button x-on:click="isSelectClassModalOpen = false;" type="button" class="bg-blue-100 text-white w-full px-6 py-2 rounded-md text-base">
                Set
            </button>
        </div>
    </div>
</div>

<script>
    function selectClass() {
        return{
            schoolClass: {!! $schoolClass !!},
            schoolClassLabel: '-- choose a class --',
            schoolClassDropdown: false,
            selectSchoolClass(className){
                this.schoolClassDropdown = false;
                this.schoolClassLabel = className;
                this.classSectionDropdown = false;
                this.sectionCategoryDropdown = false;
                this.classSectionLabel = '-- choose a section --';
                this.sectionCategoryLabel = '-- choose a category --';
            },
            classSectionLabel: @entangle('classSectionName').defer,
            classSectionDropdown: false,
            selectClassSection(){
                this.classSectionDropdown = false;
                this.sectionCategoryLabel = '-- choose a category --';
            },
            sectionCategoryLabel: @entangle('sectionCategoryLabel').defer,
            sectionCategoryDropdown: false,
        }
    }
</script>
