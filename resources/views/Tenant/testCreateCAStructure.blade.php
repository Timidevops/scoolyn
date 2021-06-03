@extends('Tenant.layouts.main')
@section('headerMeta')
@endsection
@section('topNav')
@endsection
@section('content')
    <div class="h-screen flex overflow-hidden bg-gray-100">
        @include('Tenant.partials._sidebar')
        <div class="flex-1 overflow-auto bg-purple-100 focus:outline-none px-4 py-8" tabindex="0" x-cloak
             id="tab_wrapper">
            <div class="h-screen py-10">
                <div class="bg-white rounded-md ">
                    <form action="{{route('storeCAStructure')}}" method="post" x-data="test()">
                        @csrf
                        <div class="p-4 w-2/5">
                            <div class="mt-2">
                                <label for="First name" class="block text-sm font-normal text-gray-100">Name</label>
                                <input type="text" name="name" id="name" placeholder="optional" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100"></div>
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
                        <button type="submit" href=""
                                class="bg-blue-100 text-white rounded-md py-3 px-2  md:w-1/5 text-sm">
                            Save
                        </button>
                    </div>
                    </form>

                </div>
            </div>
            <script>
                function test() {
                    return {
                        numberOfCA: 0,
                        numberOfCAObject: [],
                        student: [
                            {
                                id: '1',
                                name: 'john doe'
                            },
                            {
                                id: '2',
                                name: 'john lee'
                            }
                        ],
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
                        }
                    }
                }
            </script>

        </div>
        @include('Tenant.partials._notification')
    </div>
@endsection
