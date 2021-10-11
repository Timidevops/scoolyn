<div class="px-4 sm:px-6 lg:px-8">
    <div>
        <div class="mt-2 text-xl text-gray-200">
            Academic Sessions
        </div>
        <p class="mt-2 text-base text-gray-300">{{$totalAcademicSessions}} Total Academic Session</p>
        <a href="{{route('listSetting')}}"><span class="mt-2  text-sm text-gray-300">/!/ Settings</span></a>
    </div>

    <div class="bg-white rounded-md" x-data="academicSession()">
        @include('tenant/partials.setting.academicCalendar._indexTable')
    </div>

</div>

<script>
    function academicSession() {
        return{
            academicSession: {!! $academicSessions !!},
            search: "",
            pageNumber: 0,
            size: 10,
            total: "",
            get academicSessionTable() {
                const start = this.pageNumber * this.size,
                    end = start + this.size;

                if (this.search === "") {
                    this.total = this.academicSession.length;
                    return this.academicSession.slice(start, end);
                }

                //Return the total results of the filters
                this.total = this.academicSession.filter((item) => {
                    return item.subject_name
                        .toLowerCase()
                        .includes(this.search.toLowerCase());
                }).length;

                //Return the filtered data
                return this.academicSession
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
