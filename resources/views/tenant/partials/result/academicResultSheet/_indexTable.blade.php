
<div class="mt-8">
    <div class=" sm:block">
        <div class="max-w-6xl mx-auto  sm:px-6 ">
            <div class="flex flex-col mt-2">
                <div class="align-middle min-w-full overflow-x-auto  overflow-hidden ">
                    <table class="min-w-full divide-y  divide-purple-100">
                        <thead>
                        <tr>
                            <th class="px-6 py-3 w-1  text-left text-sm font-medium text-gray-500 uppercase">
                                SN
                            </th>

                            <th class="px-6 py-3 w-64  text-left  font-medium text-gray-500 text-sm ">
                                <span class="flex items-center mx-1">
                                    Student name
                                 <span>
                                <img src="{{asset('images/filter_alt_black_24dp.svg')}}" alt="" class="w-4">
                                 </span>
                                </span>
                            </th>
                            <th class="px-6 py-3  text-center  font-medium text-gray-500 text-sm">
                                Matriculation Number
                            </th>
                            <th class="px-6 py-3 w-  text-center text-sm font-medium text-gray-500">
                                Action
                            </th>
                        </tr>
                        </thead>
                        <template x-for="(content, index) in filteredStudentTable" :key="index">
                            <tbody class="bg-white divide-y divide-purple-100">
                            <tr class="bg-white">

                                <td class="max-w-0  px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div class="flex">
                                        <p class="group inline-flex space-x-2 truncate">
                                            <span class="text-gray-500 truncate" x-text="index + 1"></span>
                                        </p>
                                    </div>
                                </td>

                                <td class="max-w-0 text-sm px-6 py-4 whitespace-nowrap text-gray-900">
                                    <div class="flex">
                                        <p class="group inline-flex space-x-2 truncate">
                                            <span class="text-gray-500 truncate capitalize" x-text="content.first_name"></span>
                                            <span class="text-gray-500 truncate capitalize" x-text="content.last_name"></span>
                                        </p>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-center text-xs whitespace-nowrap text-gray-200">
                                    <span class="text-gray-500 truncate capitalize" x-text="content.matriculation_number ? content.matriculation_number : 'not present' "></span>
                                </td>

                                <td class="md:px-6 py-4 text-center whitespace-nowrap text-sm text-gray-200">
                                    <a href="{{route('singleReportSheet', ['classArmId','studentId'])}}" class="viewResultSheetButton" x-bind:data-id="content.uuid" x-bind:data-desc="content.class_arm">
                                        <button
                                            type="button"
                                            class="focus:outline-none">
                                            <svg class="h-4 w-4  mx-2" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                 viewBox="0 0 488.85 488.85" style="enable-background:new 0 0 488.85 488.85;" xml:space="preserve">
                            <path d="M244.425,98.725c-93.4,0-178.1,51.1-240.6,134.1c-5.1,6.8-5.1,16.3,0,23.1c62.5,83.1,147.2,134.2,240.6,134.2
                                s178.1-51.1,240.6-134.1c5.1-6.8,5.1-16.3,0-23.1C422.525,149.825,337.825,98.725,244.425,98.725z M251.125,347.025
                                c-62,3.9-113.2-47.2-109.3-109.3c3.2-51.2,44.7-92.7,95.9-95.9c62-3.9,113.2,47.2,109.3,109.3
                                C343.725,302.225,302.225,343.725,251.125,347.025z M248.025,299.625c-33.4,2.1-61-25.4-58.8-58.8c1.7-27.6,24.1-49.9,51.7-51.7
                                c33.4-2.1,61,25.4,58.8,58.8C297.925,275.625,275.525,297.925,248.025,299.625z"/>
                        </svg>
                                        </button>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </template>
                    </table>
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




