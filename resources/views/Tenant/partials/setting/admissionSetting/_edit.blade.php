<div>
    <div class="mt-2 text-xl text-gray-200">
        <div class="flex ">
            Change Admission Setting
        </div>
    </div>
    <a href="{{route('listSetting')}}"><span class="mt-2  text-sm text-gray-300">/!/ Settings</span></a>
</div>

<div class="py-10">
    <div class="bg-white rounded-md px-4 py-4">
        <p>
            Admission Status:
            <span class="text-blue-100 font-light">
                {{$settingValue ? 'Admission in progress' : 'No admission in progress'}}
            </span>
        </p>
        <div class="mt-3">
            <form action="{{route('storeAdmissionSetting')}}" method="post">
                @csrf
               <div class="px-4 py-4">
                   <label for="isAdmissionOn" class="block text-sm font-normal text-gray-100">Is admission in progress</label>
                   <select id="isAdmissionOn" name="isAdmissionOn" class="w-2/5 text-gray-100 rounded-md py-2 px-2 border @error('isAdmissionOn') border-red-100 @else border-purple-100 @enderror " required>
                       <option value="">-- Select Option --</option>
                       <option value="1" {{ $settingValue ? 'selected' : '' }}>Yes</option>
                       <option value="0" {{ ! $settingValue ? 'selected' : '' }}>No</option>
                   </select>
                   @error('isAdmissionOn')
                   <div>
                       <p class="text-red-100">
                           {{$message}}
                       </p>
                   </div>
                   @enderror
               </div>
                <div class="px-4 py-4">
                    <button type="submit" class="bg-blue-100 text-white rounded-md py-3 px-3  text-sm" >
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
