<div class="px-4 sm:px-6 lg:px-8">
    <div>
        <div class="mt-2 text-xl text-gray-200">
            Teacher
        </div>
        <span class="mt-2 text-base text-gray-300">{{$totalTeachers}} Total Teachers</span>
    </div>

    <div class="bg-white mt-8 rounded-md" x-data="teacher()">
        <div class="md:flex md:items-center md:mt-2 ">
            <div class="py-6 px-2 relative w-full">
                <div>
                    <form action="{{route('listTeacher')}}" method="GET">
                        @csrf
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <div class="relative flex items-stretch flex-grow focus-within:z-10">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="h-5 w-5">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </span>
                                </div>
                                <input type="text" name="search" id="search" class="py-3 px-10 w-full border border-purple-100 rounded-md rounded-r-none  bg-white" placeholder="Search by full name or Staff ID">
                            </div>
                            <button type="submit" class="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 bg-blue-100 text-white">
                                <span>Search</span>
                            </button>
                        </div>
                    </form>
                    @if(request()->has('search'))
                        <div class="text-sm mt-2 flex">
                            <a href="{{route('listTeacher')}}">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                            </a>
                            <a href="{{route('listTeacher')}}" class="text-xs">
                                Clear filter</a>
                        </div>
                    @endif
                </div>
            </div>
            <a href="{{route('createTeacher')}}" class="bg-blue-100 text-white rounded-md py-3 mx-2 md:w-1/4 w-1/3  text-sm flex items-center" >
        <span class="mx-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </span>
                <span class="mx-2">Add Teacher</span>
            </a>
        </div>

        @include('tenant.partials.users.teacher._teacherTable')
    </div>

</div>
<script>
    function teacher(){
        return{
            search: "",
            pageNumber: 0,
            size: 10,
            total: "",
            teacherTable: {!! $teachers !!},
            get filteredTeacherTable() {
                const start = this.pageNumber * this.size,
                    end = start + this.size;
                if (this.search === "") {
                    this.total = this.teacherTable.length;
                    return this.teacherTable.slice(start, end);
                }
                //Return the total results of the filters
                this.total = this.teacherTable.filter((item) => {
                    return item.subject_name
                        .toLowerCase()
                        .includes(this.search.toLowerCase());
                }).length;
                //Return the filtered data
                return this.teacherTable
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
