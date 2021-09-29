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

{{--        <div class="mt-4" x-data="timeTable()">--}}
{{--            Time Table--}}
{{--            <div class="bg-white px-4 py-4 rounded-md">--}}
{{--                <span>Tuesday, 23 day</span>--}}
{{--                <div>--}}
{{--                    <ul class="" >--}}
{{--                        <template x-for="item in timeTable" :key="item">--}}
{{--                        <li>--}}
{{--                            <span class="text-xs block" x-text="item.time"></span>--}}
{{--                         <div class="flex flex-row space-x-2">--}}
{{--                             <img :src="`${item.image}`" alt="Group 172">--}}
{{--                             <div class="flex items-center  bg-purple-300 px-2 py-2 rounded">--}}
{{--                                 <img src="/images/Line 14.svg" alt="line">--}}
{{--                                 <div class="mx-2">--}}
{{--                                    <span class="text-xs block text-gray-300" x-text="item.duration"></span>--}}
{{--                                     <span class="text-xs block" x-text="item.subject"></span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </li>--}}
{{--                        </template>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

        @can('update school details')
            @if( ! \App\Models\tenant\OnboardingTodoList::isHideTodoList() )
                <div class="mt-4">
            <div class="bg-white px-6 py-8 rounded-md">
                <ul class="space-y-4 text-gray-300 medium text-base" >
                    @foreach($todoLists->meta as $todoList)
                        <li class="flex items-center space-x-4 ">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="{{\App\Models\tenant\OnboardingTodoList::isTodoItemCompleted($todoList['name']) ? 'green' : 'currentColor'}}">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <a href="{{route($todoList['url'])}}">{{$todoList['description']}}</a>
                            </div>
                        </li>
                    @endforeach
                </ul>
                @if( $todoListComplete )
                    <a href="{{route('hideTodoList')}}" class="space-x-2 relative flex justify-end text-gray-300">
                    <span class="pr-10 py-1"> Don't show again</span>
                    <span class="absolute px-6 pt-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                          </svg>
                        </span>
                </a>
                @endif
            </div>
        </div>
            @endif
        @endcan

    </div>
</div>

{{--<script>--}}
{{--    function timeTable() {--}}
{{--                return {--}}
{{--                    timeTable:[--}}
{{--                       {--}}
{{--                           time:'8am',--}}
{{--                           subject: 'Maths',--}}
{{--                           duration:'8:30 am - 10 am',--}}
{{--                           image: "/images/Group 172.svg",--}}

{{--                        },--}}
{{--                        {--}}
{{--                           time:'9am',--}}
{{--                           subject: 'English',--}}
{{--                           duration:'8:30 am - 10 am',--}}
{{--                           image: "/images/Group 173.svg",--}}

{{--                        },--}}
{{--                        {--}}
{{--                           time:'10am',--}}
{{--                           subject: 'Break Time',--}}
{{--                           duration:'8:30 am - 10 am',--}}
{{--                           image: "/images/Group 174.svg",--}}

{{--                        },--}}

{{--                    ],--}}

{{--                }--}}
{{--            }--}}
{{--</script>--}}
