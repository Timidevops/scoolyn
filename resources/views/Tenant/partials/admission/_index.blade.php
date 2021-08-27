<div class="px-4 sm:px-6 lg:px-8">
    <div>
        <div class="mt-2 text-xl text-gray-200">
            Admission: Applicant
        </div>
        <span class="mt-2 text-base text-gray-300">{{$totalApplicants}} Total Applicants</span>
    </div>

    <div class="bg-white rounded-md" x-data="applicants()">
        @include('Tenant.partials.admission._indexTable')
    </div>

</div>

<script>
    function applicants() {
        return{
            applicantTable: {!! $applicants !!},
            search: "",
            pageNumber: 0,
            size: 10,
            total: "",
            get filteredApplicantTable() {
                const start = this.pageNumber * this.size,
                    end = start + this.size;

                if (this.search === "") {
                    this.total = this.applicantTable.length;
                    return this.applicantTable.slice(start, end);
                }

                //Return the total results of the filters
                this.total = this.applicantTable.filter((item) => {
                    return item.subject_name
                        .toLowerCase()
                        .includes(this.search.toLowerCase());
                }).length;

                //Return the filtered data
                return this.applicantTable
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
            selectedId: [],
            onSelectAllApplicants(event){
                let checked = event.checked;

                document.querySelectorAll('.applicantCheckbox').forEach(function (e) {
                    e.checked = checked;
                });
            },

        }
    }
</script>
