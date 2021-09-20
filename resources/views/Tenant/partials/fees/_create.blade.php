<div>
    <div class="mt-2 text-xl text-gray-200">
        Add New Fee
    </div>
    <a href="{{route('listFeeStructure')}}">
        <span class=" text-sm text-gray-300 absolute">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
          </svg>
        </span>
        <span class="px-7 text-sm text-gray-300"> Back to fees</span></a>
</div>

<div class="h-screen py-10">
    <div class="bg-white rounded-md " x-data="createFeeStructure()">
        <form action="{{route('storeFeeStructure')}}" method="post">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-4">
                <div class="mt-2">
                    <label for="feesName" class="block text-sm font-normal text-gray-100">Name</label>
                    <input type="text" name="feesName" id="feesName" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100" required>
                </div>
                <div class="mt-2">
                    <label for="feesAmount" class="block text-sm font-normal text-gray-100">Amount</label>
                    <input type="hidden" name="feesAmount" id="feesAmount">
                    <input type="text" name="feesAmountFormatted" id="feesAmountFormatted" class="w-full text-gray-100 py-2 px-2" readonly>
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
            <div class="p-4">
                Fees break down
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 p-4">
                <div class="mt-2">
                    <label for="name" class="block text-sm font-normal text-gray-100">Name</label>
                    <input type="text" name="fee[0][name]" id="name" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100" required>
                </div>
                <div class="mt-2">
                    <label for="amount" class="block text-sm font-normal text-gray-100">Amount</label>
                    <input type="number" name="fee[0][amount]" id="amount" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100 feeItem" onkeyup="calculateTotalFees()" required>
                </div>
                <div class="mt-2">
                    <label for="description" class="block text-sm font-normal text-gray-100">Description</label>
                    <input type="text" name="fee[0][description]" placeholder="optional description" id="description" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100" >
                </div>
            </div>
            <template x-for="(item, index) in feeStructureField" :key="index">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 p-4 items-center">
                    <div class="mt-2">
                        <label for="name" class="block text-sm font-normal text-gray-100">Name</label>
                        <input type="text" :name="`fee[${index}_][name]`" x-model="item.name" :id="`name_${index}`" id="name" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100" required>
                    </div>
                    <div class="mt-2">
                        <label for="amount" class="block text-sm font-normal text-gray-100">Amount</label>
                        <input type="number" :name="`fee[${index}_][amount]`" x-model="item.amount" :id="`amount_${index}`" id="amount" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100 feeItem" required onkeyup="calculateTotalFees()">
                    </div>
                    <div class="mt-2">
                        <label for="description" class="block text-sm font-normal text-gray-100">Description</label>
                        <input type="text" :name="`fee[${index}_][description]`" x-model="item.description" placeholder="optional description" :id="`description_${index}`" id="description" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100" >
                    </div>
                    <div class="mt-2">
                        <p class="cursor-pointer" @click="removeFeeStructureField(index)">
                            /!/
                        </p>
                    </div>
                </div>
            </template>
            <div class="px-4 py-4 text-right">
                <button @click="addNewFeeStructureField()" type="button" class="border-blue-100 border text-grey-100 border border-grey-300 rounded-md py-2 px-2  md:w-1/5 text-sm">
                    Add new fee item
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
    function createFeeStructure() {
        return{
            feeStructureField: [],
            addNewFeeStructureField(){
                this.feeStructureField.push({
                    name: '',
                    amount: '',
                    description: '',
                });
            },
            removeFeeStructureField(index){
                this.feeStructureField.splice(index, 1);
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
