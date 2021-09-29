
<div class="lg:px-8">
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
        <a href="{{route('listReportSheet', $academicResult->classArm->uuid)}}" class="flex items-center space-x-1 mt-2">
            <span class=" text-sm text-gray-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
            </svg>
        </span>
            <span class="text-sm text-gray-300">Academic report sheets</span>
        </a>
    </div>

    <div class="bg-white rounded-md py-6 px-2 mt-6">

        <div class="pl-2 py-3 flex ">
            <div>
                <a href="{{route('authPrintResult',[$academicResult->classArm->uuid, $academicResult->uuid, $academicResult->student->uuid])}}" target="_blank">
                    <button type="button" class="bg-blue-100 text-white rounded-md py-3 mx-2 px-5 text-sm flex items-center">
                        Print result
                    </button>
                </a>
            </div>

            @if( ! $approvedResult )
                <div>
                    <form class="flex" action="{{route('updateReportSheet',[$academicResult->classArm->uuid, $academicResult->student->uuid])}}" method="post">
                        @csrf
                        @method('PATCH')
{{--                        <div>--}}
{{--                            <button name="disapprove" type="submit" class="bg-white border border-red-100  rounded-md py-3 mx-2 px-5 text-sm flex items-center">--}}
{{--                                Disapprove result--}}
{{--                            </button>--}}
{{--                        </div>--}}
                        <div>
                            <button name="approve" type="submit" class="bg-white border border-blue-100  rounded-md py-3 mx-2 px-5 text-sm flex items-center">
                                Approve result
                            </button>
                        </div>
                    </form>
                </div>
                @elseif($sessionResult)
                <div>
                    <a href="{{route('sessionResult',[$academicResult->classArm->uuid, $academicResult->student->uuid])}}">
                        <button type="button" class="bg-white border border-blue-100  rounded-md py-3 mx-2 px-5 text-sm flex items-center">
                            View session result
                        </button>
                    </a>
                </div>
            @endif
        </div>

        <div class="flex items-center flex-col my-5">

            <div class="pl-2">
                <span class="uppercase">{{$academicResult->student->first_name}}</span>
                <span class="capitalize">{{$academicResult->student->other_name}}</span>
                <span class="capitalize">{{$academicResult->student->last_name}}</span>
            </div>

            <div class="pl-2">
                <span class="capitalize">{{$academicResult->classArm->schoolClass->class_name}}</span>
                <span class="font-medium text-xs text-gray-200 capitalize">
                    {{$academicResult->classArm->classSection ? "| {$academicResult->classArm->classSection->section_name}" : ''}}
                    {{$academicResult->classArm->classSectionCategory ? "| {$academicResult->classArm->classSectionCategory->category_name}" : ''}}
                </span>
            </div>

            <div class="pl-2 py-3">
                <span class="uppercase">{{strOrdinal($academicResult->academicSession->getTerm->number)}} &nbsp;term</span>
                &nbsp;
                <span class="capitalize">{{str_replace('-','/',$academicResult->academicSession->session_name)}}</span>
                &nbsp;
                <span class="uppercase">Academic Session</span>

            </div>

            <div class="pl-2 py-3">
                <h4 class="uppercase text-blue-100 font-bold">
                    {{\App\Models\tenant\Setting::getCurrentCardBreakdownFormat(true)}}
                </h4>
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
                    <tr>
                        <td>
                            <span class="capitalize text-sm">total mark attainable:</span>
                        </td>
                        <td>
                            <span class="capitalize text-sm">{{$academicResult->total_mark_attainable}}</span>
                        </td>
                    </tr>
                </table>
            </div>

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
                                    <span class="uppercase text-xs" x-text="item.name"></span>
                                    <p class="text-gray-300">(<span x-text="item.score"></span>%)</p>
                                    <input type="hidden" class="assessmentScore" :value="item.score">
                                </div>
                            </th>
                        </template>
                        <th class="px-6 py-3  text-center  font-medium text-gray-200 text-sm">
                            <div>
                                <span>Total</span>
                                <p class="text-gray-300">(<span x-text="getTotalAssessment()"></span>%)</p>
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
                                    {{$subject['subjectMetric']['total']}}
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

        <div class="pl-2 py-3">
            <form action="{{route('storeReportComment',[$classArmId,$studentId])}}" method="post">
                @csrf
                <div class="px-4 py-4">
                    <label for="comment" class="block text-sm font-normal text-gray-100">Comment:</label>
                    <textarea
                        name="comment" id="comment"
                        class="w-2/5 text-gray-100 rounded-md py-2 px-2 border @error('comment') border-red-100 @else border-purple-100 @enderror " required
                    >{{$academicResult['comment']}}</textarea>
                    @error('comment')
                    <div>
                        <p class="text-red-100">
                            {{$message}}
                        </p>
                    </div>
                    @enderror
                </div>
                <div class="px-4 py-4">
                    <label for="principalRemark" class="block text-sm font-normal text-gray-100">Principal's remark:</label>
                    <textarea
                        name="principalRemark" id="principalRemark"
                        class="w-2/5 text-gray-100 rounded-md py-2 px-2 border @error('principalRemark') border-red-100 @else border-purple-100 @enderror "
                    >{{$academicResult['principal_remark']}}</textarea>
                    @error('principalRemark')
                    <div>
                        <p class="text-red-100">
                            {{$message}}
                        </p>
                    </div>
                    @enderror
                </div>
                <div class="px-4 py-4">
                    <button type="submit" class="bg-blue-100 text-white rounded-md py-3 px-3  text-sm" >
                        Submit
                    </button>
                </div>
            </form>
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
            },
            getGradeFormatColor(score){

                let format = this.gradeFormats.filter(format => score >= parseInt(format.from) && score <= parseInt(format.to) );

                return format[0].color;
            },
            getTotalAssessment(){
                let total = 0;
                document.querySelectorAll(`.assessmentScore`).forEach(function (e) {
                    total += Number(e.value);
                })
                return total;
            },
        }
    }
</script>

