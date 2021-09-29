<div class="px-4 sm:px-6 lg:px-8" x-data="adminUser()">
    <div>
        <div class="mt-2 text-xl text-gray-200">
            Admin Users
        </div>
        <span class="mt-2 text-base text-gray-300">{{$totalUsers}} Total Admin Users</span>
    </div>
    <div class="bg-white rounded-md mt-8">
        <div class="md:flex md:items-center md:mt-2 ">
            <div class="py-6 px-2 relative w-full">
                <a href="{{route('createAdminUser')}}" class="bg-blue-100 text-white rounded-md py-3 mx-2 md:w-1/4 w-1/3  text-sm flex items-center" >
                <span class="mx-2">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </span>
                    <span class="mx-2">Add New Admin User</span>
                </a>
            </div>
        </div>
        @include('tenant.partials.users.admin.partials._indexTable')
    </div>
</div>

<script>
    function adminUser() {
        return{
            search: "",
            pageNumber: 0,
            size: 10,
            total: "",
            userData: {!! $users !!},
            get filteredUserTable() {
                const start = this.pageNumber * this.size,
                    end = start + this.size;
                if (this.search === "") {
                    this.total = this.userData.length;
                    return this.userData.slice(start, end);
                }
                //Return the total results of the filters
                this.total = this.userData.filter((item) => {
                    return item.subject_name
                        .toLowerCase()
                        .includes(this.search.toLowerCase());
                }).length;
                //Return the filtered data
                return this.userData
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
