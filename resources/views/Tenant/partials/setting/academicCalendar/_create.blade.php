<div>
    <div class="mt-2 text-xl text-gray-200">
        Set new academic session
    </div>
    <a href="{{route('listSetting')}}"><span class="mt-2  text-sm text-gray-300">/!/ Settings</span></a>
</div>

<div class="bg-white rounded-md md:flex md:items-center md:mt-2 py-6 px-2 ">
    <form action="{{route('storeAcademicSession')}}" method="post">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4">
            <div class="mt-2">
                <label for="sessionName" class="block text-sm font-normal text-gray-100">Session name</label>
                <input type="text" name="sessionName" id="sessionName" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100" required>
            </div>
            <div class="mt-2">
                <label for="sessionYear" class="block text-sm font-normal text-gray-100">Session year</label>
                <input type="text" name="sessionYear" id="sessionYear" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100" required>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4">
            <div class="mt-2">
                <label for="termName" class="block text-sm font-normal text-gray-100">Term name</label>
                <input type="text" name="termName" id="termName" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100" required>
            </div>
        </div>
        <div class="px-4 py-4">
            <label>
                <input name="currentSession" value="1" type="checkbox">
                <span class="pl-2">Set as current session / term</span>
            </label>
        </div>
        <div class="px-4 py-4">
            <button type="submit" class="bg-blue-100 text-white rounded-md py-3 px-3  text-sm" >
                Add Academic Session
            </button>
        </div>
    </form>
</div>
