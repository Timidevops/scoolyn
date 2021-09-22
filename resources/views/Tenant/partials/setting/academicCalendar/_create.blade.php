

<div class="lg:px-8">
    <div>
        <div class="mt-2 text-xl text-gray-200">
            Set new academic session
        </div>
        <a href="{{route('listSetting')}}"><span class="mt-2  text-sm text-gray-300">/!/ Settings</span></a>
    </div>

    <div class="bg-white rounded-md md:flex md:items-center md:mt-2 py-6 px-2 ">
        <form action="{{route('storeAcademicSession')}}" method="post">
            @csrf
            <div class="px-4 py-4">
                <p>Add new session or
                    <a href="{{route('listAcademicCalendar')}}" class="text-blue-100 border-b border-dashed cursor-pointer">select from saved sessions</a>
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4 ">
                <div class="mt-2">
                    <label for="sessionName" class="block text-sm font-normal text-gray-100">Session name</label>
                    <input type="text" name="sessionName" placeholder="2021/2022" value="{{old('sessionName')}}" id="sessionName" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100 @error('sessionName') border-red-100 @else border-purple-100 @enderror" required>
                    @error('sessionName')
                    <p class="text-red-100 text-sm">{{$message}}</p>
                    @enderror
                </div>
                <div class="mt-2">
                    <label for="sessionYear" class="block text-sm font-normal text-gray-100">Session year</label>
                    <input type="text" placeholder="2021" name="sessionYear" id="sessionYear" value="{{old('sessionYear')}}" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100 @error('sessionYear') border-red-100 @else border-purple-100 @enderror" required>
                    @error('sessionYear')
                    <p class="text-red-100 text-sm">{{$message}}</p>
                    @enderror
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4">
                <div class="mt-2">
                    <label for="term" class="block text-sm font-normal text-gray-100">Term</label>
                    <select class="w-full text-gray-100 capitalize rounded-md py-2 px-2 border @error('term') border-red-100 @else border-purple-100 @enderror" name="term" id="term" required>
                        <option value="">-- Select Term --</option>
                        @foreach($terms as $term)
                            <option value="{{$term['uuid']}}">{{$term['name']}} term</option>
                        @endforeach
                    </select>
                    @error('term')
                    <p class="text-red-100 text-sm">{{$message}}</p>
                    @enderror
                </div>
            </div>
            <div class="px-4 py-4">
                <button type="submit" class="bg-blue-100 text-white rounded-md py-3 px-3  text-sm" >
                    Save Academic Session
                </button>
            </div>
        </form>
    </div>

</div>
