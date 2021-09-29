<div class="px-4 sm:px-6 lg:px-8">
<div>
    <div class="mt-2 text-xl text-gray-200">
        Subject: <span class="capitalize">{{$studentName}}</span>
    </div>
    <p class="mt-2 text-base text-gray-300">{{$totalSubject}} Total Subjects</p>
    <a href="{{route('listStudent')}}" class="flex items-center space-x-1 mt-2">
        <span class=" text-sm text-gray-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
            </svg>
        </span>
        <span class="text-sm text-gray-300">Students</span>
    </a>
</div>

@if($errors->any())
    <div class="mt-1 mb-5 bg-red-100 p-5">
        @foreach ($errors->all() as $error)
            <p class="text-white">
                {!! $error !!}
            </p>
        @endforeach
    </div>
@endif

<div class="bg-white mt-8 rounded-md" x-data="student()">
    <div class="md:flex md:items-center md:mt-2">
        <div class="py-6 px-2 relative w-full">
            <div class="">
                <input type="search" name="" id="" class="py-3 px-10 w-full border border-purple-100 rounded-md  bg-white"  placeholder="Search">
                <span class="absolute inset-y-0 left-0 pl-6 py-10"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
     </svg>
   </span>
            </div>

        </div>
        <!-- add subject modal -->
            @include('tenant.partials.users.student.subject._create')
        <!--/: add subject modal -->
    </div>
    @include('tenant.partials.users.student.subject._indexTable')
</div>
</div>
<script>
    function student() {
        return{
            studentSubject: {!! $studentSubject !!},
            search: "",
            pageNumber: 0,
            size: 5,
            total: "",
            get filteredStudentSubjectTable() {
                const start = this.pageNumber * this.size,
                    end = start + this.size;
                if (this.search === "") {
                    this.total = this.studentSubject.length;
                    return this.studentSubject.slice(start, end);
                }
                //Return the total results of the filters
                this.total = this.studentSubject.filter((item) => {
                    return item.subject_name
                        .toLowerCase()
                        .includes(this.search.toLowerCase());
                }).length;
                //Return the filtered data
                return this.studentSubject
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
