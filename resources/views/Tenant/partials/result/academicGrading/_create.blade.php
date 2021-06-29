<div>
    <div class="mt-2 text-xl text-gray-200">
        Add New Academic Grading Format
    </div>
    <a href="{{route('listGradeFormat')}}">
        <span class="mt-2 text-sm text-gray-300">
            /!/ Academic Grading Formats
        </span>
    </a>
</div>

<div class="h-screen py-10">
    <div class="bg-white rounded-md " x-data="createGradingFormat()">
        <form action="{{route('storeGradeFormat')}}" method="post">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4">
                <div class="mt-2">
                    <label for="name" class="block text-sm font-normal text-gray-100">Name</label>
                    <input type="text" name="name" id="name" placeholder="optional" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100">
                </div>
                <div class="mt-2 relative">
                    <label for="schoolClass" class="block text-sm font-normal text-gray-100">Classes</label>
                    <div class="relative inline-block w-full rounded-md ">
                        <button @click="isClassDropdownOpen = ! isClassDropdownOpen" type="button" class="z-0 w-full py-2 pl-3 pr-10 text-left text-gray-100 font-normal border border-purple-100 rounded-md cursor-default focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5">
                            <span x-text="classDropdownLabel()" id="classDropdownLabel" class="px-2 mr-auto">-- select class --</span>
                        </button>
                    </div>
                    <div class="border border-purple-100 absolute w-full bg-white" x-show.transition="isClassDropdownOpen" @click.away="isClassDropdownOpen = false">
                        <ul class="py-1 overflow-auto h-32 text-base leading-6
                       shadow-xs max-h-60 focus:outline-none sm:text-sm sm:leading-5">
                            <li class="relative py-2 pl-3  text-gray-200 cursor-default select-none pr-9">
                                <label class="flex items-center">
                                    <input id="selectAllClasses" type="checkbox" x-on:change="onToggleAll(event.target)">
                                    <span class="px-1" >Select All</span>
                                </label>
                            </li>
                            <template x-for="item in schoolClasses">
                                <li class="relative py-2 pl-3  text-gray-200 cursor-default select-none pr-9">
                                    <label class="flex items-center">
                                        <input class="classCheckbox"
                                               name="schoolClass[]"
                                               type="checkbox"
                                               :data-id="item.class_name"
                                               x-bind:value="item.uuid"
                                               x-bind:checked="onCheckedClass(item.class_name)"
                                               x-on:change="onToggleClass( item.class_name, item.uuid, event.target)"
                                        >
                                        <span class="px-1" x-text="item.class_name"></span>
                                    </label>
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="p-4 w-2/5">
                <div class="mt-2">
                    <label for="" class="block text-sm font-normal text-gray-100">Academic Grading</label>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-5 gap-6 p-4 border-b border-gray-300 pb-1">
                <div class="mt-2">
                    <label class="block text-sm font-normal text-gray-100">From</label>
                </div>
                <div class="mt-2">
                    <label class="block text-sm font-normal text-gray-100">To</label>
                </div>
                <div class="mt-2">
                    <label class="block text-sm font-normal text-gray-100">Grade Alphabet</label>
                </div>
                <div class="mt-2">
                    <label class="block text-sm font-normal text-gray-100">Grade Comment</label>
                </div>
                <div class="mt-2">
                </div>
            </div>

            <template x-for="(item, index) in gradeFormatField" :key="index">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-6 p-4 border-b border-gray-300 items-center">
                    <div class="mt-1">
                        <label>
                            <input x-model="item.from" :name="`meta[${index}][from]`" type="number" class=" text-gray-100 rounded-md py-1 w-1/2 px-1 border border-grey-300">
                        </label>
                    </div>
                    <div class="mt-1">
                        <label>
                            <input x-model="item.to" :name="`meta[${index}][to]`" type="number" class="w-1/2 text-gray-100 rounded-md py-1 px-1 border border-grey-300">
                        </label>
                    </div>
                    <div class="mt-1">
                        <label>
                            <input x-model="item.grade" :name="`meta[${index}][grade]`" type="text" class="w-1/2 capitalize text-gray-100 rounded-md py-1 px-2 border border-grey-300">
                        </label>
                    </div>
                    <div class="mt-1">
                        <label>
                            <input x-model="item.comment" :name="`meta[${index}][comment]`" type="text" class="capitalize w-full text-gray-100 rounded-md py-1 px-2 border border-grey-300">
                        </label>
                    </div>
                    <div class="mt-1">
                        <p class="cursor-pointer" @click="removeGradeFormatField(index)">
                            /!/
                        </p>
                    </div>
                </div>
            </template>

            <div class="px-4 py-4 text-right">
                <button @click="addNewGradeFormatField()" type="button" class="bg-white text-grey-100 border border-grey-300 rounded-md py-2 px-2  md:w-1/5 text-sm">
                    Add new grade
                </button>
            </div>

            <div class="px-4 py-4">
                <button type="submit" class="bg-blue-100 text-white rounded-md py-3 px-2  md:w-1/3 text-sm">
                    Submit
                </button>
            </div>

        </form>
    </div>
</div>


<script>
    function createGradingFormat() {
        return{
            schoolClasses: {!! $schoolClasses !!},
            isClassDropdownOpen: false,
            selectedClasses: [],
            classDropdownLabel(){
                if (this.selectedClasses.length > 0) return this.selectedClasses.join(', ');
                else return "-- select class --";
            },
            onCheckedClass(item){
                return this.selectedClasses.indexOf(item) > -1;
            },
            onToggleClass(item, value, event){
                if (this.onCheckedClass(item)) {
                    let getIndex = (element) => element === item;
                    this.selectedClasses.splice( this.selectedClasses.findIndex(getIndex), 1);
                    document.getElementById('selectAllClasses').checked = false;
                }
                else {
                    this.selectedClasses.push(item)
                    this.schoolClasses.length === this.selectedClasses.length ?
                        document.getElementById('selectAllClasses').checked = true :
                        document.getElementById('selectAllClasses').checked = false;
                }
            },
            onToggleAll(event){
                let checked = event.checked;
                this.selectedClasses = [];
                let selectedClasses  = [];
                document.querySelectorAll('.classCheckbox').forEach(function (e) {
                    e.checked = checked;
                    if(e.checked){
                        selectedClasses.push(e.getAttribute('data-id'));
                    }
                });
                this.selectedClasses = selectedClasses;
                this.isClassDropdownOpen = false;
            },
            gradeFormatField: [],
            addNewGradeFormatField(){
                this.gradeFormatField.push({
                    from: '',
                    to: '',
                    grade: '',
                    comment: '',
                });
            },
            removeGradeFormatField(index){
                this.gradeFormatField.splice(index, 1);
            },
        }
    }

</script>
