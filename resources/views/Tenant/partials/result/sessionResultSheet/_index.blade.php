<div class="lg:px-8">
    <div>
        <div class="mt-2 text-xl text-gray-200">
            <div class="flex ">
                <div>
                    Session Report Sheet:
                </div>
                <div class="pl-2">
                    <span class="capitalize">{{$student->first_name}}</span>
                    <span class="capitalize">{{$student->last_name}}</span>
                </div>
            </div>
        </div>
        <a href="{{route('singleReportSheet', [$classArm->uuid, $student->uuid])}}"><span class="mt-2  text-sm text-gray-300">/!/ Academic report sheet</span></a>
    </div>
    <div class="bg-white rounded-md py-6 px-2 mt-6">

        <div class="pl-2 py-3 flex ">
            <div>
                <a target="_blank" href="{{route('authPrintResult',[$classArm->uuid, $sessionResult->uuid, $student->uuid])}}?session=print">
                    <button type="button" class="bg-blue-100 text-white rounded-md py-3 mx-2 px-5 text-sm flex items-center">
                        Print session result
                    </button>
                </a>
            </div>
        </div>

        <div class="flex items-center flex-col my-5">

            <div class="pl-2">
                <span class="uppercase">{{$student->first_name}}</span>
                <span class="capitalize">{{$student->other_name}}</span>
                <span class="capitalize">{{$student->last_name}}</span>
            </div>

            <div class="pl-2">
                <span class="capitalize">{{$classArm->schoolClass->class_name}}</span>
                <span class="font-medium text-xs text-gray-200 capitalize">
                    {{$classArm->classSection ? "| {$classArm->classSection->section_name}" : ''}}
                    {{$classArm->classSectionCategory ? "| {$classArm->classSectionCategory->category_name}" : ''}}
                </span>
            </div>

            <div class="pl-2 py-3">
                <h4 class="uppercase text-blue-100 font-bold">
                    {{$academicSession->session_name}} academic session
                </h4>
            </div>

            <div class="pl-2 py-3">
                <table>
                    <tr>
                        <td>
                            <span class="capitalize text-sm">position:</span>
                        </td>
                        <td>
                            <span class=" text-sm">{{strOrdinal($sessionResult->class_position)}}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="capitalize text-sm">total mark obtained:</span>
                        </td>
                        <td>
                            <span class="capitalize text-sm">{{$sessionResult->total_mark_obtained}}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="capitalize text-sm">total mark attainable:</span>
                        </td>
                        <td>
                            <span class="capitalize text-sm">{{$sessionResult->total_mark_attainable}}</span>
                        </td>
                    </tr>
                </table>
            </div>

        </div>

        <div x-data="sessionReport()" class="pl-2 py-3">
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
                                </p>
                            </th>
                            <th class="px-6 py-3  text-center  font-medium text-gray-200 text-sm">
                                1st Term
                                <p class="text-gray-300">(100%)</p>
                            </th>
                            <th class="px-6 py-3  text-center  font-medium text-gray-200 text-sm">
                                2nd Term
                                <p class="text-gray-300">(100%)</p>
                            </th>
                            <th class="px-6 py-3  text-center  font-medium text-gray-200 text-sm">
                                3rd Term
                                <p class="text-gray-300">(100%)</p>
                            </th>
                            <th class="px-6 py-3  text-center  font-medium text-gray-200 text-sm">
                                <div>
                                    <span>Total Avg.</span>
                                    <p class="text-gray-300">(100%)</p>
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
                                <td class="px-6 py-4 text-center text-xs whitespace-nowrap text-gray-200">
                                    {{$subject['1_term']}}
                                </td>
                                <td class="px-6 py-4 text-center text-xs whitespace-nowrap text-gray-200">
                                    {{$subject['2_term']}}
                                </td>
                                <td class="px-6 py-4 text-center text-xs whitespace-nowrap text-gray-200">
                                    {{$subject['3_term']}}
                                </td>
                                <td class="px-6 py-4 text-center text-xs whitespace-nowrap text-gray-200">
                                    {{$subject['overallTermTotalAvg']}}
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
                                    <span class="text-gray-500 truncate capitalize" x-text="getGradeName('{{$subject['subjectMetric']['total']}}')"></span>
                                </td>
                                <td class="px-6 py-4 text-center text-xs whitespace-nowrap text-gray-200">
                                <span class="text-gray-500 truncate capitalize">
                                    <span class="text-gray-500 truncate capitalize" :style="`color:${getGradeFormatColor('{{$subject['subjectMetric']['total']}}')}`" x-text="getGradeName('{{$subject['subjectMetric']['total']}}', 'comment')"></span>
                                </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<script>
    function sessionReport() {
        return{
            gradeFormats: {!! collect($sessionResult->grading_format) !!},
            getGradeName(score, grade = 'name'){

                let format = this.gradeFormats.filter(format => score >= parseInt(format.from) && score <= parseInt(format.to) );

                return grade === 'name' ? format[0].grade : format[0].comment;
            },
            getGradeFormatColor(score){

                let format = this.gradeFormats.filter(format => score >= parseInt(format.from) && score <= parseInt(format.to) );

                return format[0].color;
            },

        }
    }
</script>
