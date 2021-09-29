<div class="lg:px-8">
    <div>
        <div class="mt-2 text-xl text-gray-200 capitalize">
            Fees:
            <span class="text-sm">
                <span class="font-bold">{{$student->first_name}}</span>
                {{$student->other_name}} {{$student->last_name}}
            </span>
        </div>
        <p class="mt-2 text-base text-gray-300">{{$totalFees}} Total Fees</p>
        <a href="{{route('listStudent')}}" class="flex items-center space-x-1 mt-2">
            <span class=" text-sm text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                </svg>
            </span>
            <span class="text-sm text-gray-300">Back to students</span>
        </a>
    </div>

    @if($errors->any())
        <div class="mt-1 mb-5 bg-red-100 p-5 mt-8">
            @foreach ($errors->all() as $error)
                <p class="text-white">
                    {!! $error !!}
                </p>
            @endforeach
        </div>
    @endif

    <div x-data="fees()">
        <div class="bg-white rounded-md mt-8 py-6 px-5">
            <div class="space-y-4">
                <div>
                    {{$academicSessionInWord}}
                </div>
                @if($studentFees )
                    <div>
                        School Fees Status: {{$feeStatus}}
                    </div>
                    <div>
                        Total Amount: NGN {{ number_format($studentFees->amount, 2)  }}
                    </div>
                    @if($feeStatus == \App\Models\Tenant\SchoolFee::NOT_COMPLETE)
                        <div>
                            Outstanding Amount: NGN {{ number_format($studentFees->schoolFeesLeft(), 2)  }}
                        </div>
                    @endif
                    <div class="lg:flex items-center space-x-3 lg:space-y-0 space-y-3">
                        @if($feeStatus != \App\Models\Tenant\SchoolFee::PAID_STATUS)
                            <div class="lg:w-1/3">
                                <p x-on:click="isRecordStudentSchoolFeesModalOpen = true" class="bg-blue-100 cursor-pointer text-white rounded-md py-3 mx-1  text-sm flex items-center" >
                        <span class="mx-2">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                          </svg>
                        </span>
                                    <span class="mx-2">Record school fees payment</span>
                                </p>
                            </div>
                        @endif

                        @if($feeStatus != \App\Models\Tenant\SchoolFee::NOT_PAID_STATUS)
                            <div class="lg:w-1/4">
                                <a class="text-sm text-blue-100 border-b border-blue-100 pb-1 border-dashed" href="{{route('listStudentReceipt',$student->uuid)}}">View payments made</a>
                            </div>
                        @endif
                    </div>
                    <!-- recordStudentSchoolFeesModal -->
                    @include('tenant.partials.fees.student._recordStudentSchoolFeesModal')
                    <!-- recordStudentSchoolFeesModal -->
                @endif
            </div>
        </div>

        <div class="bg-white rounded-md" >
{{--            <div class="md:flex md:justify-end md:mt-2 py-6 px-2">--}}
{{--                <p x-on:click="isAddFeeModalOpen = true" class="bg-blue-100 cursor-pointer text-white rounded-md py-3 mx-2 md:w-1/4  text-sm flex items-center" >--}}
{{--                    <span class="mx-2">--}}
{{--                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">--}}
{{--                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />--}}
{{--                      </svg>--}}
{{--                    </span>--}}
{{--                    <span class="mx-2">Add Fees</span>--}}
{{--                </p>--}}
{{--            </div>--}}

            @include('tenant.partials.fees.student._indexTable')

            @include('tenant.partials.fees.student._addFeeModal')

        </div>
    </div>

</div>

<script>
    function fees() {
        return{

            isRecordStudentSchoolFeesModalOpen: false,

            isAddFeeModalOpen: false,
            feesStructures: [],

            search: "",
            pageNumber: 0,
            size: 5,
            total: "",
            feesTable: {!! $feesItems !!},
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
