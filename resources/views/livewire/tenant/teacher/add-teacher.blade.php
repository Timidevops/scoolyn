
<div x-data="addTeacher()">
    <form wire:submit.prevent="store">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4">
            <div class="mt-2">
                <label for="fullName" class="block text-sm font-normal text-gray-100">Full Name</label>
                <input type="text" wire:model="fullName" id="fullName" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100" required>
            </div>
            <div class="mt-2">
                <label for="email" class="block text-sm font-normal text-gray-100">Email</label>
                <input type="email" wire:model="email" id="email" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100">
            </div>
            <div class="mt-2">
                <label for="staffId" class="block text-sm font-normal text-gray-100">Staff Number</label>
                <input type="text" wire:model="staffId" id="staffId" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100 ">
            </div>
            <div class="mt-2">
                <label for="phone" class="block text-sm font-normal text-gray-100">Phone Number</label>
                <input type="text" wire:model="phone" id="phone" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100">
            </div>
            <div class="mt-2">
                <label for="address" class="block text-sm font-normal text-gray-100">Address</label>
                <input type="text" wire:model="address" id="address" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100 ">
            </div>
        </div>
        <div class="px-4 pt-4">
            <label for="address" class="block text-sm font-normal text-gray-100">Choose teacher designation</label>
            <label class="flex items-center mt-3 space-x-2 text-gray-100 text-sm">
                <input disabled id="selectAllDesignation" @click="toggleSelectAll(event.target)" type="checkbox" value="all">
{{--                <span>Select All</span>--}}
            </label>
            <div class="flex items-center mt-3  text-gray-100 text-sm">
                <template x-for="(item, index) in teacherCheckbox" :key="index">
                    <label class="flex items-center  space-x-2 mr-2">
                        <input x-on:click="toggleSelectOption(event.target); $wire.setDesignation(item.value, event.target.checked)" class="teacherDesignation" type="checkbox" x-bind:value="item.value">
                        <span x-text="item.title"></span>
                    </label>
                </template>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4">
            <div x-show="isClassTeacherDivVisible" class="mt-2">
                <p @click="isSelectClassModalOpen = true;" class="block cursor-pointer border-b border-dotted pb-1 w-1/3 text-sm font-normal text-blue-100">Choose a class</p>
                <!-- Modal -->
                    @include('tenant.partials.users.teacher.modal._selectClass')
                <!--/: Modal -->
            </div>
            <div x-show="isSubjectTeacherDivVisible" class="mt-2">
                <p @click="isSelectSubjectModalOpen = true;" class="block cursor-pointer border-b border-dotted pb-1 w-5/12 text-sm font-normal text-blue-100">Choose class subject</p>
                <!-- Modal -->
                    @include('tenant.partials.users.teacher.modal._selectSubject')
                <!--/: Modal -->
            </div>
        </div>
        <div class="px-4 py-4">
            <button type="submit" class="bg-blue-100 text-white rounded-md py-3 px-2  md:w-1/5 text-sm">
                Add Teacher
            </button>
        </div>
    </form>
</div>

<script>
    function addTeacher() {
        return{
            teacherCheckbox: [
                {title: 'Class Teacher', value: 'class-teacher' },
                {title: 'Subject Teacher', value: 'subject-teacher' }
            ],
            toggleSelectAll(event){
                let checked = event.checked;
                document.querySelectorAll('.teacherDesignation').forEach(e => e.checked = checked);
                this.isClassTeacherDivVisible   = checked;
                this.isSubjectTeacherDivVisible = checked;
            },
            isClassTeacherDivVisible: false,
            isSelectClassModalOpen: false,
            isSubjectTeacherDivVisible: false,
            isSelectSubjectModalOpen: false,
            toggleSelectOption(event){
                let checked = event.checked;
                if(event.value === 'class-teacher') this.isClassTeacherDivVisible   = checked;
                if(event.value === 'subject-teacher') this.isSubjectTeacherDivVisible = checked;

                let totalChecked = 0;

                document.querySelectorAll('.teacherDesignation').forEach(e => totalChecked +=  e.checked ? 1 : 0);

                ! this.isClassTeacherDivVisible ?
                    document.getElementById('selectAllDesignation').checked = false : null;

                ! this.isSubjectTeacherDivVisible ?
                    document.getElementById('selectAllDesignation').checked = false : null;

                this.isClassTeacherDivVisible && this.isSubjectTeacherDivVisible && totalChecked === 2 ?
                    document.getElementById('selectAllDesignation').checked = true : null;
            }
        }
    }
</script>
