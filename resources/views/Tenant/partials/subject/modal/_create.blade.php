
<form action="{{route('storeSubject')}}" method="post" class="overflow-auto" style="background-color:rgba(190,192,201,0.7); display:none" x-show="isCreateModalOpen" :class="{ 'absolute inset-0 z-10 flex items-center justify-center': isCreateModalOpen }">
    @csrf
    <div class="mt-12 sm:mx-auto sm:w-full sm:max-w-md md:max-w-md  bg-white rounded-lg shadow-md">
        <div class="flex items-center justify-between mt-3 text-gray-200 text-base mx-4 ">
            <div class="block">
                <span>Create Subject</span>
                <span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
              </svg>
            </span>
            </div>
            <button type="button" x-on:click="closeCreateModal()" class="focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </button>
        </div>
        <div class=" mx-4" >

            <div class="my-6">
                <label for="service" class="block text-xs font-normal text-gray-100">Subject Name</label>
                <div class="relative inline-block w-full rounded-md ">
                    <button x-on:click="isSelectSubjectDropdownOpen = true" type="button" class=" z-0 w-full py-2 pl-3 pr-10 text-left font-normal border border-purple-100 rounded-md cursor-default focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5 text-gray-200">
                        <span class="capitalize" x-text="subjectDropdownLabel"></span>
                        <span class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 my-2 "  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                          </svg>
                        </span>
                    </button>
                </div>
                <ul x-show="isSelectSubjectDropdownOpen"  @click.away="isSelectSubjectDropdownOpen = false" class="py-1 overflow-auto h-32 text-base leading-6 border border-purple-100
                  rounded-md shadow-xs max-h-60 focus:outline-none sm:text-sm sm:leading-5">
                    <li class="relative py-2 pl-3  text-gray-200 cursor-default select-none pr-9 hover:text-blue-100 hover:bg-purple-100">
                        <label>
                            <input
                                id="selectAllSubjects"
                                type="checkbox"
                                x-on:change="onToggleAll(event.target)"
                            >
                            <span class="px-1">Select All</span>
                        </label>
                    </li>
                    <template x-for="(subject, index) in subjects" :key="index">
                        <li class="relative py-2 pl-3  text-gray-200 cursor-default select-none pr-9 hover:text-blue-100 hover:bg-purple-100" >
                            <label>
                                <input class="subjectCheckbox"
                                       name="subjects[]"
                                       type="checkbox"
                                       x-bind:value="subject.uuid"
                                       x-on:change="onToggleSubject()"
                                >
                                <span x-text="subject.subject_name" class="inline-flex px-1 capitalize"></span>
                            </label>
                        </li>
                    </template>
                </ul>
            </div>

            <div class="mb-6">
                <button type="submit" class="bg-blue-100 text-white px-4 py-2 rounded-md text-base">
                    Create Subject
                </button>
            </div>
        </div>

    </div>
</form>
