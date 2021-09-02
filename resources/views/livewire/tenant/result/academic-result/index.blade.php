
<div x-data="academicResult()">
    <div class="md:flex md:items-center md:mt-2 px-2 py-3">

        @if( $classArm->status == \App\Models\Tenant\ClassArm::RESULT_GENERATED_STATUS )
            <p class="text-grey-100 text-sm py-1">
                Result generated,
                <a href="{{route('listReportSheet', $classArm->uuid)}}">
                    <span class="text-blue-100 border-b border-dashed cursor-pointer">
                        view result sheet.
                    </span>
                </a>
            </p>
        @else
            @if( $classArm->status == \App\Models\Tenant\ClassArm::GENERATING_RESULT_STATUS || $classArm->status == \App\Models\Tenant\ClassArm::RESULT_INCOMPLETE_STATUS )
                <p class="text-blue-100 text-sm py-1">
                    {{$classArm->status == \App\Models\Tenant\ClassArm::GENERATING_RESULT_STATUS ? 'Result is been generated...' : ''}}
                    <span class="text-red-100">
                        {{$classArm->status == \App\Models\Tenant\ClassArm::RESULT_INCOMPLETE_STATUS ? 'Result is generation was not complete' : ''}}
                    </span>
                </p>
            @else
                @if($totalSubjects == $totalApprovedBroadsheet && $totalSubjects > 0)
                    <button wire:click="generateResult" type="button" class="bg-blue-100 text-white rounded-md py-3 mx-2 md:w-1/4 w-1/3  text-sm flex items-center" >
                        <span class="mx-1">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                          </svg>
                        </span>
                        <span class="mx-1">Generate Result</span>
                    </button>
                @endif
            @endif
        @endif
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
                                Total approved broadsheets:
                                <span class="absolute right-0 text-blue-100">{{$totalApprovedBroadsheet}}</span>
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
                                Total disapproved broadsheets:
                                <span class="absolute right-0 text-blue-100">{{$totalNotApprovedBroadsheet}}</span>
                            </p>
                        </div>
                        <!-- tab section -->
                            <div class="my-5">
                                <!-- tab header -->
                                    <div class="flex justify-between border-b pb-1 border-gray-300">
                                        <div>
                                            <p x-on:click=" broadsheetTabOpen = '1' " :class="broadsheetTabOpen === '1' ? 'text-blue-100' : 'text-gray-300' " class="text-sm cursor-pointer">Approved broadsheet</p>
                                        </div>
                                        <div>
                                            <p x-on:click=" broadsheetTabOpen = '2' " :class="broadsheetTabOpen === '2' ? 'text-blue-100' : 'text-gray-300' " class="text-sm cursor-pointer">Submitted broadsheet</p>
                                        </div>
                                        <div>
                                            <p x-on:click=" broadsheetTabOpen = '3' " :class="broadsheetTabOpen === '3' ? 'text-blue-100' : 'text-gray-300' " class="text-sm cursor-pointer">Awaiting broadsheet</p>
                                        </div>
                                        <div>
                                            <p x-on:click=" broadsheetTabOpen = '4' " :class="broadsheetTabOpen === '4' ? 'text-blue-100' : 'text-gray-300' " class="text-sm cursor-pointer">Disapproved broadsheet</p>
                                        </div>
                                    </div>
                                <!--/: tab header -->
                                <!-- tab body -->
                                    <div class="pt-3">
                                        <div x-show="broadsheetTabOpen === '1'">
                                            @include('Tenant.partials.result.academicResult.table._approved')
                                        </div>
                                        <div x-show="broadsheetTabOpen === '2'">
                                            @include('Tenant.partials.result.academicResult.table._submitted')
                                        </div>
                                        <div x-show="broadsheetTabOpen === '3'">
                                            @include('Tenant.partials.result.academicResult.table._awaiting')
                                        </div>
                                        <div x-show="broadsheetTabOpen === '4'">
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
