<div class="md:mt-8"  >
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

                  <th class="px-6 py-3   text-left  font-medium text-gray-500 text-sm ">
                    <span class="flex items-center mx-1">
                        Name
                     <span>
                    <img src="{{asset('images/filter_alt_black_24dp.svg')}}" alt="" class="w-4">
                     </span>
                    </span>
                    </th>

                     <th class="px-6 py-3  text-left  font-medium text-gray-500 text-sm">
                        Matric No
                      </th>

                      <th class="px-6 py-3   text-left  font-medium text-gray-500 text-sm">
                        Class
                      </th>

                      <th class="px-6 py-3 w-  text-left text-sm font-medium text-gray-500">
                          Action
                      </th>

              </tr>
              </thead>
              <tbody>
                <template x-for="(item, index) in filteredStudentTable" :key="index">
                    <tr class="bg-white divide-y divide-purple-100">

                        <td class="max-w-0  px-6 py-4 whitespace-nowrap text-xs text-gray-900">
                            <div class="flex">
                                <p class="group inline-flex space-x-2 truncate">
                                    <span class="text-gray-500 truncate"  x-text=" index +1 "></span>
                                </p>
                            </div>
                        </td>

                        <td class="max-w-0 px-6 py-4 whitespace-nowrap text-xs text-gray-900">
                            <div class="flex">
                                <p class="group inline-flex space-x-2 truncate capitalize">
                                    <span class="text-gray-500 truncate"  x-text="item.first_name"></span>
                                    <span class="text-gray-500 truncate"  x-text="item.last_name"></span>
                                </p>
                            </div>
                        </td>

                        <td class="px-6 py-4 text-left whitespace-nowrap text-xs text-gray-200 ">
                              <span class="text-gray-200 font-normal" x-text="item.matriculation_number ? item.matriculation_number : 'not present' "></span>
                        </td>

                        <td class="px-6 py-4 text-left whitespace-nowrap text-xs text-gray-200">
                            <span class="text-gray-200 font-normal" x-text="item.class_arm.school_class.class_name"></span>
                            <p class="text-gray-200 font-normal" x-text="item.class_arm.class_section ? item.class_arm.class_section.section_name : '' "></p>
                            &nbsp;
                            <p class="text-gray-200 font-normal" x-text="item.class_arm.class_section_category ? `- ${item.class_arm.class_section_category.category_name}` : '' "></p>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex h-full items-center">
                                <button>
                                    <a x-bind:href="`{{route('listStudentSubject','')}}/${item.uuid}`">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-100 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </a>
                                </button>
                                <button class="focus:outline-none" @click="onClickOpenStudentProfile(item.uuid)">
                                    <svg class="svg-icon h-4 w-4 text-blue-100 mx-2" viewBox="0 0 20 20">
                                        <path d="M12.075,10.812c1.358-0.853,2.242-2.507,2.242-4.037c0-2.181-1.795-4.618-4.198-4.618S5.921,4.594,5.921,6.775c0,1.53,0.884,3.185,2.242,4.037c-3.222,0.865-5.6,3.807-5.6,7.298c0,0.23,0.189,0.42,0.42,0.42h14.273c0.23,0,0.42-0.189,0.42-0.42C17.676,14.619,15.297,11.677,12.075,10.812 M6.761,6.775c0-2.162,1.773-3.778,3.358-3.778s3.359,1.616,3.359,3.778c0,2.162-1.774,3.778-3.359,3.778S6.761,8.937,6.761,6.775 M3.415,17.69c0.218-3.51,3.142-6.297,6.704-6.297c3.562,0,6.486,2.787,6.705,6.297H3.415z"></path>
                                    </svg>
                                </button>
                                <button class="focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-100 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" >
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                                <button class="focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                </template>
              </tbody>
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
            <div
                class=" flex justify-center items-center md:mt-0 mt-4 md:flex md:justify-end md:items-center"
                x-show="pageCount() > 1">
                <!--First Button-->
                <button class="border border-gray rounded py-1 px-2 mx-4 text-blue-100" x-on:click="viewPage(0)" :disabled="pageNumber==0" :class="{ 'disabled cursor-not-allowed text-gray-100' : pageNumber==0 }">
                    Previous
                </button>
                <!--Last Button-->
                <button class="border border-gray rounded py-1 px-6 text-blue-100" x-on:click="viewPage(Math.ceil(total/size)-1)" :disabled="pageNumber >= pageCount() -1" :class="{ 'disabled cursor-not-allowed text-gray-100' : pageNumber >= pageCount() -1 }"
                >Next
                </button>
            </div>
        </nav>

        <!-- student profile -->
        <div class="overflow-auto" style="background-color:rgba(190,192,201,0.7);" x-show="isStudentProfileModalOpen" :class="{ 'absolute inset-0 z-10 flex items-center justify-center': isStudentProfileModalOpen }">
            <div class="mt-12 sm:mx-auto sm:w-full sm:max-w-md md:max-w-md  bg-white rounded-lg shadow-md">
                <div  class="p-6">
                    <div class="flex items-center justify-between border-b border-purple-100">
                        <div class="flex ">
                            <span class="cursor-pointer inline-block  rounded-t py-2  text-gray-200 text-base" :class="{ 'active border-b-2 border-blue-100': studentProfileTab == '1' }" @click.prevent="studentProfileTab = 1">Profile</span>

                            <span class="cursor-pointer inline-block py-2 px-4 text-gray-200 text-base mx-2" :class="{ 'active border-b-2 border-blue-100 ': studentProfileTab == '2' }" @click.prevent="studentProfileTab = 2">Parent info</span>
                        </div>
                        <span class="cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-on:click="isStudentProfileModalOpen = false">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </span>
                    </div>
                    <div class="w-full pt-4 text-gray-100">
                        <div x-show="studentProfileTab === 1" class="">
                            <div class="text-sm border-purple-100 border-b mt-4 ">
                                <div class="flex items-center ">
                                    <p class=" w-1/3"> Name:<p> <span class="w-2/5 capitalize" x-text="studentProfileDetail.name"></span>
                                </div>
                            </div>
                            <div class="text-sm border-purple-100 border-b mt-4">
                                <div class="flex items-center ">
                                    <p class=" w-1/3"> Class: <p><span class="w-2/5 capitalize" x-text="studentProfileDetail.class"></span>
                                </div>
                            </div>
                            <div class="text-sm border-purple-100 border-b mt-4">
                                <div class="flex items-center ">
                                    <p class=" w-1/3"> Section:<p> <span class="w-2/5 capitalize" x-text="studentProfileDetail.classSection"></span> <span class="w-2/5" x-text="studentProfileDetail.classSectionCategory"></span>
                                </div>
                            </div>
                            <div class="text-sm border-purple-100 border-b mt-4">
                                <div class="flex items-center  ">
                                    <p class=" w-1/3"> Matriculation no:<p> <span class="w-2/5" x-text="studentProfileDetail.matNum"></span>
                                </div>
                            </div>
                        </div>
                        <div x-show="studentProfileTab === 2">
                            <div class="text-sm border-purple-100 border-b mt-4 ">
                                <div class="flex items-center ">
                                    <p class=" w-1/3"> Parent Name:<p> <span class="w-2/5 capitalize" x-text="studentParentDetail.parentName"></span>
                                </div>
                            </div>
                            <div class="text-sm border-purple-100 border-b mt-4">
                                <div class="flex items-center ">
                                    <p class=" w-1/3"> Parent Email: <p><span class="w-2/5" x-text="studentParentDetail.parentEmail"></span>
                                </div>
                            </div>
                            <div class="text-sm border-purple-100 border-b mt-4">
                                <div class="flex items-center ">
                                    <p class=" w-1/3"> Address:<p> <span class="w-2/5 capitalize" x-text="studentParentDetail.address"></span>
                                </div>
                            </div>
                            <div class="text-sm border-purple-100 border-b mt-4">
                                <div class="flex items-center  ">
                                    <p class=" w-1/3"> Phone Number:<p> <span class="w-2/5 capitalize" x-text="studentParentDetail.phoneNumber"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!--/: student profile -->

      </div>
  </div>
