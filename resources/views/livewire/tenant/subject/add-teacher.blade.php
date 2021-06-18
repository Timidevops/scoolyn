
<div class="mx-2 md:w-1/4">
    <button wire:click="$set('isAddSubjectTeacherModalOpen', true)" type="button" class="bg-blue-100 text-white rounded-md py-3 text-sm flex items-center">
        <span class="mx-1">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
    </span>
        <span class="mx-1">Add Subject Teacher</span>
    </button>
    <form wire:submit.prevent="store" class="overflow-auto @if($isAddSubjectTeacherModalOpen) absolute inset-0 z-10 flex items-center justify-center @else hidden @endif" style="background-color:rgba(190,192,201,0.7);">
        @csrf
        <div class="mt-12 sm:mx-auto sm:w-full sm:max-w-md md:max-w-md  bg-white rounded-lg shadow-md">
            <div class="flex items-center justify-between mt-3 text-gray-200 text-base mx-4 ">
                <div class="block">
                    <span> Add Subject Teacher</span>
                    <span>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
            </svg>
          </span>
                </div>
                <button type="button" wire:click="$set('isAddSubjectTeacherModalOpen', false)" class="focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </button>
            </div>
            <div class=" mx-4">

                <div class="mt-6">
                    <label for="service" class="block text-xs font-normal text-gray-100">Class name</label>
                    <button wire:click="$set('schoolClassDropdown', {{!$schoolClassDropdown}})" type="button"
                            class="cursor-pointer z-0 w-full py-2 pl-3 pr-10 text-left text-gray-100 font-normal border border-purple-100 rounded-md cursor-default focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5">
                        {{$schoolClassLabel}}
                    </button>
                    <div class="border border-purple-100 @if(!$schoolClassDropdown)  hidden @endif">
                        <ul class="py-1 overflow-auto text-base leading-6 border border-purple-100
              rounded-md shadow-xs focus:outline-none sm:text-sm sm:leading-5">
                            @foreach($schoolClasses as $schoolClass)
                                <li wire:click="selectSchoolClass('{{$schoolClass->uuid}}', '{{$schoolClass->schoolClass->class_name}}')" class="relative py-2 pl-3  text-gray-200 cursor-pointer select-none pr-9">
                                    {{$schoolClass->schoolClass->class_name}}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="my-6 @if(! $isClassInfoShow) hidden @endif">
                    <ul class="py-1 overflow-auto text-base leading-6 border border-purple-100
              rounded-md shadow-xs  focus:outline-none sm:text-sm sm:leading-5">
                        <li class="relative py-2 pl-3  text-gray-100 cursor-pointer select-none pr-9">
                            Class name: {{$classSections}}
                        </li>
                    </ul>
                </div>

                <div class="my-6">
                    <label for="service" class="block text-xs font-normal text-gray-100">Teachers</label>
                    <button wire:click="$set('teacherDropdown', {{!$teacherDropdown}})" type="button"
                            class="cursor-pointer z-0 w-full py-2 pl-3 pr-10 text-left text-gray-100 font-normal border border-purple-100 rounded-md cursor-default focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5">
                        {{$teacherLabel}}
                    </button>
                    <div class="border border-purple-100 @if(!$teacherDropdown)  hidden @endif">
                        <ul class="py-1 overflow-auto text-base leading-6 border border-purple-100
              rounded-md shadow-xs max-h-60 focus:outline-none sm:text-sm sm:leading-5">
                            @foreach($teachers as $teacher)
                                <li wire:click="selectTeacher('{{$teacher->uuid}}', '{{$teacher->full_name}}')" class="relative py-2 pl-3  text-gray-200 cursor-pointer select-none pr-9">
                                    {{$teacher->full_name}}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="mb-6">
                    <button type="submit" class="bg-blue-100 text-white px-4 py-2 rounded-md text-base">
                        Add Teacher
                    </button>
                </div>

            </div>
        </div>
    </form>
</div>
