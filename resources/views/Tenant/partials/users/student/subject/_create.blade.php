<div class="mx-2 md:w-1/4" x-data="addSubject()">

    <button type="button" @click="isAddSubjectModalOpen = true;" class="bg-blue-100 text-white rounded-md py-3 text-sm flex items-center">
        <span class="mx-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </span>
            <span class="mx-2">Add Subject</span>
    </button>

    <form action="{{route('storeStudentSubject',$studentId)}}" method="post" x-show="isAddSubjectModalOpen" class="absolute inset-0 z-10 flex items-center justify-center" style="background-color:rgba(190,192,201,0.7);">
    @csrf
    <div class="mt-12 sm:mx-auto sm:w-full sm:max-w-md md:max-w-md  bg-white rounded-lg shadow-md">
        <div class="flex items-center justify-between mt-3 text-gray-200 text-base mx-4 ">
            <div class="block">
                <span> Add Subject</span>
                <span>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
            </svg>
          </span>
            </div>
            <button type="button" @click="isAddSubjectModalOpen = false" class="focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </button>
        </div>
        <div class=" mx-4" >
            <div class="my-6">
                <label for="service" class="block text-xs font-normal text-gray-100">Select Subjects</label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-4">
                    <template x-for="(item, index) in classSubjects" :key="index">
                        <div>
                            <label class="flex items-center">
                                <input name="subjects[]" type="checkbox" x-on:change="onCheckedSubject(item.uuid, event.target)">
                                <span x-text="item.subject.subject_name" class="text-sm font-medium pl-2 capitalize"></span>
                            </label>
                        </div>
                    </template>
                </div>
            </div>
            <div class="px-4 py-4">
                <button type="submit" class="bg-blue-100 text-white rounded-md py-3 px-3  text-sm">
                    Add subject
                </button>
            </div>
        </div>
    </div>
</form>

</div>

<script>
    function addSubject() {
        return{
            isAddSubjectModalOpen: false,
            classSubjects: {!! $classSubjects !!},
            onCheckedSubject(value, event){
                if(event.checked) return  event.value = value;
                return  event.value = '';
            }
        }
    }
</script>
