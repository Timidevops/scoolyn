
<div x-data="allClassArm()">
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
                       <div class="flex justify-end px-4 py-4">
                           <button type="submit" class="bg-blue-100 text-white rounded-md py-2 px-4 mx-2 text-sm">
                               Save Broadsheet
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
                                           <template x-for="(ca, caIndex) in caAssessmentStructure" :key="ca">
                                               <td class="whitespace-nowrap text-xs text-gray-200">
                                                   <div class="mt-2 text-center">
                                                       <label>
                                                           <input type="number" x-bind:class="`totalScore_${index}_{{$index}}`" @input="onchangeCAScore(index,'{{$index}}')" x-bind:name="`broadsheet[${item.uuid}][${ca.name}]`" class="w-2/5 text-center text-gray-100 rounded-md py-2 px-2 border border-purple-100 ">
                                                       </label>
                                                   </div>
                                               </td>
                                           </template>
                                           <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-200">
                                               <p class="text-gray-200 text-center font-normal" x-bind:id="`totalScore_${index}_{{$index}}`">0</p>
                                               <input type="hidden" x-bind:id="`totalScoreValue_${index}_{{$index}}`" x-bind:name="`broadsheet[${item.uuid}][total]`" />
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
            onchangeCAScore(id,index){
                onchangeCAScore(id, index)
            },
        };
    }
</script>
