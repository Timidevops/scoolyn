<div>
    <div class="mt-2 text-xl text-gray-200">
        <div class="flex ">
            <div>
                Academic Report Sheet:
            </div>
            <div class="pl-2">
                <span class="capitalize">{{$academicResult->student->first_name}}</span>
                <span class="capitalize">{{$academicResult->student->last_name}}</span>
            </div>
        </div>
    </div>
    <a href="{{route('listReportSheet', $academicResult->classArm->uuid)}}"><span class="mt-2  text-sm text-gray-300">/!/ Academic report sheets</span></a>
</div>

<div class="bg-white rounded-md py-6 px-2">

    <div class="pl-2">
        <span class="capitalize">{{$academicResult->classArm->schoolClass->class_name}}</span>
        <span class="font-medium text-xs text-gray-200 capitalize">
                    {{$academicResult->classArm->classSection ? "| {$academicResult->classArm->classSection->section_name}" : ''}}
            {{$academicResult->classArm->classSectionCategory ? "| {$academicResult->classArm->classSectionCategory->category_name}" : ''}}
                </span>
    </div>

    <div class="pl-2 py-3">
        <span class="uppercase">{{$academicResult->academicTerm->term_name}} &nbsp;term</span>
        &nbsp;
        <span class="capitalize">{{str_replace('-','/',$academicResult->academicSession->session_name)}}</span>
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
                    <span class=" text-sm">{{strOrdinal($academicResult->class_position)}}</span>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="capitalize text-sm">total mark obtained:</span>
                </td>
                <td>
                    <span class="capitalize text-sm">{{$academicResult->total_mark_obtained}}</span>
                </td>
            </tr>
        </table>
    </div>

    <div x-data="academicReport()" class="pl-2 py-3">
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
                                    {{$subject['total']}}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center text-xs whitespace-nowrap text-gray-200">
                                <span class="text-gray-500 truncate capitalize">
                                    {{strOrdinal($subject['subjectMetric']['SubjectPosition'])}}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center text-xs whitespace-nowrap text-gray-200">
                                <span class="text-gray-500 truncate capitalize">
                                    {{$subject['subjectMetric']['classAverage']}}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center text-xs whitespace-nowrap text-gray-200">
                                <span class="text-gray-500 truncate capitalize" x-text="getGradeName('{{$subject['total']}}')"></span>
                            </td>
                            <td class="px-6 py-4 text-center text-xs whitespace-nowrap text-gray-200">
                                <span class="text-gray-500 truncate capitalize">
                                    <span class="text-gray-500 truncate capitalize" x-text="getGradeName('{{$subject['total']}}', 'comment')"></span>
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
    function academicReport() {
        return{
            caAssessmentStructure: {!! collect($academicResult->ca_format) !!},
            gradeFormats: {!! collect($academicResult->grading_format) !!},
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

