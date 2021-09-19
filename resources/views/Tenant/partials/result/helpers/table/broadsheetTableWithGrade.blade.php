
<div x-data="broadsheets()" class="flex flex-col mt-2">
    <div class="align-middle min-w-full overflow-x-auto  overflow-hidden ">
        <table class="min-w-full divide-y  divide-purple-100">
            <thead>
            <tr>
                <th class="px-6 py-3 w-1  text-left text-sm font-medium text-gray-500 uppercase">
                    SN
                </th>
                <th class="px-6 py-3  text-left  font-medium text-gray-500 text-sm">
                                <span class="flex items-center mx-1">
                                    Student
                                </span>
                </th>
                @if( $student['previousReportCard'] != null )
                    <th class="px-6 py-3  text-center  font-medium text-gray-200 text-sm">
                        <div class="flex">
                            @foreach($student['previousReportCard'] as $previousReportCard)
                                <div class="flex space-x-5">
                                    @foreach($previousReportCard['caAssessmentStructureFormat'] as $previousCaAssessmentStructureFormat)
                                        <div>
                                            <p class="text-xs uppercase">{{$previousCaAssessmentStructureFormat['name']}}</p>
                                            <span class="text-gray-300">({{$previousCaAssessmentStructureFormat['score']}}%)</span>
                                            <input type="hidden" class="previousReportCardScore_{{$index ?? ''}}" value="{{$previousCaAssessmentStructureFormat['score']}}">
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </th>
                @endif
                <template x-for="(item, index) in caAssessmentStructure" :key="item">
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
                        <p class="text-gray-300">(<span x-text="getTotalAssessment('{{$index ?? ''}}')"></span>%)</p>
                    </div>
                </th>
                <th class="px-6 py-3  text-left  font-medium text-gray-500 text-sm">
                    Grade
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
                                                    <p class="text-gray-500 truncate text-center" :class="`previousReportContentScore_${index}_{{$index ?? ''}}`" x-text="previousReportContent.score"></p>
                                                </div>
                                            </template>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </td>
                    @endif
                    <template x-for="(ca, caIndex) in getBroadsheet({{$caAssessmentStructureFormat}}, item.broadsheet)" :key="ca">
                        <td class="whitespace-nowrap text-xs text-gray-200 text-center">
                            <span x-text="ca.score"></span>
                        </td>
                    </template>
                    <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-200">
                        <p class="text-gray-200 text-center font-normal" x-bind:id="`totalScore_${index}_{{$index ?? ''}}`">
                            <span x-text="item.broadsheet.total"></span>
                        </p>
                        <input type="hidden" :value="getTotalScoreFromPrevious(index,'{{$index ?? ''}}', item.broadsheet.total)">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-200">
                        <p class="text-gray-200 text-center font-normal" x-bind:id="`totalScore_${index}_{{$index ?? ''}}`">
                            <span class="capitalize" x-text="getGradeFormat(item.broadsheet.total, {{$gradeFormats}})"></span>
                        </p>
                    </td>
                </tr>
            </template>
            </tbody>
        </table>
    </div>
</div>

<script>
    function broadsheets() {
        return{
            caAssessmentStructure: {!! $caAssessmentStructureFormat !!},
            gradeFormats: {!! $gradeFormats !!},
            academicBroadsheets: {!! $academicBroadsheets !!},
            getBroadsheet(caAssessmentStructure, meta){
                let broadsheet = [];

                caAssessmentStructure.map((item)=>{
                    broadsheet.push({
                        name: item.name,
                        score: meta[item.name]
                    });
                })

                return broadsheet;
            },
            getGradeFormat(score, gradeFormats){

                 let format = gradeFormats.filter(format => score >= parseInt(format.from) && score <= parseInt(format.to) );

                 return format[0].grade;
            },

            getTotalAssessment(index){
                let total = 0;

                document.querySelectorAll(`.previousReportCardScore_${index}`).forEach(function (e) {
                    total += Number(e.value);
                })

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
