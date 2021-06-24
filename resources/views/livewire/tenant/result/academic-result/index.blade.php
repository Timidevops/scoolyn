
<div x-data="academicResult()">
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
        <button type="button" class="bg-blue-100 text-white rounded-md py-3 mx-2 md:w-1/4 w-1/3  text-sm flex items-center" >
            <span class="mx-1">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </span>
            <span class="mx-1">Submit Result</span>
        </button>
    </div>
    <div class="mt-1">
        <div class=" sm:block">
            <div class="max-w-6xl mx-auto px-2 ">
                <div class="flex flex-col">
                    <div class="align-middle min-w-full overflow-x-auto  overflow-hidden ">
                        <div class="w-1/3 pt-2 pb-3">
                            <p class="text-gray-300 text-sm py-1 relative">
                                Total subjects:
                                <span class="absolute right-0 text-blue-100">{{$totalSubjects}}</span>
                            </p>
                            <p class="text-gray-300 text-sm py-1 relative">
                                Total submitted broadsheets:
                                <span class="absolute right-0 text-blue-100">{{$totalSubmittedBroadsheet}}</span>
                            </p>
                            <p class="text-gray-300 text-sm py-1 relative">
                                Total awaiting broadsheets:
                                <span class="absolute right-0 text-blue-100">{{$totalAwaitingBroadsheet}}</span>
                            </p>
                            <p class="text-gray-300 text-sm py-1 relative">
                                Total not-approved broadsheets:
                                <span class="absolute right-0 text-blue-100">{{$totalNotApprovedBroadsheet}}</span>
                            </p>
                        </div>
                        <!-- tab section -->
                            <div class="my-5">
                                <!-- tab header -->
                                    <div class="flex justify-between border-b pb-1 border-gray-300">
                                        <div>
                                            <p x-on:click=" broadsheetTabOpen = '1' " :class="broadsheetTabOpen === '1' ? 'text-blue-100' : 'text-gray-300' " class="text-sm cursor-pointer">Submitted broadsheet</p>
                                        </div>
                                        <div>
                                            <p x-on:click=" broadsheetTabOpen = '2' " :class="broadsheetTabOpen === '2' ? 'text-blue-100' : 'text-gray-300' " class="text-sm cursor-pointer">Awaiting broadsheet</p>
                                        </div>
                                        <div>
                                            <p x-on:click=" broadsheetTabOpen = '3' " :class="broadsheetTabOpen === '3' ? 'text-blue-100' : 'text-gray-300' " class="text-sm cursor-pointer">Not approved broadsheet</p>
                                        </div>
                                    </div>
                                <!--/: tab header -->
                                <!-- tab body -->
                                    <div class="pt-3">
                                        <div x-show="broadsheetTabOpen === '1'">
                                            @include('Tenant.partials.result.academicResult.table._submitted')
                                        </div>
                                        <div x-show="broadsheetTabOpen === '2'">
                                            @include('Tenant.partials.result.academicResult.table._awaiting')
                                        </div>
                                        <div x-show="broadsheetTabOpen === '3'">
                                            @include('Tenant.partials.result.academicResult.table._notApproved')
                                        </div>
                                    </div>
                                <!--/: tab body -->
                            </div>
                        <!--/: tab section -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    function academicResult() {
        return{
            broadsheetTabOpen: '1',
        }
    }
</script>
