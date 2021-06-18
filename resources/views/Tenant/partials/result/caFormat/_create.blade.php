<div>
    <div class="mt-2 text-xl text-gray-200">
        Add New Continuous Assessment Format
    </div>
    <a href="{{route('listCAStructure')}}">
        <span class="mt-2 text-sm text-gray-300">
            /!/ C.A Formats
        </span>
    </a>
</div>

<div class="h-screen py-10">
    <div class="bg-white rounded-md " x-data="createCaFormat()">
        <form action="{{route('storeCAStructure')}}" method="post">
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
                            <span class="px-2 mr-auto" x-text="classDropdownLabel()"></span>
                        </button>
                    </div>
                    <div class="border border-purple-100 absolute w-full bg-white" x-show.transition="isClassDropdownOpen" @click.away="isClassDropdownOpen = false">
                        <ul class="py-1 overflow-auto h-32 text-base leading-6
                       shadow-xs max-h-60 focus:outline-none sm:text-sm sm:leading-5">
                            <template x-for="item in schoolClasses">
                                <li class="relative py-2 pl-3  text-gray-200 cursor-default select-none pr-9">
                                    <label class="flex items-center">
                                        <input name="schoolClass[]"
                                               type="checkbox"
                                               x-bind:checked="onCheckedClass(item.class_name)"
                                               x-on:change="onToggleClass(item.class_name, item.uuid, event.target)"
                                        >
                                        <span class="px-1"></span>
                                        <span x-text="item.class_name"></span>
                                    </label>
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="p-4 w-2/5">
                <div class="mt-2">
                    <label for="numberOfCA" class="block text-sm font-normal text-gray-100">Number of continuous assessment</label>
                    <input x-model="numberOfCA" @input="onchangeNumberOfCA()" type="text" name="numberOfCA" id="numberOfCA" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100"></div>
            </div>

            <template x-for="(item, index) in numberOfCAObject" :key="item" class="meta">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4">
                    <div class="mt-2">
                        <label x-bind:for="`caName_${index}`" class="block text-sm font-normal text-gray-100">Name of continuous assessment</label>
                        <input type="text" name="caName[]" x-bind:id="`caName_${index}`" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100">
                    </div>
                    <div class="mt-2">
                        <label x-bind:for="`caScore_${index}`" class="block text-sm font-normal text-gray-100">Total mark attainable</label>
                        <input type="text" name="caScore[]" x-bind:id="`caScore_${index}`" @input="onchangeTotalMarkAttainable()" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100 score">
                    </div>
                </div>
            </template>

            <div class="p-4">
                <p>Total Continuous assessment score: <span x-text="totalCAScore"></span>/100</p>
            </div>

            <div class="px-4 py-4">
                <button type="submit" class="bg-blue-100 text-white rounded-md py-3 px-2  md:w-1/5 text-sm">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function createCaFormat() {
        return {
            numberOfCA: 0,
            numberOfCAObject: [],
            totalCAScore: 0,
            onchangeNumberOfCA(){
                if(this.numberOfCA >=1){
                    this.numberOfCAObject = [];
                    for(let i=1; i <= this.numberOfCA; i++){
                        this.numberOfCAObject.push([])
                    }
                    return;
                }
                this.totalCAScore = 0;
                return this.numberOfCAObject = [];
            },
            onchangeTotalMarkAttainable(){
                this.calculateTotalCAScore();
            },
            calculateTotalCAScore(){
                let totalScore = 0;
                document.querySelectorAll('.score').forEach((value) => {
                    let score = parseInt(value.value);
                    if(! score ){
                        score = 0;
                    }
                    totalScore = totalScore + score;
                });
                this.totalCAScore = totalScore;
            },
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
                }
                else {
                    this.selectedClasses.push(item)
                    event.value = value
                }
            }
        }
    }
</script>
