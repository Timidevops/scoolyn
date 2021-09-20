<div class="px-4 sm:px-6 lg:px-8">
    <div>
        <div class="mt-2 text-xl text-gray-200">
            Continuous Assessment Format
        </div>
        <span class="mt-2 text-base text-gray-300">{{$totalCaFormat}} Total C.A Format</span>
    </div>

    <div class="bg-white rounded-md" x-data="caFormat()">
        <div class="md:flex md:items-center md:mt-2 ">
            <div class="py-6 px-2 relative w-full">
                <div class="">
                    <input type="search" name="search" id="search" class="py-3 px-10 w-full border border-purple-100 rounded-md  bg-white" placeholder="Search">
                    <span class="absolute inset-y-0 left-0 pl-6 py-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                         </svg>
                    </span>
                </div>

            </div>
            <a href="{{route('createCAStructure')}}" class="bg-blue-100 text-white rounded-md py-3 mx-2 md:w-1/4 w-1/3 text-sm flex items-center" >
                <span class="mx-1">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                </span>
                <span class="">Add New Format</span>
            </a>
        </div>

        @include('Tenant.partials.result.caFormat._indexTable')
        <!--- classes modal --->
            <div x-show="isClassModalOpen" @click="isClassModalOpen = false;" class="overflow-auto absolute inset-0 z-10 flex items-center justify-center" style="background-color:rgba(190,192,201,0.7); display:none">
                <div class="mt-12 sm:mx-auto sm:w-full sm:max-w-md md:max-w-md  bg-white rounded-lg shadow-md">
                    <div class="flex items-center justify-between mt-3 text-gray-200 text-base mx-4 space-x-6">
                        <div class="block">
                            <p>Classes using: <span class="italic" x-text="caFormatName"></span></p>
                        </div>
                        <button type="button" @click="isClassModalOpen = false;" class="focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </button>
                    </div>
                    <div class="my-6 mx-2 text-sm">
                        <ul>
                            <template x-for="item in classModalClasses">
                                <li class="relative py-2 pl-3  text-gray-200 cursor-pointer select-none pr-9">
                                    <span x-text="item"></span>
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>
            </div>
        <!---/: classes modal --->

        <!--- format modal --->
            <div x-show="isCaFormatModalOpen" @click="isCaFormatModalOpen = false;" class="overflow-auto absolute inset-0 z-10 flex items-center justify-center" style="background-color:rgba(190,192,201,0.7);display:none">
                <div class="mt-12 sm:mx-auto sm:w-full sm:max-w-md md:max-w-md  bg-white rounded-lg shadow-md">
                    <div class="flex items-center justify-between mt-3 text-gray-200 text-base mx-4 space-x-6">
                        <div class="block">
                            <p>C.A Format: <span class="italic" x-text="caFormatName"></span></p>
                        </div>
                        <button type="button" @click="isCaFormatModalOpen = false;" class="focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </button>
                    </div>
                    <div class="my-6 mx-1.5 text-sm">
                        <ul>
                            <template x-for="item in caFormat">
                                <li class="relative py-2 pl-3  text-gray-200 cursor-pointer select-none pr-9">
                                    <span class="capitalize" x-text="getReportBreakdownName(item.nameOfReport)"></span>:
                                    <div>
                                        <ul>
                                            <template x-for="format in item.caFormat">
                                                <li>
                                                    <span x-text="format.name"></span> - <span x-text="format.score"></span>
                                                </li>
                                            </template>
                                        </ul>
                                    </div>
                                    <span class="mx-1" x-text="item.score"></span>
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>
            </div>
        <!---/: format modal --->

    </div>
</div>

<script>
    function caFormat(){
        return{
            isClassModalOpen: false,
            classModalClasses: [],
            caFormat: [],
            isCaFormatModalOpen:false,
            caFormatName: '',
            onClickClassModalOpen(id){
                let caFormat = this.caFormats.filter(uuid => uuid.uuid === id);
                this.caFormatName = caFormat[0]['name'];
                this.classModalClasses = caFormat[0]['schoolClass'];
                this.isClassModalOpen = true;
            },
            onClickOpenFormatModal(id){
                let caFormat = this.caFormats.filter(uuid => uuid.uuid === id);
                this.caFormatName = caFormat[0]['name'];
                this.caFormat = caFormat[0]['format'];
                this.isCaFormatModalOpen  = true;
            },
            reportBreakdown: {!! $reportBreakdown !!},
            getReportBreakdownName(id){
                let reportBreakdown = this.reportBreakdown.filter(e => e.uuid === id);

                return reportBreakdown[0]['name'];
            },
            search: "",
            pageNumber: 0,
            size: 5,
            total: "",
            caFormats: {!! $caFormats !!},
            get filteredCaFormatTable() {
                const start = this.pageNumber * this.size,
                    end = start + this.size;
                if (this.search === "") {
                    this.total = this.caFormats.length;
                    return this.caFormats.slice(start, end);
                }
                //Return the total results of the filters
                this.total = this.caFormats.filter((item) => {
                    return item.subject_name
                        .toLowerCase()
                        .includes(this.search.toLowerCase());
                }).length;
                //Return the filtered data
                return this.caFormats
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
        }
    }
</script>
