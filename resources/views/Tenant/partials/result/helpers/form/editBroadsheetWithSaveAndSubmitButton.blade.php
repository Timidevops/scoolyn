<form x-data="editBroadsheet()" action="{{route('updateAcademicBroadsheet',$classSubjectId)}}" method="post">
    @csrf
    @method('PATCH')
    <input type="hidden" name="classArm" value="{{$classArm}}">
    <div class="flex justify-end items-center px-4 py-4">
        @if($broadsheetStatus == \App\Models\Tenant\AcademicBroadSheet::NOT_APPROVED_STATUS)
            <div>
                <p class="text-red-100">Disapproved</p>
            </div>
        @endif
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
                        <template x-for="(ca, caIndex) in getBroadsheet(item.broadsheet)" :key="ca">
                            <td class="whitespace-nowrap text-xs text-gray-200">
                                <div class="mt-2 text-center">
                                    <label>
                                        <input type="number" x-bind:value="ca.score" x-bind:class="`totalScore_${index}_{{$classArm}}`" @input="onchangeCAScore(index, '{{$classArm}}', ca, event)" x-bind:name="`broadsheet[${item.studentId}][${ca.name}]`" class="w-2/5 text-center text-gray-100 rounded-md py-2 px-2 border border-purple-100 ">
                                    </label>
                                </div>
                            </td>
                        </template>
                        <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-200">
                            <p class="text-gray-200 text-center font-normal" x-bind:id="`totalScore_${index}_{{$classArm}}`">
                                <span x-text="item.broadsheet.total"></span>
                            </p>
                            <input type="hidden" x-bind:value="item.broadsheet.total" x-bind:id="`totalScoreValue_${index}_{{$classArm}}`" x-bind:name="`broadsheet[${item.studentId}][total]`" />
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

                this.caAssessmentStructure.map((item, index)=>{
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
        }
    }
</script>
