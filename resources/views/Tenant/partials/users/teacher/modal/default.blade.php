<div x-show="isSelectSubjectModalOpen" class="overflow-auto absolute inset-0 z-10 flex items-center justify-center" style="background-color:rgba(190,192,201,0.7); display:none">
    <div class="mt-12 sm:mx-auto sm:w-full sm:max-w-lg md:max-w-lg  bg-white rounded-lg shadow-md">
        <div class="flex items-center justify-between mt-3 text-gray-200 text-base mx-4 ">
            <div class="block">
                <span>Select Subject</span>
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                    </svg>
                </span>
            </div>
            <button @click="isSelectSubjectModalOpen = false;" type="button" class="focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </button>
        </div>
        <div class=" mx-4" x-data="selectSubject()">
            <div class="mt-6">
                <label for="schoolClass" class="block text-xs font-normal text-gray-100">Add subjects</label>
            </div>

            <div class="align-middle min-w-full">
                <table class="min-w-full divide-y  divide-purple-100">
                    <thead>
                    <tr>
                        <th class="px-6 py-3 text-sm font-normal text-gray-100">
                            Subject
                        </th>
                        <th class="px-6 py-3 text-sm font-normal text-gray-100">
                            Class name
                        </th>
                        <th class="px-6 py-3 text-sm font-normal text-gray-100">
                            Class section
                        </th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-purple-100">
                    <template x-for="(item, index) in subjectHolder">
                        <tr class="bg-white">
                            <td class="max-w-0  py-4 whitespace-nowrap">
                                <div>
                                    <input x-bind:id="`subjectId_${index}`" type="hidden" x-model="item.subject">
                                    <button x-on:click="subjectDropdownOpen(index)"
                                            type="button"
                                            class="cursor-pointer w-full z-0 py-2 px-3 text-center text-gray-100 font-normal border border-purple-100 rounded-md cursor-default focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5">
                                        <span x-bind:id="`subjectDropdownLabelId_${index}`" >-- choose a subject --</span>
                                    </button>
                                    <div x-bind:id="`subjectDropdownId_${index}`" class="relative hidden border border-purple-100">
                                        <ul class="absolute z-10 bg-white w-full py-1 overflow-auto  text-base leading-6 border border-purple-100
              rounded-md shadow-xs focus:outline-none sm:text-sm sm:leading-5">
                                            {{--                                                <template x-for="(content, sn) in subjects" :key="sn">--}}
                                            {{--                                                    <li wire:click="selectSubject" x-on:click=" selectSubjectOption(index,content.subject_name, content.uuid,);" class="relative py-2 pl-3  text-gray-200 cursor-pointer select-none pr-9">--}}
                                            {{--                                                        <span x-text="content.subject_name"></span>--}}
                                            {{--                                                    </li>--}}
                                            {{--                                                </template>--}}
                                            @foreach($subjects as $subject)
                                                <li wire:click="selectSubject('{{$subject->uuid}}')"
                                                    x-on:click="selectSubjectOption(index, '{{$subject->subject_name}}', '{{$subject->uuid}}')"
                                                    class="relative py-2 pl-3  text-gray-200 cursor-pointer select-none pr-9">{{$subject->subject_name}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </td>
                            <td class="max-w-0  px-6 py-4 whitespace-nowrap">
                                <div>
                                    <button x-bind:id="`schoolClassId_${index}`"
                                            disabled
                                            type="button"
                                            class="cursor-pointer w-full z-0 py-2 px-3 text-center text-gray-100 font-normal border border-purple-100 rounded-md cursor-default focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5">
                                        <span>-- select a class --</span>
                                    </button>
                                    <div x-bind:id="`schoolClassDropdownId_${index}`" class="relative hidden border border-purple-100">
                                        <ul class="absolute z-10 bg-white w-full py-1 overflow-auto  text-base leading-6 border border-purple-100
              rounded-md shadow-xs focus:outline-none sm:text-sm sm:leading-5">
                                            {{--                                                @foreach()--}}
                                            {{--                                                @endforeach--}}
                                            <template x-for="(item,index) in className">
                                                <li>here</li>
                                            </template>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                            <td class="max-w-0  px-6 py-4 whitespace-nowrap">
                                <div>
                                    <span x-text="item.className"></span>
                                </div>
                            </td>
                            <td class="cursor-pointer">
                                <span x-on:click="removeSubjectHolder(index)">/!/</span>
                            </td>
                        </tr>
                    </template>
                    </tbody>
                </table>
            </div>

            <div class="my-6 text-right">
                <button x-on:click="addNewSubjectHolder" type="button" class="bg-white text-grey-100 border border-grey-300 rounded-md py-2 px-2   text-sm">
                    Add new subject
                </button>
            </div>

        </div>
    </div>
</div>


<script>
    function selectSubject() {
        return{
            subjects: {!! $subjects !!},
            subjectHolder: [],
            addNewSubjectHolder(){
                this.subjectHolder.push([{
                    subject: '',
                    className: '',
                }]);
            },
            tt: [],
            className: @entangle('className').defer,
            removeSubjectHolder(index){
                this.subjectHolder.splice(index, 1);
            },

            subjectDropdownOpen(id){

                let subjectDropdownId = `subjectDropdownId_${id}`;

                document.getElementById(subjectDropdownId).classList.toggle('hidden')
            },

            selectSubjectOption(id, subject, uuid){
                let subjectDropdownLabelId = `subjectDropdownLabelId_${id}`;

                document.getElementById(subjectDropdownLabelId).innerHTML = subject;

                let subjectDropdownId = `subjectDropdownId_${id}`;

                document.getElementById(subjectDropdownId).classList.add('hidden')

                let subjectId = `subjectId_${id}`;
                document.getElementById(subjectId).value = uuid;

                let schoolClassDropdownId = `schoolClassDropdownId_${id}`;

                document.getElementById(schoolClassDropdownId).classList.remove('hidden')

            },
        }
    }
</script>
