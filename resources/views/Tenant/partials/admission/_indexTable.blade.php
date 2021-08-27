<div class="mt-8">
    <div class=" sm:block">
        <div class="max-w-6xl mx-auto  sm:px-6 ">
            <div class="flex flex-col mt-2">
                <div class="align-middle min-w-full overflow-x-auto  overflow-hidden ">
                    <form action="{{route('updateApplicants')}}" method="post">
                        @csrf
                        <div class="pb-3 pt-3 flex items-end">
                            <div class="w-1/2 px-1">
                                <label for="admissionStatus" class="block text-sm font-normal text-gray-100">Change Admission Status</label>
                                <select id="admissionStatus" name="admissionStatus" class="w-full capitalize text-gray-100 rounded-md py-2 px-2 border border-purple-100 ">
                                    <option value="">-- Select Status --</option>
                                    <option value="{{\App\Models\Tenant\AdmissionApplicant::ADMITTED_STATUS}}">
                                        {{str_replace('_', ' ', \App\Models\Tenant\AdmissionApplicant::ADMITTED_STATUS)}}
                                    </option>
                                    <option value="{{\App\Models\Tenant\AdmissionApplicant::REJECTED_STATUS}}">
                                        {{str_replace('_', ' ', \App\Models\Tenant\AdmissionApplicant::REJECTED_STATUS)}}
                                    </option>
                                </select>
                            </div>
                            <div class="w-1/2 px-1">
                                <label for="examDate" class="block text-sm font-normal text-gray-100">Schedule Exam Date</label>
                                <input type="date" id="examDate" name="examDate" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100">
                            </div>
                            <div class="w-2/5 px-1">
                                <button type="submit" class="bg-blue-100 w-full text-white rounded-md py-3 px-3  text-sm" >
                                    Submit
                                </button>
                            </div>
                        </div>
                        <table class="min-w-full divide-y  divide-purple-100">
                            <thead>
                            <tr>
                                <th>
                                    <input id="" @click="onSelectAllApplicants(event.target)" type="checkbox">
                                </th>
                                <th class="px-6 py-3 w-1  text-left text-sm font-medium text-gray-500 uppercase">
                                    SN
                                </th>

                                <th class="px-6 py-3  text-left  font-medium text-gray-500 text-sm">
                            <span class="flex items-center mx-1">
                            Applicant Name
                            <span>
                    <img src="{{asset('images/filter_alt_black_24dp.svg')}}" alt="" class="w-4">
                     </span>
                    </span>
                                </th>

                                <th class="px-6 py-3  text-left  font-medium text-gray-500 text-sm">
                                    Status
                                </th>
                                <th class="px-6 py-3  text-left  font-medium text-gray-500 text-sm">
                                    Class Applying To
                                </th>
                                <th class="px-6 py-3  text-left  font-medium text-gray-500 text-sm">
                                    Exam Date
                                </th>
                                <th class="px-6 py-3 w-  text-left text-sm font-medium text-gray-500">
                                    Action
                                </th>

                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-purple-100">
                            <template x-for="(content, index) in applicantTable" :key="index">
                                <tr class="bg-white">

                                    <td>
                                        <input name="selectedId[]" :value="content.uuid" type="checkbox" class="applicantCheckbox">
                                    </td>
                                    <td class="max-w-0  px-6 py-4 whitespace-nowrap text-xs text-gray-900">
                                        <div class="flex">
                                            <p class="group inline-flex space-x-2 truncate capitalize">
                                                <span class="text-gray-500 truncate" x-text="index + 1"></span>
                                            </p>
                                        </div>
                                    </td>
                                    <td class="max-w-0  px-6 py-4 whitespace-nowrap text-xs text-gray-900">
                                        <div class="flex">
                                            <p class="group inline-flex space-x-2 truncate">
                                                <span class="text-gray-500 truncate capitalize" x-text="content.student_first_name"></span>
                                                <span class="text-gray-500 truncate capitalize" x-text="content.student_other_name"></span>
                                                <span class="text-gray-500 truncate capitalize" x-text="content.student_last_name"></span>
                                            </p>
                                        </div>
                                    </td>

                                    <td class="max-w-0  px-6 py-4 whitespace-nowrap text-xs text-gray-900">
                                        <div class="flex">
                                            <p class="group inline-flex space-x-2 truncate">
                                                <span class="text-blue-100 truncate capitalize" x-text="content.status.replace('_',' ')"></span>
                                            </p>
                                        </div>
                                    </td>

                                    <td class="max-w-0  px-6 py-4 whitespace-nowrap text-xs text-gray-900">
                                        <div class="flex">
                                            <p class="group inline-flex space-x-2 truncate">
                                                <span class="text-blue-100 truncate capitalize" x-text="content.class.replace('-', ' ')"></span>
                                            </p>
                                        </div>
                                    </td>

                                    <td class="max-w-0  px-6 py-4 whitespace-nowrap text-xs text-gray-900">
                                        <div class="flex">
                                            <p class="group inline-flex space-x-2 truncate">
                                                <span class="text-blue-100 truncate capitalize" x-text="content.exam_schedule ?? 'not assigned' "></span>
                                            </p>
                                        </div>
                                    </td>

                                    <td class="md:px-6 py-4 text-left whitespace-nowrap text-sm text-gray-200 flex items-center">
                                        <a :href=`{{route('singleApplicant','')}}/${content.uuid}`>
                                            <button type="button" class="focus:outline-none" x-on:click="editModal = true">
                                                /!/
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                            </template>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
        <nav class="max-w-6xl  mx-auto px-4 lg:px-8 my-4  bg-white  md:flex md:items-center md:justify-between border-lighter-gray sm:px-6">
            <div
                class="mt-6 mb-6 flex flex-wrap justify-between items-center text-sm leading-5 text-gray"
            >
                <div
                    class="w-full sm:w-auto text-center sm:text-right px-1"
                    x-show="pageCount() >= 1"
                >
                    Showing
                    <span x-text="startResults()"></span> to
                    <span x-text="endResults()"></span>
                </div>

                <div
                    class="w-full sm:w-auto text-center sm:text-left"
                    x-show="total > 0"
                >
                    of
                    <span class="font-bold" x-text="total"></span> Entries
                </div>

                <!--Message to display when no results-->
                <div class="mx-auto flex items-center font-bold text-red-500" x-show="total===0">
                    <svg class="h-8 w-8 text-red-500" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" /><circle cx="12" cy="12" r="9" /><line x1="9" y1="10" x2="9.01" y2="10" /><line x1="15" y1="10" x2="15.01" y2="10" /><path d="M9.5 16a10 10 0 0 1 6 -1.5" />
                    </svg>
                    <span class="ml-4"> No results!!</span>
                </div>
            </div>
            <div class=" flex justify-center items-center md:mt-0 mt-4  md:flex md:justify-end md:items-center"
                 x-show="pageCount() > 1">
                <!--First Button-->
                <button type="button" class="border border-gray rounded py-1 px-2 mx-4  text-blue-100" x-on:click="viewPage(Math.round( pageNumber - 1 ))" :disabled="pageNumber===0" :class="{ 'disabled cursor-not-allowed text-gray-100' : pageNumber===0 }">
                    Previous
                </button>
                <!--Last Button-->
                <button type="button" class="border border-gray rounded py-1 px-6 text-blue-100" x-on:click="viewPage(Math.round(pageCount() - (pageCount() - 1) + pageNumber))" :disabled="pageNumber >= pageCount() -1" :class="{ 'disabled cursor-not-allowed text-gray-100' : pageNumber >= pageCount() -1 }"
                >Next
                </button>
            </div>
        </nav>

    </div>

</div>




