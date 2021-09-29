

<div class="lg:px-8" x-data="academicCalendar()">
    <div>
        <div class="mt-2 text-xl text-gray-200">
            Set academic session
        </div>
        <a href="{{route('listSetting')}}" class="flex items-center space-x-1 mt-2">
            <span class=" text-sm text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                </svg>
            </span>
            <span class="text-sm text-gray-300">Settings</span>
        </a>
    </div>
    <div class="mt-8">
        @if($errors->any())
            <div class="mt-1 mb-5 bg-red-100 p-5">
                @foreach ($errors->all() as $error)
                    <p class="text-white">
                        {!! $error !!}
                    </p>
                @endforeach
            </div>
        @endif
        <div class="bg-white rounded-md md:flex md:items-center md:mt-2 py-6 px-2 ">
            <form action="{{route('storeAcademicSession')}}" method="post">
                @csrf
                <div class="px-4 py-4">
                    <p>Current session: {{$currentSession['session_name']}} &nbsp;
                        <span @click="isCreateNewSessionModalOpen  = true;" class="text-blue-100 border-b border-dashed cursor-pointer">create new session</span>
                    </p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4">
                    <div class="mt-2">
                        <label for="term" class="block text-sm font-normal text-gray-100">Term</label>
                        <select class="w-full text-gray-100 capitalize rounded-md py-2 px-2 border @error('term') border-red-100 @else border-purple-100 @enderror" name="term" id="term" required>
                            <option value="">-- Select Term --</option>
                            @foreach($terms as $term)
                                <option {{$currentSession['term'] == $term['uuid'] ? 'selected' : ''}} value="{{$term['uuid']}}">{{$term['name']}} term</option>
                            @endforeach
                        </select>
                        @error('term')
                        <p class="text-red-100 text-sm">{{$message}}</p>
                        @enderror
                    </div>
                </div>
                <div class="px-4 py-4">
                    <button name="update" type="submit" class="bg-blue-100 text-white rounded-md py-3 px-3  text-sm" >
                        Save Academic Session
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- create new session modal -->
        <div class="overflow-auto" style="background-color:rgba(190,192,201,0.7); display:none" x-show="isCreateNewSessionModalOpen" :class="{ 'absolute inset-0 z-10 flex items-center justify-center': isCreateNewSessionModalOpen }">
            <div class="mt-12 sm:mx-auto sm:w-full sm:max-w-md md:max-w-md  bg-white rounded-lg shadow-md">
                <div class="flex items-center justify-between mt-3 text-gray-200 text-base mx-4 ">
                    <div class="block">
                        <span>Create New Academic Session</span>
                        <span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                  </svg>
                </span>
                    </div>
                    <button type="button" x-on:click="isCreateNewSessionModalOpen = false;" class="focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </button>
                </div>
                <div class="mx-4">
                    @include('tenant.partials.setting.academicCalendar.partials._createForm')
                </div>
            </div>
        </div>
    <!--/: create new session modal -->
</div>

<script>
    function academicCalendar() {
        return{
            isCreateNewSessionModalOpen: false,
        }
    }
</script>
