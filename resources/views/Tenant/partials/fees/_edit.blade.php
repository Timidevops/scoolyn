<div>
    <div class="mt-2 text-xl text-gray-200">
        Edit {{$schoolFees->name}}
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
                    <input type="text" name="feesName" id="feesName" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100" required value="{{$schoolFees->name}}">
                </div>
                <div class="mt-2">
                    <label for="feesAmount" class="block text-sm font-normal text-gray-100">Amount</label>
                    <input type="hidden" name="feesAmount" id="feesAmount" value="{{$schoolFees->amount}}">
                    <input type="text" name="feesAmountFormatted" id="feesAmountFormatted" class="w-full text-gray-100 py-2 px-2" readonly value="{{ \App\Models\Support\Support::moneyFormat($schoolFees->amount)}}">
                </div>
            </div>
            <div class="p-4">
                Fees break down
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 p-4">
                @foreach($schoolFees->feesItems as $key => $feeItem)
                    <div class="mt-2">
                        <label for="name" class="block text-sm font-normal text-gray-100">Name</label>
                        <input type="text" name="fee[$key][name]" id="name" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100" required value="{{$feeItem['name']}}">
                    </div>
                    <div class="mt-2">
                        <label for="amount" class="block text-sm font-normal text-gray-100">Amount</label>
                        <input type="number" name="fee[0][amount]" id="amount" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100 feeItem" onkeyup="calculateTotalFees()" required value="{{$feeItem['amount']}}">
                    </div>
                    <div class="mt-2">
                        <label for="description" class="block text-sm font-normal text-gray-100">Description</label>
                        <input type="text" name="fee[$key][description]" id="name" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100" required value="{{$feeItem['description']}}">
                    </div>
                    <div class="mt-2">
                        <p class="cursor-pointer" @click="removeFeeStructureField(index)">
                            /!/
                        </p>
                    </div>
                @endforeach
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
        }
    }
</script>
