<div>
    <div class="mt-2 text-xl text-gray-200">
        <div class="flex ">
            <div>
                Report Card:
            </div>
            <div class="pl-2">
                <span class="capitalize">{{$result->student->first_name}}</span>
                <span class="capitalize">{{$result->student->last_name}}</span>
            </div>
        </div>
    </div>
    <a href="{{route('listWardResult')}}" class="flex items-center space-x-1 mt-2">
        <span class=" text-sm text-gray-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
            </svg>
        </span>
        <span class="text-sm text-gray-300">Results</span>
    </a>
</div>


<div class="bg-white rounded-md py-6 px-2 mt-5">

    <div class="pl-2">
        <span class="capitalize">{{$result->classArm->schoolClass->class_name}}</span>
        <span class="font-medium text-xs text-gray-200 capitalize">
                    {{$result->classArm->classSection ? "| {$result->classArm->classSection->section_name}" : ''}}
            {{$result->classArm->classSectionCategory ? "| {$result->classArm->classSectionCategory->category_name}" : ''}}
                </span>
    </div>

    <div class="pl-2 py-3">
        <span class="uppercase">{{$result->academicSession->getTerm->name}} &nbsp;term</span>
        &nbsp;
        <span class="capitalize">{{str_replace('-','/',$result->academicSession->session_name)}}</span>
        &nbsp;
        <span class="uppercase">Academic Session</span>
    </div>

    <div class="pl-2 py-3">
        <table>
            <tr>
                <td>
                    <span class="capitalize text-sm">position:</span>
                </td>
                <td>
                    <span class=" text-sm">{{strOrdinal($result->class_position)}}</span>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="capitalize text-sm">total mark obtained:</span>
                </td>
                <td>
                    <span class="capitalize text-sm">{{$result->total_mark_obtained}}</span>
                </td>
            </tr>
        </table>
        <div class="py-5">
            <a target="_blank" href="{{route('printWardResult',[$result->uuid, $result->student_id])}}">
                <button type="button" class="bg-blue-100 text-white w-1/6 rounded-md py-3 px-3  text-sm" >
                    Print
                </button>
            </a>
        </div>
    </div>

    <div x-data="reportCard()" class="pl-2 py-3">
        <div class="align-middle min-w-full overflow-x-auto  overflow-hidden ">
            <table class="min-w-full divide-y  divide-purple-100">
                <thead>
                <tr>
                    <th class="px-6 py-3 w-1  text-left text-sm font-medium text-gray-500 uppercase">
                        SN
                    </th>
                    <th class="px-6 py-3 w-64  text-left  font-medium text-gray-500 text-sm ">
                        <p class="flex items-center mx-1">
                            Subjects
                            <span>
                                <img src="{{asset('images/filter_alt_black_24dp.svg')}}" alt="" class="w-4">
                             </span>
                        </p>
                    </th>
                    <template x-for="(item, index) in caAssessmentStructure" :key="item">
                        <th class="px-6 py-3  text-center  font-medium text-gray-200 text-sm">
                            <div>
                                <span x-text="item.name"></span>
                                <p class="text-gray-300">(<span x-text="item.score"></span>)</p>
                            </div>
                        </th>
                    </template>
                    <th class="px-6 py-3  text-center  font-medium text-gray-200 text-sm">
                        <div>
                            <span>Total</span>
                            <p class="text-gray-300">(<span>100</span>%)</p>
                        </div>
                    </th>
                    <th class="px-6 py-3  text-center  font-medium text-gray-200 text-sm">
                        <div>
                            <span>Subject Pos.</span>
                        </div>
                    </th>
                    <th class="px-6 py-3  text-center  font-medium text-gray-200 text-sm">
                        <div>
                            <span>Class Avg.</span>
                            <p class="text-gray-300">(<span>100</span>%)</p>
                        </div>
                    </th>
                    <th class="px-6 py-3  text-center  font-medium text-gray-200 text-sm">
                        <div>
                            <span>Grade</span>
                        </div>
                    </th>
                    <th class="px-6 py-3  text-center  font-medium text-gray-200 text-sm">
                        <div>
                            <span>Grade Remark</span>
                        </div>
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-purple-100">
                @foreach($subjects as $key => $subject)
                    <tr class="bg-white">
                        <td class="max-w-0  px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <div class="flex">
                                <p class="group inline-flex space-x-2 truncate">
                                        <span class="text-gray-500 truncate">
                                            {{$key + 1}}
                                        </span>
                                </p>
                            </div>
                        </td>
                        <td class="max-w-0 text-sm px-6 py-4 whitespace-nowrap text-gray-900">
                            <div class="flex">
                                <p class="group inline-flex space-x-2 truncate">
                                        <span class="text-gray-500 truncate capitalize">
                                            {{$subject['subjectName']}}
                                        </span>
                                </p>
                            </div>
                        </td>
                        <template x-for="item in getScores('{{$subject}}') ">
                            <td class="px-6 py-4 text-center text-xs whitespace-nowrap text-gray-200">
                                <span class="text-gray-500 truncate capitalize" x-text="item.score"></span>
                            </td>
                        </template>
                        <td class="px-6 py-4 text-center text-xs whitespace-nowrap text-gray-200">
                                <span class="text-gray-500 truncate capitalize">
                                    {{$subject['subjectMetric']['total'] ?? $subject['overallTermTotalAvg']}}
                                </span>
                        </td>
                        <td class="px-6 py-4 text-center text-xs whitespace-nowrap text-gray-200">
                                <span class="text-gray-500 truncate capitalize">
                                    {{strOrdinal($subject['subjectMetric']['subjectPosition'])}}
                                </span>
                        </td>
                        <td class="px-6 py-4 text-center text-xs whitespace-nowrap text-gray-200">
                                <span class="text-gray-500 truncate capitalize">
                                    {{$subject['subjectMetric']['classAverage']}}
                                </span>
                        </td>
                        <td class="px-6 py-4 text-center text-xs whitespace-nowrap text-gray-200">
                            <span class="text-gray-500 truncate capitalize" x-text="getGradeName('{{$subject['subjectMetric']['total'] ?? $subject['overallTermTotalAvg']}}')"></span>
                        </td>
                        <td class="px-6 py-4 text-center text-xs whitespace-nowrap text-gray-200">
                                <span class="text-gray-500 truncate capitalize">
                                    <span class="text-gray-500 truncate capitalize" x-text="getGradeName('{{$subject['subjectMetric']['total'] ?? $subject['overallTermTotalAvg']}}', 'comment')"></span>
                                </span>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



<script>
    function reportCard() {
        return{
            caAssessmentStructure: {!! collect($result->ca_format) !!},
            gradeFormats: {!! collect($result->grading_format) !!},
            getScores(scoreSheet){
                let scoreSheets = JSON.parse(scoreSheet);

                let subjects = [];

                this.caAssessmentStructure.map(function (item) {
                    subjects.push({
                        name: item.name,
                        'score': scoreSheets[item.name],
                    });
                });

                return subjects;
            },
            getGradeName(score, grade = 'name'){

                let format = this.gradeFormats.filter(format => score >= parseInt(format.from) && score <= parseInt(format.to) );

                return grade === 'name' ? format[0].grade : format[0].comment;
            }
        }
    }
</script>
