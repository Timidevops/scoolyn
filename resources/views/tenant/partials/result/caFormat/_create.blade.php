<div class="lg:px-8">
    <div>
        <div class="mt-2 text-xl text-gray-200">
            Add New Continuous Assessment Format
        </div>
        <a href="{{route('listCAStructure')}}" class="flex items-center space-x-1 mt-1">
            <span class=" text-sm text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                </svg>
            </span>
            <span class="text-sm text-gray-300">
                Continuous assessments
            </span>
        </a>
    </div>

    <div class="h-screen py-10">
        @if($errors->any())
            <div class="mt-1 mb-5 bg-red-100 p-5">
                @foreach ($errors->all() as $error)
                    <p class="text-white">
                        {!! $error !!}
                    </p>
                @endforeach
            </div>
        @endif
        <div class="bg-white rounded-md " x-data="createCaFormat()" x-init="init()">
            <form action="{{route('storeCAStructure')}}" method="post">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4">
                    <div class="mt-2">
                        <label for="name" class="block text-sm font-normal text-gray-100">Name</label>
                        <input type="text" name="name" id="name" placeholder="optional" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100">
                    </div>
                    <div class="mt-2 relative">
                        <label for="schoolClass" class="block text-sm font-normal text-gray-100">Classes <span class="text-red-100">*</span></label>
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

                            <template x-for="(content, contentIndex) in numberOfReportObject" :key="contentIndex">
                                <div class="p-4">
                                    <div class="w-2/5">
                                        <div class="mt-2">
                                            <h3 class="text-blue-100 capitalize" x-text="content.name.name"></h3>
                                            <label for="numberOfCA" class="block text-sm font-normal text-gray-100">Number of assessment for <span x-text="content.name.name"></span><span class="text-red-100">*</span></label>
                                            <input id="numberOfCA" x-model="content.numberOfCA" type="number" @input="onchangeNumberOfCA(contentIndex, content.numberOfCA)" :id=`numberOfCA_${contentIndex}` class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100">
                                            <input type="hidden" :name=`reportFormat[${contentIndex}][nameOfReport]` :value="content.name.uuid">
                                        </div>
                                    </div>

                                    <div>
                                        <template x-for="(item, index) in content.numberOfCAObject" :key="index" class="meta">
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4">
                                                <div class="mt-2">
                                                    <label x-bind:for="`caName_${index}_${contentIndex}`" class="block text-sm font-normal text-gray-100">Name of continuous assessment <span class="text-red-100">*</span></label>
                                                    <input type="text"  id="caName_${index}_${contentIndex}" :name="`reportFormat[${contentIndex}][caFormat][${index}][name]]`" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100">
                                                </div>
                                                <div class="mt-2">
                                                    <label x-bind:for="`caScore_${index}_${contentIndex}`" class="block text-sm font-normal text-gray-100">Total mark attainable <span class="text-red-100">*</span></label>
                                                    <input type="number"  :name="`reportFormat[${contentIndex}][caFormat][${index}][score]`" @input="onchangeTotalMarkAttainable(event)" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100 score">
                                                </div>
                                            </div>
                                        </template>
                                    </div>

                                </div>
                            </template>

                <div class="p-4">
                    <p>Total Continuous assessment score: <span x-text="totalCAScore"></span>/100</p>
                    <input type="hidden" name="totalCAScore" x-model="totalCAScore">
                </div>

                <div class="px-4 py-4">
                    <button id="submitButton" disabled type="submit" class="bg-blue-100 text-white rounded-md py-3 px-2  md:w-1/5 text-sm">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function createCaFormat() {
            return {
                numberOfReportObject: [],
                init(){
                    let reportFormats = {!! $reportCardFormats !!};

                    for(let i = 0; i < reportFormats.length; i++){
                        this.numberOfReportObject.push({
                            name: reportFormats[i],
                            numberOfCA: 0,
                            numberOfCAObject: [],
                        });
                    }
                },
                totalCAScore: 0,
                disableButton: true,

                onchangeNumberOfCA(index, number){
                    if(number >=1){
                        this.numberOfReportObject[index].numberOfCAObject = [];
                        for(let i=1; i <= number; i++){
                            this.numberOfReportObject[index].numberOfCAObject.push([]);
                        }

                        return;
                    }
                    this.totalCAScore = 0;
                    return this.numberOfReportObject[index].numberOfCAObject = [];
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
                    let submitButton = document.getElementById('submitButton');
                    totalScore !== 100 ? submitButton.setAttribute('disabled', '')  :  submitButton.removeAttribute('disabled');
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

</div>
