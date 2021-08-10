<div class="mt-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
      <h2 class="block text-2xl leading-6 font-medium text-gray-900 capitalize">
          Hello, {{Auth::user()->getUserFullName()}}
      </h2>
      <span class="block text-base text-gray-100 font-light">
          Look up your school's info.
      </span>
        @can('read a user')
            <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                <div class="bg-purple-300 overflow-hidden rounded-lg ">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 text-3xl font-light text-blue-100">
                                {{$totalStudents}}
                            </div>

                            <div class="ml-5 w-0 flex-1">

                                <dl>
                                    <dt class="text-xs font-light text-gray-300 truncate">
                                        Updated 22.04.2021
                                    </dt>
                                    <dd>
                                        <div class="text-lg font-medium text-gray-900">
                                            Student
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-red-200 overflow-hidden rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 text-3xl font-light text-blue-100">
                                {{$totalTeachers}}
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-xs font-light text-gray-500 truncate">
                                        Updated 22.04.2021
                                    </dt>
                                    <dd>
                                        <div class="text-lg font-medium text-gray-900">
                                            Teacher
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-200 overflow-hidden rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 text-3xl font-light text-blue-100">
                                {{$totalParents}}
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-xs font-light text-gray-500 truncate">
                                        Updated 22.04.2021
                                    </dt>
                                    <dd>
                                        <div class="text-lg font-medium text-gray-900">
                                            Parent
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
        <div class="mt-4" x-data="timeTable()">
            Time Table
            <div class="bg-white px-4 py-4 rounded-md">
                <span>Tuesday, 23 day</span>
                <div>
                    <ul class="" >
                        <template x-for="item in timeTable" :key="item">
                        <li>
                            <span class="text-xs block" x-text="item.time"></span>
                         <div class="flex flex-row space-x-2">
                             <img :src="`${item.image}`" alt="Group 172">
                             <div class="flex items-center  bg-purple-300 px-2 py-2 rounded">
                                 <img src="/images/Line 14.svg" alt="line">
                                 <div class="mx-2">
                                    <span class="text-xs block text-gray-300" x-text="item.duration"></span>
                                     <span class="text-xs block" x-text="item.subject"></span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        </template>
                    </ul>
                </div>
            </div>
        </div>



    </div>
</div>

<script>
    function timeTable() {
                return {
                    timeTable:[
                       {
                           time:'8am',
                           subject: 'Maths',
                           duration:'8:30 am - 10 am',
                           image: "/images/Group 172.svg",

                        },
                        {
                           time:'9am',
                           subject: 'English',
                           duration:'8:30 am - 10 am',
                           image: "/images/Group 173.svg",

                        },
                        {
                           time:'10am',
                           subject: 'Break Time',
                           duration:'8:30 am - 10 am',
                           image: "/images/Group 174.svg",

                        },

                    ],

                }
            }
    </script>
