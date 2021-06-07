<div class="mt-8">
    <div class=" sm:block">
        <div class="max-w-6xl mx-auto  sm:px-6 ">
            <div class="flex flex-col mt-2">
                <div class="align-middle min-w-full overflow-x-auto  overflow-hidden ">
                    <table class="min-w-full divide-y divide-primary divide-purple-100">
                        <thead>
                        <tr>
                            <th class="px-6 py-3 w-1  text-left text-sm font-medium text-gray-500 uppercase">
                                S/N
                            </th>
                            <th class="px-6 py-3 w-full  text-left  font-medium text-gray-500 text-sm ">
                  <span class="flex items-center mx-1">Subject name<span>
                    <span>
                      <img src="images/filter_alt_black_24dp.svg" alt="" class="w-4">
                       </span>
                   </span>
                  </span>
                            </th>
                            <th class="px-6 py-3 w-1  text-left text-sm font-medium text-gray-500 uppercase">
                                Class section
                            </th>
                            <th class="px-6 py-3 w-1/3  text-left text-sm font-medium text-gray-500">
                                Action
                            </th>

                        </tr>
                        </thead>
                        <template x-for="(item, index) in filteredClassSubjects" :key="item" >
                            <tbody class="bg-white divide-y divide-primary">
                            <tr class="bg-white">

                                <td class="max-w-0  px-6 py-4 whitespace-nowrap text-xs text-gray-900">
                                    <div class="flex">
                                        <a href="#" class="group inline-flex space-x-2 truncate">
                                            <p class="text-gray-500 truncate" x-text="index + 1">
                                            </p>
                                        </a>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-left whitespace-nowrap text-xs text-gray-200">
                  <span class="text-gray-200 font-normal"  x-text="item.subject.subject_name">
                  </span>
                                </td>
                                <td class="px-6 py-4 text-left whitespace-nowrap text-xs text-gray-200">
                  <span class="text-gray-200 font-normal"  x-text="getTableClassSection(item.class_section_id, item.class_section_category_id)">
                  </span>
                                </td>

                                <td class="md:px-6 py-4 text-right whitespace-nowrap text-sm text-gray-200 flex items-center">
                                    <button type="button" class="focus:outline-none" x-on:click="editModal = true">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-100 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" >
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                    <button type="button" class="focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </template>
                    </table>
                </div>
            </div>
        </div>
        <nav class="max-w-6xl  mx-auto px-4 lg:px-8 my-4  bg-white  md:flex md:items-center md:justify-between border-lighter-gray sm:px-6">
            <div
                class="mt-6 mb-6 flex flex-wrap justify-between items-center text-sm leading-5 text-gray"
            >
                <div
                    class="w-full sm:w-auto text-center sm:text-right px-1"
                    x-show="pageCount() >= 1"
                >
                    Showing
                    <span x-text="startResults()"></span> to
                    <span x-text="endResults()"></span>
                </div>

                <div
                    class="w-full sm:w-auto text-center sm:text-left"
                    x-show="total > 0"
                >
                    of
                    <span class="font-bold" x-text="total"></span> Entries
                </div>

                <!--Message to display when no results-->
                <div class="mx-auto flex items-center font-bold text-red-500" x-show="total===0">
                    <svg class="h-8 w-8 text-red-500" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" /><circle cx="12" cy="12" r="9" /><line x1="9" y1="10" x2="9.01" y2="10" /><line x1="15" y1="10" x2="15.01" y2="10" /><path d="M9.5 16a10 10 0 0 1 6 -1.5" />
                    </svg>
                    <span class="ml-4"> No results!!</span>
                </div>
            </div>
            <div
                class=" flex justify-center items-center md:mt-0 mt-4  md:flex md:justify-end md:items-center"
                x-show="pageCount() > 1">
                <!--First Button-->
                <button type="button" class="border border-gray rounded py-1 px-2 mx-4  text-blue-100" x-on:click="viewPage(0)" :disabled="pageNumber==0" :class="{ 'disabled cursor-not-allowed text-gray-100' : pageNumber==0 }">
                    Previous
                </button>
                <!--Last Button-->
                <button type="button" class="border border-gray rounded py-1 px-6 text-blue-100" x-on:click="viewPage(Math.ceil(total/size)-1)" :disabled="pageNumber >= pageCount() -1" :class="{ 'disabled cursor-not-allowed text-gray-100' : pageNumber >= pageCount() -1 }"
                >Next
                </button>
            </div>
        </nav>
        {{-- modal --}}
        <form action="{{route('storeClassSubject')}}" method="post" class="overflow-auto" style="background-color:rgba(190,192,201,0.7);" x-show="showModal" :class="{ 'absolute inset-0 z-10 flex items-center justify-center': showModal }">
            @csrf
            <input type="hidden" name="class" value="{{$classSections['uuid']}}">
            <div class="mt-12 sm:mx-auto sm:w-full sm:xmax-w-md md:max-w-md  bg-white rounded-lg shadow-md">
                <div class="flex items-center justify-between mt-3 text-gray-200 text-base mx-4 ">
                    <div class="block">
                        <span>Add Subject to class</span>
                        <span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
              </svg>
            </span>
                    </div>
                    <button type="button" x-on:click="showModal = false" class="focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </button>
                </div>
                <div class=" mx-4" >
                    <div class="mt-6">
                        <label for="service" class="block text-xs font-normal text-gray-100">Class Section</label>
                        <input type="hidden" name="classSection" x-bind:value="selected.value">
                        <div class="relative inline-block w-full rounded-md ">
                            <button type="button" class=" z-0 w-full py-2 pl-3 pr-10 text-left font-normal border border-purple-100 rounded-md cursor-default focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5 text-gray-200" x-text="selected.title" x-on:click="open = true">
                  <span class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 my-2 "  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                    </span>
                            </button>
                        </div>
                        <ul x-show="open"  @click.away="open = false" class="py-1 overflow-auto h-32 text-base leading-6 border border-purple-100
                rounded-md shadow-xs max-h-60 focus:outline-none sm:text-sm sm:leading-5">
                            <li @click.prevent="selected.title = 'Select all'; selected.value = 'all'; open = false; isShowExtraCategoryOpen =false;" class="relative py-2 pl-3  text-gray-200 cursor-default select-none pr-9" :class="{ ' text-gray-200 hover:bg-purple-100': open == true}">
                                <p class="inline-flex">Select all</p>
                            </li>
                            <template x-for="option in options.class_section_type" :key="option">
                                <li @click.prevent="selected.title = option.section_name; selected.value = option.uuid; open = false; getExtraCategory(option.uuid,options.class_section)" class="relative py-2 pl-3  text-gray-200 cursor-default select-none pr-9" :class="{ ' text-gray-200 hover:bg-purple-100': open == true}">
                                    <p x-text="option.section_name" class="inline-flex"></p>
                                </li>
                            </template>
                        </ul>
                    </div>

                    <div class="my-6" x-show="isShowExtraCategoryOpen">
                        <label for="service" class="block text-xs font-normal text-gray-100">Extra category (optional: used to specify individual category)</label>
                        <input type="hidden" name="classSectionCategory" x-bind:value="extraCategorySelected.value">
                        <div class="relative inline-block w-full rounded-md ">
                            <button type="button" class=" z-0 w-full py-2 pl-3 pr-10 text-left font-normal border border-purple-100 rounded-md cursor-default focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5 text-gray-200" x-text="extraCategorySelected.title" x-on:click="isExtraCategoryListOpen = true">

                    <span class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 my-2 "  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                      </svg>
                      </span>
                            </button>
                        </div>
                        <ul x-show="isExtraCategoryListOpen"  @click.away="isExtraCategoryListOpen = false" class="py-1 overflow-auto h-32 text-base leading-6 border border-purple-100
                  rounded-md shadow-xs max-h-60 focus:outline-none sm:text-sm sm:leading-5">
                            <template x-for="category in extraCategory" :key="category">
                                <li @click.prevent="extraCategorySelected.title = category.category_name; extraCategorySelected.value = category.uuid; isExtraCategoryListOpen = false" class="relative py-2 pl-3  text-gray-200 cursor-default select-none pr-9" :class="{ ' text-blue-100 hover:bg-purple-100': show == true}">
                                    <p x-text="category.category_name" class="inline-flex"></p>
                                </li>
                            </template>
                        </ul>
                    </div>

                    <div class="my-6">
                        <label for="service" class="block text-xs font-normal text-gray-100">Subject Name</label>
                        <input type="hidden" name="subject" x-bind:value="select.value">
                        <div class="relative inline-block w-full rounded-md ">
                            <button type="button" class=" z-0 w-full py-2 pl-3 pr-10 text-left font-normal border border-purple-100 rounded-md cursor-default focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5 text-gray-200" x-text="select.title" x-on:click="show = true">

                    <span class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 my-2 "  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                      </svg>
                      </span>
                            </button>
                        </div>
                        <ul x-show="show"  @click.away="show = false" class="py-1 overflow-auto h-32 text-base leading-6 border border-purple-100
                  rounded-md shadow-xs max-h-60 focus:outline-none sm:text-sm sm:leading-5">
                            <template x-for="subject in subjects" :key="subject">
                                <li @click.prevent="select.title = subject.subject_name; select.value = subject.uuid; show = false" class="relative py-2 pl-3  text-gray-200 cursor-default select-none pr-9" :class="{ ' text-blue-100 hover:bg-purple-100': show == true}">
                                    <p x-text="subject.subject_name" class="inline-flex"></p>
                                </li>
                            </template>
                        </ul>
                    </div>

                    <div class="mb-6">
                        <button type="submit" class="bg-blue-100 text-white px-4 py-2 rounded-md text-base" x-on:click="addNewField()">
                            Add Subject
                        </button>
                    </div>
                </div>

            </div>
        </form>
        {{-- modal --}}
        {{-- edit modal --}}
        <div class="overflow-auto" style="background-color:rgba(190,192,201,0.7);" x-show="editModal" :class="{ 'absolute inset-0 z-10 flex items-center justify-center': editModal }">
            <div class="mt-12 sm:mx-auto sm:w-full sm:max-w-md md:max-w-md  bg-white rounded-lg shadow-md">
                <div class="flex items-center justify-between mt-3 text-gray-200 text-base mx-4">
                    <div class="block">
                        <span>Edit Subject</span>
                        <span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                  </svg>
                </span>
                    </div>
                    <button x-on:click="editModal = false" class="focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </button>
                </div>
                <div class=" mx-4" >
                    <div class="mt-6">
                        <label for="service" class="block text-xs font-normal text-gray-100">Class</label>
                        <div class="relative inline-block w-full rounded-md ">
                            <button class=" z-0 w-full py-2 pl-3 pr-10 text-left font-normal border border-purple-100 rounded-md cursor-default focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5 text-gray-200" x-text="selected.value" x-on:click="open = true">
                    <span class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 my-2 "  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                      </svg>
                      </span>
                            </button>
                        </div>
                        <ul x-show="open" class="py-1 overflow-auto h-32 text-base leading-6 border border-purple-100
                  rounded-md shadow-xs max-h-60 focus:outline-none sm:text-sm sm:leading-5">
                            <template x-for="option in options.class_section_type" :key="option">
                                <li @click.prevent="selected = option; open = false" class="relative py-2 pl-3  text-gray-200 cursor-default select-none pr-9" :class="{ ' text-gray-200 hover:bg-purple-100': open == true}">
                                    <p x-text="option.value" class="inline-flex"></p>
                                </li>
                            </template>
                            <li>Select all</li>
                        </ul>
                    </div>

                    <div class="my-6">
                        <label for="service" class="block text-xs font-normal text-gray-100">Subject Name</label>
                        <div class="relative inline-block w-full rounded-md ">
                            <button class=" z-0 w-full py-2 pl-3 pr-10 text-left font-normal border border-purple-100 rounded-md cursor-default focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5 text-gray-200" x-text="select.value" x-on:click="show = true">

                      <span class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 my-2 "  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                        </span>
                            </button>
                        </div>
                        <ul x-show="show"  @click.away="show = false" class="py-1 overflow-auto h-32 text-base leading-6 border border-purple-100
                    rounded-md shadow-xs max-h-60 focus:outline-none sm:text-sm sm:leading-5">
                            <template x-for="subject in subjects" :key="subject">
                                <li @click.prevent="select = subject; show = false" class="relative py-2 pl-3  text-gray-200 cursor-default select-none pr-9" :class="{ ' text-blue-100 hover:bg-purple-100': show == true}">
                                    <p x-text="subject.value" class="inline-flex"></p>
                                </li>
                            </template>
                        </ul>
                    </div>

                    <div class="mb-6">
                        <button class="bg-blue-100 text-white px-4 py-2 rounded-md text-base" @click.prevent="addNewField()">
                            Create Subject
                        </button>
                    </div>
                </div>

            </div>
        </div>
        {{-- edit modal --}}
    </div>

</div>



<script>
    function activeEmployee() {
        return {
            open: false,
            show: false,
            showModal: false,
            editModal: false,
            search: "",
            pageNumber: 0,
            size: 5,
            total: "",
            extraCategory: [],
            extraCategorySelected:{
                title: 'Select category',
                value: "",
            },
            isExtraCategoryListOpen: false,
            isShowExtraCategoryOpen: false,
            getExtraCategory(id,classSections){

               let classSection =  classSections.filter(uuid => uuid.class_section_types_id === id);

               if ( classSection[0]['class_section_category_type'] ){
                   this.extraCategory = [classSection[0]['class_section_category_type']];
                   return  this.isShowExtraCategoryOpen = true;
               }

               this.extraCategory = [];
               return  this.isShowExtraCategoryOpen = false;
            },
            getTableClassSection(classSection, classSectionCategory){

                let _classSection = {!! $classSectionType !!};
                let _classSectionCategory = {!! $classSectionCategoryType !!};
                if( classSection && classSectionCategory ){
                    let filter = _classSectionCategory.filter(id => id.uuid === classSectionCategory);
                    return filter[0]['category_name'];
                }
                else if(classSection && ! classSectionCategory){
                    let filter = _classSection.filter(id => id.uuid === classSection);
                    return filter[0]['section_name'];
                }
                return 'All Sections'
            },
            myForData: {!! $classSubjects !!},

            addNewField() {
                this.subjects.push({
                    subject: this.subject_name,
                });
                this.subject_name = "";
            },
            selected: {
                title:'Select section',
                value: ""

            },
            select: {
                title: 'Select subject',
                value: ""

            },
            options: {!! $classSections !!},
            subjects: {!! $subjects !!},
            get filteredClassSubjects() {
                const start = this.pageNumber * this.size,
                    end = start + this.size;
                if (this.search === "") {
                    this.total = this.myForData.length;
                    return this.myForData.slice(start, end);
                }
                //Return the total results of the filters
                this.total = this.myForData.filter((item) => {
                    return item.subject_name
                        .toLowerCase()
                        .includes(this.search.toLowerCase());
                }).length;
                //Return the filtered data
                return this.myForData
                    .filter((item) => {
                        return item.subject_name
                            .toLowerCase()
                            .includes(this.search.toLowerCase());
                    })
                    .slice(start, end);
            },
            //Create array of all pages (for loop to display page numbers)
            pages() {
                return Array.from({
                    length: Math.ceil(this.total / this.size),
                });
            },
            //Next Page
            nextPage() {
                this.pageNumber++;
            },
            //Previous Page
            prevPage() {
                this.pageNumber--;
            },
            //Total number of pages
            pageCount() {
                return Math.ceil(this.total / this.size);
            },
            //Return the start range of the paginated results
            startResults() {
                return this.pageNumber * this.size + 1;
            },
            //Return the end range of the paginated results
            endResults() {
                let resultsOnPage = (this.pageNumber + 1) * this.size;
                if (resultsOnPage <= this.total) {
                    return resultsOnPage;
                }
                return this.total;
            },
            //Link to navigate to page
            viewPage(index) {
                this.pageNumber = index;
            },
        };
    }
</script>
