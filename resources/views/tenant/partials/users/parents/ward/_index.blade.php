<div class="px-4 sm:px-6 lg:px-8" x-data="wards()">
    <div class="mt-8 mb-4">
        <div class="mt-2 text-xl text-gray-200">
            Wards for: {{$parent->first_name}} {{$parent->last_name}}
        </div>
        <span class="mt-2 text-base text-gray-300">{{$totalWards}} Total Wards</span>
        <a href="{{route('listParent')}}" class="flex relative items-center space-x-1 mt-2">
            <span class=" text-sm text-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                      </svg>
                    </span>
            <span class="text-sm text-gray-300">Back to parents</span>
        </a>
    </div>
    <div class="bg-white rounded-md mt-8 py-6 px-2 ">
        <div class="md:flex md:items-center md:mt-2">
            <div class="flex justify-end w-full">
                <a href="{{route('createParentWard',$parent->uuid)}}">
                    <button type="button" class="bg-blue-100 text-white rounded-md py-3 mx-2   text-sm flex items-center">
                    <span class="mx-2">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                    </span>
                        <span class="mx-2">Add New Ward</span>
                    </button>
                </a>
            </div>
        </div>
        <!-- table -->
            @include('tenant.partials.users.parents.ward._indexTable')
        <!--:/ table -->
    </div>
</div>

<script>
    function wards() {
        return{
            wardData: {!! $wards !!},
            search: "",
            pageNumber: 0,
            size: 10,
            total: "",
            get filteredWards() {
                const start = this.pageNumber * this.size,
                    end = start + this.size;

                if (this.search === "") {
                    this.total = this.wardData.length;
                    return this.wardData.slice(start, end);
                }

                //Return the total results of the filters
                this.total = this.wardData.filter((item) => {
                    return item.subject_name
                        .toLowerCase()
                        .includes(this.search.toLowerCase());
                }).length;

                //Return the filtered data
                return this.wardData
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
