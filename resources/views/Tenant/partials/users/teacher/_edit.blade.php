<div class="lg:px-8">
    <div class="mt-2 text-xl text-gray-200">
        Teacher: <span class="capitalize">{{$teacher->full_name}}</span>
    </div>
    <div>
        <a href="{{route('listTeacher')}}" class="relative">
                    <span class=" text-sm text-gray-300 absolute">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                      </svg>
                    </span>
            <span class="px-7 text-sm text-gray-300">Teachers</span>
        </a>
    </div>

    <div class="mt-8 bg-white rounded-md" x-data="teacher()">
        <div class=" sm:block">
            <div class="max-w-6xl mx-auto  sm:px-6">
                <div class="flex mt-2 py-10">
                    <div class="w-1/2 space-y-4">
                        <div class="capitalize">
                            Full Name: {{$teacher->full_name}}
                        </div>
                        <div>
                            Address: {{$teacher->address}}
                        </div>
                        <div>
                            Email: {{$teacher->email}}
                        </div>
                        <div class="capitalize">
                            Designation: {{$teacher->subjectTeacher()->exists() ? 'subject teacher,' : ''}} {{$teacher->classArm()->exists() ? 'class teacher' : ''}}
                        </div>
                        <div>
                            Staff Number: {{$teacher->staff_id ?? 'not present'}}
                        </div>
                    </div>
                    <div class="w-1/2">
                        <div class="space-x-4">
                            <button x-on:click="isSuspendModalOpen = true;" type="button" class="bg-purple-300 text-grey-300 px-6 py-2 rounded-md text-sm">
                                Suspend Access
                            </button>
                            <button x-on:click="isDeleteModalOpen = true;" type="button" class="bg-red-200 text-blue-100 px-6 py-2 rounded-md text-sm">
                                Remove Teacher
                            </button>
                        </div>
                    </div>
                </div>
                <div class="mt-2 pb-10">
                    <!-- tab -->
                    <div class="my-5">
                        <!-- tab header -->
                        <div class="flex space-x-10 border-b pb-1 border-gray-300">
                            <div>
                                <p x-on:click=" teacherDesignation = '1' " :class="teacherDesignation === '1' ? 'text-blue-100' : 'text-gray-300' " class="text-sm cursor-pointer">
                                    Classes
                                </p>
                            </div>
                            <div>
                                <p x-on:click=" teacherDesignation = '2' " :class="teacherDesignation === '2' ? 'text-blue-100' : 'text-gray-300' " class="text-sm cursor-pointer">
                                    Subjects
                                </p>
                            </div>
                        </div>
                        <!--/: tab header -->
                        <!-- tab body -->
                        <div class="pt-3">
                            <div x-show="teacherDesignation === '1'">
                                @include('Tenant.partials.users.teacher.partials._classArmTable')
                            </div>
                            <div x-show="teacherDesignation === '2'">
                                @include('Tenant.partials.users.teacher.partials._subject')
                            </div>
                        </div>
                        <!--/: tab body -->
                    </div>
                    <!--/: tab -->
                </div>
            </div>
        </div>

        <!-- delete modal -->
            @include('Tenant.partials.users.teacher.partials._confirmDeleteModal')
        <!--/: delete modal -->

        <!-- suspend modal -->
            @include('Tenant.partials.users.teacher.partials._confirmSuspendModal')
        <!--/: suspend modal -->

    </div>

</div>

<script>
    function teacher() {
        return{
            teacherDesignation: '1',

            suspendTeacherAccess(){},
            removeTeacher(){},

            isDeleteModalOpen: false,
            isSuspendModalOpen: false,
        }
    }
</script>
