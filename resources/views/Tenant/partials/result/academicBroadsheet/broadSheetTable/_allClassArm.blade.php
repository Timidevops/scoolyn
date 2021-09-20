
<div x-data="allClassArm()">
    @if($errors->any())
        <div class="mt-1 mb-5 bg-red-100 p-5">
            @foreach ($errors->all() as $error)
                <p class="text-white">
                    {!! $error !!}
                </p>
            @endforeach
        </div>
    @endif
    <!-- tab section -->

    <!-- tab header -->
    <div class="m-4 my-5">
        <!-- tab header -->
        <div class="flex border-b pb-1 border-gray-300">
            @foreach($students as $index => $student)
                <div class="px-2">
                <span x-on:click=" broadsheetTabOpen = '{{$index}}' " :class="broadsheetTabOpen === '{{$index}}' ? 'text-blue-100' : 'text-gray-300' " class="text-sm cursor-pointer">
                    Broadsheet for:
                    {{$student['classSection'] ? $student['classSection']['section_name'] : ''}}
                    &nbsp;
                    {{$student['classSectionCategory'] ? $student['classSectionCategory']['category_name'] : ''}}
                </span>
                </div>
            @endforeach
        </div>
        <!--/: tab header -->
    </div>
    <!--/ tab header -->

    <!-- tab body -->
    @foreach($students as $index => $student)
       <div x-show="broadsheetTabOpen === '{{$index}}'">
           @if( $student['broadsheetStatus'] == \App\Models\Tenant\AcademicBroadSheet::SUBMITTED_STATUS || $student['broadsheetStatus'] == \App\Models\Tenant\AcademicBroadSheet::APPROVED_STATUS)
               @include('.Tenant.partials.result.academicBroadsheet._single', [
                        'broadsheetStatus' => $student['broadsheetStatus'],
                        'gradeFormats' => $student['gradeFormats'],
                        'academicBroadsheets' => $student['academicBroadsheets'],
                        'caAssessmentStructureFormat' => $student['caAssessmentStructureFormat'],
                    ])
           @else
               @if($student['broadsheetStatus'] == \App\Models\Tenant\AcademicBroadSheet::CREATED_STATUS)
                   @include('Tenant.partials.result.helpers.form.editBroadsheetWithSaveAndSubmitButton',[
                    'broadsheetStatus' => $student['broadsheetStatus'],
                    'academicBroadsheets' => $student['academicBroadsheets'],
                    'classArm' => $student['classArm'],

                    ])
               @elseif($student['broadsheetStatus'] == \App\Models\Tenant\AcademicBroadSheet::NOT_APPROVED_STATUS)
                    @include('Tenant.partials.result.academicBroadsheet._edit', [
                        'classArm' => $student['classArm'],
                        'broadsheetStatus' => $student['broadsheetStatus'],
                    'academicBroadsheets' => $student['academicBroadsheets'],
                    ])
               @else
                   <form action="{{route('storeAcademicBroadsheet',$classSubjectId)}}" method="post" >
                       @csrf
                       <input type="hidden" name="classArm" value="{{$student['classArm']}}">
                       <div class="flex justify-between px-4 py-4">
                           <div>
                               <h3>
                                   Assessment for {{\App\Models\Tenant\Setting::getCurrentCardBreakdownFormat(true)}}
                               </h3>
                           </div>
                           <div>
                               @if( count($student['students']) > 0 )
                                   <button type="submit" class="bg-blue-100 text-white rounded-md py-2 px-4 mx-2 text-sm">
                                       Save Broadsheet
                                   </button>
                               @endif
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
                                                   <span class="text-xs uppercase" x-text="item.name"></span>
                                                   <p class="text-gray-300">(<span x-text="item.score"></span>%)</p>
                                                   <input type="hidden" :class=`assessmentScore_{{$index}}` :value="item.score">
                                               </div>
                                           </th>
                                       </template>
                                       <th class="px-6 py-3  text-left  font-medium text-gray-200 text-sm ">
                                           <div class="text-center mx-1">
                                               <span>Total</span>
                                               <p class="text-gray-300">(<span x-bind:id=`totalAssessment_{{$index}}`>0</span>%)</p>
                                               <span x-text="getTotalAssessment('{{$index}}')"></span>
                                           </div>
                                       </th>
                                   </tr>
                                   </thead>
                                   <tbody class="bg-white divide-y divide-purple-100">
                                   <template x-for="(item, index) in Object.values({{$student['students']}})" :key="item">
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
                                               <span class="text-gray-200 font-normal capitalize" x-text="item.first_name"></span>
                                               <span class="text-gray-200 font-normal capitalize" x-text="item.last_name"></span>
                                           </td>
                                           @if( $student['previousReportCard'] != null )
                                               <td class="whitespace-nowrap px-6 py-4  text-xs text-gray-200">
                                                   @foreach($student['previousReportCard'] as $previousReportCard)
                                                       <div class="flex">
                                                           @foreach($student['previousReportCard'] as $previousReportCard)
                                                               <div class="flex space-x-5">
                                                                   <template x-for="(previousReportContent, previousReportIndex) in getPreviousReportData({{$previousReportCard['caAssessmentStructureFormat']}}, {{$previousReportCard['academicBroadsheets']}}, item.studentId ?? item.uuid ) ">
                                                                       <div>
                                                                           <p class="text-gray-500 truncate text-center" :class="`previousReportContentScore_${index}_{{$index}}`" x-text="previousReportContent.score"></p>
                                                                       </div>
                                                                   </template>
                                                               </div>
                                                           @endforeach
                                                       </div>
                                                   @endforeach
                                               </td>
                                           @endif
                                           <template x-for="(ca, caIndex) in caAssessmentStructure.caFormat" :key="ca">
                                               <td class="whitespace-nowrap text-xs text-gray-200">
                                                   <div class="mt-2 text-center">
                                                       <label>
                                                           <input type="number" x-bind:class="`totalScore_${index}_{{$index}}`" @input="onchangeCAScore(index,'{{$index}}',ca, event)" x-bind:name="`broadsheet[${item.uuid}][${ca.name}]`" class="w-2/5 text-center text-gray-100 rounded-md py-2 px-2 border border-purple-100 ">
                                                       </label>
                                                   </div>
                                               </td>
                                           </template>
                                           <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-200">
                                               <p class="text-gray-200 text-center font-normal" x-on:load="" x-bind:id="`totalScore_${index}_{{$index}}`">0</p>
                                               <input type="hidden" :value="getTotalScoreFromPrevious(index,'{{$index}}')" x-bind:id="`totalScoreValue_${index}_{{$index}}`" />
                                           </td>
                                       </tr>
                                   </template>
                                   </tbody>
                               </table>
                           </div>
                       </div>
                   </form>
               @endif
           @endif
       </div>
    @endforeach
    <!--/ tab body -->

<!--/ tab section -->
</div>

<script>
    function allClassArm() {
        return{
            broadsheetTabOpen: '0',
            caAssessmentStructure: caAssessmentStructure(),
            onchangeCAScore(id,index,ca,value){

                if( parseFloat(value.target.value) > parseFloat(ca.score) ){
                    value.target.classList.remove('border-purple-100')
                    value.target.classList.add('border-red-100')
                    value.target.value = 0;
                    onchangeCAScore(id, index);
                    return false;
                }

                value.target.classList.remove('border-red-100')
                value.target.classList.add('border-purple-100')

                onchangeCAScore(id, index);
            },
            getTotalAssessment(index){
                let total = 0;

                document.querySelectorAll(`.previousReportCardScore_${index}`).forEach(function (e) {
                    total += Number(e.value);
                })

                document.querySelectorAll(`.assessmentScore_${index}`).forEach(function (e) {
                    total += Number(e.value);
                })
                document.getElementById(`totalAssessment_${index}`).innerText = total;
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

            getTotalScoreFromPrevious(id, index){

                let scoreIdText = `totalScore_${id}_${index}`;
                let totalScore = 0;

                let previousReportContentScore = `previousReportContentScore_${id}_${index}`;

                document.querySelectorAll(`.${previousReportContentScore}`).forEach((value => {
                    totalScore += Number(value.innerHTML);
                }));

                document.getElementById(scoreIdText).innerText = totalScore > 100 ? '0' : totalScore;
            },
        };
    }
</script>
