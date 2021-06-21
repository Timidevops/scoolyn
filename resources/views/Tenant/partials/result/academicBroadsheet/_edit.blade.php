<div>
    <div class="mt-2 text-xl text-gray-200">
        <div class="flex ">
            Broadsheet:
            <div class="pl-2">
                <span>{{$classSubject->subject->subject_name}}</span>
                <span class="font-medium text-xs text-gray-200">
                    {{$classSubject->schoolClass->class_name}}
                    {{$classSubject->classSectionType ? "| {$classSubject->classSectionType->section_name}" : ''}}
                    {{$classSubject->classSectionCategoryType ? "| {$classSubject->classSectionCategoryType->category_name}" : ''}}
                </span>
            </div>
        </div>
    </div>
    <a href="{{route('listAcademicBroadsheet')}}"><span class="mt-2  text-sm text-gray-300">/!/ Broadsheets</span></a>
</div>

<div class="h-screen py-10" x-data="editBroadsheet()">
    <div class="bg-white rounded-md ">
        <form id="broadsheetForm" action="{{route('updateAcademicBroadsheet',$classSubjectId)}}" method="post">
            @csrf
            @method('PATCH')
            <div class="flex justify-end px-4 py-4">
                <button type="submit" class="border-blue-100 border text-blue-100 rounded-md py-2 px-4 mx-2 text-sm">
                    Save Broadsheet
                </button>
                <button type="submit" name="submit" class="bg-blue-100 text-white rounded-md py-2 px-4 mx-2 text-sm">
                    Submit Broadsheet
                </button>
            </div>
            <div class="flex flex-col mt-2">
                <div class="align-middle min-w-full overflow-x-auto  overflow-hidden ">
                    <table class="min-w-full divide-y  divide-purple-100">
                        <thead>
                        <tr>
                            <th class="px-6 py-3 w-1  text-left text-sm font-medium text-gray-500 uppercase">
                                SN
                            </th>
                            <th class="px-6 py-3  text-left  font-medium text-gray-500 text-sm ">
                                        <span class="flex items-center mx-1">
                                            Student
                                        </span>
                            </th>
                            <template x-for="(item, index) in caAssessmentStructure" :key="item">
                                <th class="px-6 py-3  text-center  font-medium text-gray-200 text-sm">
                                    <div>
                                        <span x-text="item.name"></span>
                                        <p class="text-gray-300">(<span x-text="item.score"></span>)</p>
                                    </div>
                                </th>
                            </template>
                            <th class="px-6 py-3  text-left  font-medium text-gray-200 text-sm ">
                                <div class="text-center mx-1">
                                    <span>Total</span>
                                    <p class="text-gray-300">(100)</p>
                                </div>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-purple-100">
                            <template x-for="(item, index) in academicBroadsheets" :key="item">
                                <tr>
                                    <td class="max-w-0  px-6 py-4 whitespace-nowrap text-xs text-gray-900">
                                        <div class="flex">
                                            <a href="#" class="group inline-flex space-x-2 truncate">
                                                <p class="text-gray-500 truncate" x-text="index+1">
                                                </p>
                                            </a>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-left whitespace-nowrap text-xs text-gray-200">
                                        <span class="text-gray-200 font-normal capitalize" x-text="item.studentName"></span>
                                    </td>
                                    <template x-for="(ca, caIndex) in getBroadsheet(item.broadsheet)" :key="ca">
                                        <td class="whitespace-nowrap text-xs text-gray-200">
                                            <div class="mt-2 text-center">
                                                <label>
                                                    <input type="number" x-bind:value="ca.score" x-bind:class="`totalScore_${index}`" @input="onchangeCAScore(index)" x-bind:name="`broadsheet[${item.studentId}][${ca.name}]`" class="w-2/5 text-center text-gray-100 rounded-md py-2 px-2 border border-purple-100 ">
                                                </label>
                                            </div>
                                        </td>
                                    </template>
                                    <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-200">
                                        <p class="text-gray-200 text-center font-normal" x-bind:id="`totalScore_${index}`">
                                            <span x-text="getInitialTotal(index)"></span>
                                        </p>
                                        <input type="hidden" x-bind:value="getInitialTotal(index)" x-bind:id="`totalScoreValue_${index}`" x-bind:name="`broadsheet[${item.studentId}][total]`" />
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>


<script>
    function editBroadsheet() {
        return{
            caAssessmentStructure:{!! $caAssessmentStructure !!},
            academicBroadsheets: {!! $academicBroadsheets !!},
            getBroadsheet(meta){
                let broadsheet = [];

                this.caAssessmentStructure.map((item, index)=>{
                    broadsheet.push({
                        name: item.name,
                        score: meta[item.name]
                    });
                })

                return broadsheet;
            },
            getInitialTotal(index){
                return this.academicBroadsheets[index].broadsheet['total'];
            },
            onchangeCAScore(id){
                let scoreIdText = `totalScore_${id}`;
                let scoreIdValue = `totalScoreValue_${id}`;
                let totalScore = 0;

                document.querySelectorAll(`.${scoreIdText}`).forEach((value) => {
                    let score = parseInt(value.value);

                    if(! score ){
                        score = 0;
                    }

                    totalScore = totalScore + score;
                });


                document.getElementById(scoreIdText).innerText = totalScore;
                document.getElementById(scoreIdValue).value = totalScore;
            },
        }
    }
</script>
