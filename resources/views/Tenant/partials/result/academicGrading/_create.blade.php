<div class="md:px-8">
    <div>
        <div class="mt-2 text-xl text-gray-200">
            Add New Academic Grading Format
        </div>
        <a href="{{route('listGradeFormat')}}" class="flex items-center space-x-1 mt-2">
            <span class=" text-sm text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                </svg>
            </span>
            <span class="text-sm text-gray-300">
               Academic Grading Formats
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
        <div class="bg-white rounded-md " x-data="createGradingFormat()" x-init="init()">
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
                        <div class="border border-purple-100 absolute b-8 w-full bg-white" x-show.transition="isClassDropdownOpen" @click.away="isClassDropdownOpen = false">
                            <ul class="py-1 overflow-auto h-32 text-base leading-6
                           shadow-xs max-h-60 focus:outline-none sm:text-sm sm:leading-5 bg-white">
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

                <template x-for="(content, contentIndex) in numberOfReportObject" :key="contentIndex">
                    <div class="p-4">
                        <div class="p-4 w-2/5">
                            <div class="mt-2">
                                <h3 class="block capitalize text-sm font-normal text-blue-100">
                                    <span x-text="content.reportFormat.name"></span>
                                    grading format
                                </h3>
                                <input type="hidden" :name=`meta[${contentIndex}][nameOfReport]` :value="content.reportFormat.uuid">
                            </div>
                        </div>
                        <div>
                            <div class="sm:block">
                                <div class="max-w-6xl mx-auto  sm:px-6 ">
                                    <div class="flex flex-col mt-2">
                                        <div class="align-middle min-w-full overflow-x-auto  overflow-hidden ">
                                            <table class="min-w-full divide-y  divide-purple-100">
                                                <thead>
                                                <tr>
                                                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-100">
                                                        Score from
                                                    </th>
                                                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-100 text-sm ">
                                                        Score to
                                                    </th>
                                                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-100 text-sm">
                                                        Grade
                                                    </th>
                                                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-100">
                                                        Comment
                                                    </th>
                                                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-100">
                                                        Grade Color
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    <template x-for="(item, index) in content.gradeFormatField" :key="index">
                                                        <tr class="bg-white divide-y divide-purple-100">
                                                            <td class="max-w-0  px-6 py-4 text-center whitespace-nowrap text-xs text-gray-900">
                                                                <label>
                                                                    <input x-model="item.from" :name="`meta[${contentIndex}][gradingFormat][${index}][from]`" type="number" class="text-gray-200 font-normal rounded-sm border-purple-100 pl-2 py-1 w-24 focus:outline-none border">
                                                                </label>
                                                            </td>
                                                            <td class="max-w-0  px-6 py-4 text-left whitespace-nowrap text-xs text-gray-900">
                                                                <label>
                                                                    <input x-model="item.to" :name="`meta[${contentIndex}][gradingFormat][${index}][to]`" type="number" class="text-gray-200 font-normal rounded-sm border-purple-100 pl-2 py-1 w-24 focus:outline-none border">
                                                                </label>
                                                            </td>
                                                            <td class="max-w-0  px-6 py-4 text-center whitespace-nowrap text-xs text-gray-900">
                                                                <label>
                                                                    <input x-model="item.grade" :name="`meta[${contentIndex}][gradingFormat][${index}][grade]`" type="text" class="text-gray-200 capitalize font-normal rounded-sm border-purple-100 pl-2 py-1 w-24 focus:outline-none border">
                                                                </label>
                                                            </td>
                                                            <td class="max-w-0  px-6 py-4 text-center whitespace-nowrap text-xs text-gray-900">
                                                                <label>
                                                                    <input x-model="item.comment" :name="`meta[${contentIndex}][gradingFormat][${index}][comment]`" type="text" class="text-gray-200 capitalize font-normal rounded-sm border-purple-100 pl-2 py-1 w-24 focus:outline-none border">
                                                                </label>
                                                            </td>
                                                            <td class="max-w-0  px-6 py-4 text-center whitespace-nowrap text-xs text-gray-900">
                                                                <label>
                                                                    <input x-model="item.color" value="#020202" :name="`meta[${contentIndex}][gradingFormat][${index}][color]`" type="color" class="text-gray-200 font-normal rounded-sm border-purple-100 py-1 w-24 focus:outline-none border">
                                                                </label>
                                                            </td>
                                                            <td class="max-w-0  px-6 py-4 text-center whitespace-nowrap text-xs text-gray-900">
                                                                <p class="cursor-pointer" @click="removeGradeFormatField(contentIndex, index)">
                                                                    /!/
                                                                </p>
                                                            </td>
                                                        </tr>
                                                    </template>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="flex justify-end mt-4">
                                        <button @click="addNewGradeFormatField(contentIndex)" type="button" class="py-2 px-4 bg-blue-100 text-white text-xs rounded font-light ">
                                            Add new grade
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>

                <div class="px-4 py-4">
                    <button type="submit" class="bg-blue-100 text-white rounded-md py-3 px-2  md:w-1/3 text-sm">
                        Submit
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>


<script>
    function createGradingFormat() {
        return{
            numberOfReportObject: [],
            init(){
                let reportFormats = {!! $reportCardFormats !!};

                for(let i = 0; i < reportFormats.length; i++){
                    this.numberOfReportObject.push({
                        reportFormat: reportFormats[i],
                        gradeFormatField: [],
                    });
                }
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
                this.isClassDropdownOpen = ! checked;
            },
            gradeFormatField: [],
            addNewGradeFormatField(index){
                this.numberOfReportObject[index].gradeFormatField.push({
                    from: '',
                    to: '',
                    grade: '',
                    comment: '',
                    color: '#020202',
                });
            },
            removeGradeFormatField(reportIndex,index){
                this.numberOfReportObject[reportIndex].gradeFormatField.splice(index, 1);
            },
        }
    }

</script>
