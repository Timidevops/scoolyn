<div>
    <div class="mt-2 text-xl text-gray-200">
        Add New Teacher
    </div>
    <a href="{{route('listTeacher')}}"><span class="mt-2  text-sm text-gray-300">/!/ Back to teachers</span></a>
</div>
<div class="h-screen py-10">
    <div class="bg-white rounded-md "  >
        <form action="{{route('storeTeacher')}}" method="post">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4">
                <div class="mt-2">
                    <label for="fullName" class="block text-sm font-normal text-gray-100">Full Name</label>
                    <input type="text" name="fullName" id="fullName" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100" required x-model="newTodo" >
                </div>
                <div class="mt-2">
                    <label for="email" class="block text-sm font-normal text-gray-100">Email</label>
                    <input type="email" name="email" id="email" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100" required>
                </div>
                <div class="mt-2">
                    <label for="staffId" class="block text-sm font-normal text-gray-100">Staff Identification</label>
                    <input type="text" name="staffId" id="staffId" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100 " required>
                </div>
                <div class="mt-2">
                    <label for="address" class="block text-sm font-normal text-gray-100">Address</label>
                    <input type="text" name="address" id="address" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100 " required>
                </div>
                <div class="mt-2"  x-data="selectBox()">
                   <div class="flex items-center  space-x-2 text-gray-100 text-sm">
                   <template x-for="(selectTeacher, index) in selectTeachers" :key="index">
                    <span class="flex items-center  space-x-2">
                        <input type="checkbox" id="checkbox">
                        <p class=" font-normal" x-text="selectTeacher.name"></p>
                    </span>
                   </template>
                   <input name="" type="checkbox" x-on:click="toggleAllCheckboxes(); options=true" class=""><span>All</span>
                   </div>
                   <div x-show="options" >
                    <div>
                        <label for="desgination"></label>
                        <button type="button">
                         select class 
                       </button> 
                    </div>
                    <div>
                        <label for="desgination"></label>
                        <button type="button">
                         select subject 
                       </button> 
                    </div> 
                </div>    
                </div>    
            </div>
            <div class="px-4 py-4">
                <button type="submit" href="" class="bg-blue-100 text-white rounded-md py-3 px-2  md:w-1/5 text-sm" x-on:click="addToDo">
                    Add Teacher
                </button>
            </div>
        </form>

    </div>
</div>

<script>
        function selectBox() {
            return {
                options:false,
                selectTeachers: 
                [
                    {name:'Class Teacher'},
                    {name:'Teacher'}, 
                ],
                selectall: false,
                toggleAllCheckboxes() {
                this.selectall = !this.selectall,
                checkboxes = document.querySelectorAll('[id^=checkbox]');
                [...checkboxes].map((el) => {
                el.checked = this.selectall;
                (this.options = true ),
                this.options=false
            })
        },
        }
        }
    </script>