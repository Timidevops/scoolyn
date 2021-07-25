<div>
    <div class="mt-2 text-xl text-gray-200">
        Fees: {{$student->first_name}} {{$student->last_name}}
    </div>
    <p class="mt-2 text-base text-gray-300">{{$totalFees}} Total Fees</p>
    <a href="{{route('listStudent')}}"><span class="mt-2  text-sm text-gray-300">/!/ Back to students</span></a>
</div>


<div class="bg-white rounded-md" x-data="fees()">
    <div class="md:flex md:justify-end md:mt-2 py-6 px-2">
        <p x-on:click="isAddFeeModalOpen = true" class="bg-blue-100 cursor-pointer text-white rounded-md py-3 mx-2 md:w-1/4 w-1/3  text-sm flex items-center" >
            <span class="mx-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </span>
            <span class="mx-2">Add Fees</span>
        </p>
    </div>

    @include('Tenant.partials.fees.student._indexTable')

    @include('Tenant.partials.fees.student._addFeeModal')
</div>

<script>
    function fees() {
        return{
            isAddFeeModalOpen: false,
            feesStructures: {!! $feesStructures !!},

            search: "",
            pageNumber: 0,
            size: 5,
            total: "",
            feesTable: {!! $studentFees !!},
            get filteredFeesTable() {
                const start = this.pageNumber * this.size,
                    end = start + this.size;
                if (this.search === "") {
                    this.total = this.feesTable.length;
                    return this.feesTable.slice(start, end);
                }
                //Return the total results of the filters
                this.total = this.feesTable.filter((item) => {
                    return item.subject_name
                        .toLowerCase()
                        .includes(this.search.toLowerCase());
                }).length;
                //Return the filtered data
                return this.feesTable
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
