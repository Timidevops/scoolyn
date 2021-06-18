<div x-data="studentDetails()">
<div>
    <div class="mt-2 text-xl text-gray-200">
      Student
    </div>
    <span class="mt-2 text-base text-gray-300">{{$totalStudents}} Total Students</span>
</div>
<div class="bg-white rounded-md">
<div class="md:flex md:items-center md:mt-2 ">
  <div class="py-6 px-2 relative w-full">
    <div class="">
     <input type="search" name="" id="" class="py-3 px-10 w-full border border-purple-100 rounded-md  bg-white"  placeholder="Search">
     <span class="absolute inset-y-0 left-0 pl-6 py-10"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
     </svg>
   </span>
    </div>

   </div>
   <a href="{{route('createStudent')}}" class="bg-blue-100 text-white rounded-md py-3 mx-2 px-4 md:w-1/4 text-sm relative" >
    <span class="space-x-2 left-0 my-3 mx-2 inset-y-0 absolute">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 " fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
    </span>
      <span class="ml-4">Add student</span>
  </a>
</div>

@include('Tenant.partials.users.student._studentTable')
</div>
</div>

<script>
    function studentDetails() {
        return {
            studentProfileTab: 1,
            isStudentProfileModalOpen: false,
            search: "",
            pageNumber: 0,
            size: 5,
            total: "",
            students: {!! $students !!},

            get filteredStudentTable() {
                const start = this.pageNumber * this.size,
                    end = start + this.size;
                if (this.search === "") {
                    this.total = this.students.length;
                    return this.students.slice(start, end);
                }
                //Return the total results of the filters
                this.total = this.students.filter((item) => {
                    return item.subject_name
                        .toLowerCase()
                        .includes(this.search.toLowerCase());
                }).length;
                //Return the filtered data
                return this.students
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
