<div class="px-4 sm:px-6 lg:px-8" x-data="addWard()">
    <div class="mt-8 mb-4">
        <div class="mt-2 text-xl text-gray-200">
            Add new ward for: {{$parent->first_name}} {{$parent->last_name}}
        </div>
        <a href="{{route('listParentWard',$parent->uuid)}}" class="flex relative items-center space-x-1 mt-2">
            <span class=" text-sm text-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                      </svg>
                    </span>
            <span class="text-sm text-gray-300">Back to parent wards</span>
        </a>
    </div>
    @if($errors->any())
        <div class="mt-1 mb-5 bg-red-100 p-5">
            @foreach ($errors->all() as $error)
                <p class="text-white">
                    {!! $error !!}
                </p>
            @endforeach
        </div>
    @endif
    <div class="bg-white rounded-md mt-8 py-6 px-2 ">
        <form action="{{route('storeParentWard',$parent->uuid)}}" method="post">
            @csrf
            <div class="px-4">
                <label for="student" class="block text-sm font-normal text-gray-100">Student</label>
            </div>
            <template x-for="(item, index) in studentField" :key="index">
                <div>
                    <div class="grid grid-cols-2 md:grid-cols-2 gap-6 p-4 items-center">
                        <div class="">
                            <label for="student"></label>
                            <select x-model="item.value" class="w-full text-gray-100 capitalize rounded-md py-2 px-2 border border-purple-100" name="students[]" id="student" required>
                                <option value="">-- Select Student --</option>
                                @foreach($students as $student)
                                    <option value="{{$student['uuid']}}">
                                        <span>
                                            {{$student['first_name']}}
                                            {{$student['other_name']}}
                                            {{$student['last_name']}}
                                            -
                                            {{$student->classArm->schoolClass->class_name}}
                                            {{$student->classArm->classSection ? $student->classArm->classSection->section_name : ''}}
                                            {{$student->classArm->classSectionCategory ? $student->classArm->classSectionCategory->category_name : ''}}
                                        </span>
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <button type="button" @click="removeWard(index)" class="cursor-pointer">
                                <span>
                                    <svg class="h-6 w-6" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                         viewBox="0 0 409.6 409.6" style="enable-background:new 0 0 409.6 409.6;" xml:space="preserve">
                                                                <path d="M392.533,187.733H17.067C7.641,187.733,0,195.374,0,204.8s7.641,17.067,17.067,17.067h375.467
                                        c9.426,0,17.067-7.641,17.067-17.067S401.959,187.733,392.533,187.733z"/>
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </template>
            <div class="flex justify-end mt-4">
                <button @click="addNewWard()" type="button" class="py-2 px-4 bg-blue-100 text-white text-xs rounded font-light ">
                    Add new ward
                </button>
            </div>
            <div class="px-4 py-4">
                <button type="submit" class="bg-blue-100 text-white rounded-md py-3 px-2  md:w-1/3 text-sm">
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function addWard() {
        return{
            studentField: [{
                    value: '',
                }],
            addNewWard(){
                this.studentField.push({
                    value: '',
                });
            },
            removeWard(index){
                this.studentField.splice(index, 1);
            },
        }
    }
</script>
