<form x-data="editBroadsheet()" action="{{route('updateAcademicBroadsheet',$classSubjectId)}}" method="post">
    @csrf
    @method('PATCH')
    <input type="hidden" name="classArm" value="{{$classArm}}">
    <div class="flex justify-between items-center px-4 py-4">
        <div>
            <h3>
                Assessment for {{\App\Models\Tenant\Setting::getCurrentCardBreakdownFormat(true)}}
            </h3>
        </div>
        <div>
            <button>
                @if($broadsheetStatus == \App\Models\Tenant\AcademicBroadSheet::NOT_APPROVED_STATUS)
                    <div>
                        <p class="text-red-100">Disapproved</p>
                    </div>
                @endif
            </button>
            <button type="submit" class="border-blue-100 border text-blue-100 rounded-md py-2 px-4 mx-2 text-sm">
                Save Broadsheet
            </button>
            <button type="submit" name="submit" class="bg-blue-100 text-white rounded-md py-2 px-4 mx-2 text-sm">
                Submit Broadsheet
            </button>
        </div>
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
                    @if( $student['previousReportCard'] != null )
                        <th class="px-6 py-3  text-center  font-medium text-gray-200 text-sm">
                            <div class="flex">
                                @foreach($student['previousReportCard'] as $previousReportCard)
                                    <div class="flex space-x-5">
                                        @foreach($previousReportCard['caAssessmentStructureFormat'] as $caAssessmentStructureFormat)
                                            <div>
                                                <p class="text-xs uppercase">{{$caAssessmentStructureFormat['name']}}</p>
                                                <span class="text-gray-300">({{$caAssessmentStructureFormat['score']}}%)</span>
                                                <input type="hidden" class="previousReportCardScore_{{$index}}" value="{{$caAssessmentStructureFormat['score']}}">
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </th>
                    @endif
                    <template x-for="(item, index) in caAssessmentStructure.caFormat" :key="item">
                        <th class="px-6 py-3  text-center  font-medium text-gray-200 text-sm">
                            <div>
                                <span class="uppercase text-xs" x-text="item.name"></span>
                                <p class="text-gray-300">(<span x-text="item.score"></span>%)</p>
                                <input type="hidden" class="assessmentScore" :value="item.score">
                            </div>
                        </th>
                    </template>
                    <th class="px-6 py-3  text-left  font-medium text-gray-200 text-sm ">
                        <div class="text-center mx-1">
                            <span>Total</span>
                            <p class="text-gray-300">(<span x-text="getTotalAssessment()"></span>%)</p>
                        </div>
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-purple-100">
                <template x-for="(item, index) in {{$academicBroadsheets}}" :key="item">
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
                        @if( $student['previousReportCard'] != null )
                            <td class="whitespace-nowrap px-6 py-4  text-xs text-gray-200">
                                @foreach($student['previousReportCard'] as $previousReportCard)
                                    <div class="flex">
                                        @foreach($student['previousReportCard'] as $previousReportCard)
                                            <div class="flex space-x-5">
                                                <template x-for="(previousReportContent, previousReportIndex) in getPreviousReportData({{$previousReportCard['caAssessmentStructureFormat']}}, {{$previousReportCard['academicBroadsheets']}}, item.studentId) ">
                                                    <div class="w-2/5">
                                                        <p class="text-gray-500 truncate text-center" :class="`previousReportContentScore_${index}_{{$index}}`" x-text="previousReportContent.score"></p>
                                                    </div>
                                                </template>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </td>
                        @endif
                        <template x-for="(ca, caIndex) in getBroadsheet(item.broadsheet)" :key="ca">
                            <td class="whitespace-nowrap text-xs text-gray-200">
                                <div class="mt-2 text-center">
                                    <label>
                                        <input type="number" x-bind:value="ca.score" x-bind:class="`totalScore_${index}_{{$index}}`" @input="onchangeCAScore(index, '{{$index}}', ca, event)" x-bind:name="`broadsheet[${item.studentId}][${ca.name}]`" class="w-2/5 text-center text-gray-100 rounded-md py-2 px-2 border border-purple-100 ">
                                    </label>
                                </div>
                            </td>
                        </template>
                        <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-200">
                            <p class="text-gray-200 text-center font-normal" x-bind:id="`totalScore_${index}_{{$index}}`">
                                <span x-text="item.broadsheet.total"></span>
                            </p>
                            <input type="hidden" :value="getTotalScoreFromPrevious(index,'{{$index}}', item.broadsheet.total)" x-bind:id="`totalScoreValue_${index}_{{$index}}`" />
                        </td>
                    </tr>
                </template>
                </tbody>
            </table>
        </div>
    </div>
</form>

<script>
    function editBroadsheet() {
        return{
            caAssessmentStructure:{!! $caAssessmentStructure !!},
            academicBroadsheets: {!! $academicBroadsheets !!},
            getBroadsheet(meta){
                let broadsheet = [];

                this.caAssessmentStructure.caFormat.map((item, index)=>{
                    broadsheet.push({
                        name: item.name,
                        score: meta[item.name],
                        caScore: item.score,
                    });
                })

                return broadsheet;
            },
            onchangeCAScore(id, classArm, ca, value){
                let scoreIdText = `totalScore_${id}_${classArm}`;
                let scoreIdValue = `totalScoreValue_${id}_${classArm}`;
                let totalScore = 0;

                if( parseFloat(value.target.value) > parseFloat(ca.caScore) ){
                    value.target.classList.remove('border-purple-100')
                    value.target.classList.add('border-red-100')
                    value.target.value = 0;

                }else{
                    value.target.classList.remove('border-red-100')
                    value.target.classList.add('border-purple-100')
                }

                let previousReportContentScore = `previousReportContentScore_${id}_${classArm}`;

                document.querySelectorAll(`.${previousReportContentScore}`).forEach((value => {
                    totalScore += Number(value.innerText);
                }));

                document.querySelectorAll(`.${scoreIdText}`).forEach((value) => {
                    let score = parseFloat(value.value);

                    if(! score ){
                        score = 0;
                    }

                    totalScore = totalScore + score;
                });


                document.getElementById(scoreIdText).innerText = totalScore > 100 ? '0' : totalScore;
                document.getElementById(scoreIdValue).value = totalScore > 100 ? '0' : totalScore;
            },

            getTotalAssessment(){
                let total = 0;
                document.querySelectorAll(`.assessmentScore`).forEach(function (e) {
                    total += Number(e.value);
                })
                return total;
            },

            getPreviousReportData(caAssessmentStructure, data, studentId){

                let student = data.filter(e => e.studentId === studentId);

                let studentReport = [];

                caAssessmentStructure.map((item)=>{
                    studentReport.push({
                        name: item.name,
                        score: (student[0]['broadsheet'])[item.name]
                    });
                })

                return studentReport.length > 0 ? studentReport : [];
            },

            getTotalScoreFromPrevious(id, index, current){

                let scoreIdText = `totalScore_${id}_${index}`;
                let totalScore = 0;

                let previousReportContentScore = `previousReportContentScore_${id}_${index}`;

                document.querySelectorAll(`.${previousReportContentScore}`).forEach((value => {
                    totalScore += parseFloat(value.innerHTML);
                }));

                document.getElementById(scoreIdText).innerText = totalScore > 100 ? '0' : (parseFloat(totalScore) + parseFloat(current));
            },
        }
    }
</script>
