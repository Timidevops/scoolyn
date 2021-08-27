<div>
    <div class="mt-2 text-xl text-gray-200">
        <div class="flex ">
            School Details
        </div>
    </div>
    <a href="{{route('listSetting')}}"><span class="mt-2  text-sm text-gray-300">/!/ Settings</span></a>
</div>

<div class="py-10">
    <div class="bg-white rounded-md px-4 py-4">
        <div>
            <p>
                School Name:
                <span class="text-blue-100 font-light capitalize">
                {{$schoolDetails['schoolName']}}
            </span>
                /!/ -> tooltip: contact scoolyn support to change school's name
            </p>
        </div>
        <div class="mt-3">
            <form action="{{route('updateSchoolDetailsSettings')}}" method="post">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4">
                    <div class="mt-2">
                        <label for="schoolLocation" class="block text-sm font-normal text-gray-100">School Location</label>
                        <input type="text" value="{{$schoolDetails['schoolLocation']}}" name="schoolLocation" id="schoolLocation" class="w-full text-gray-100 rounded-md py-2 px-2 border @error('schoolLocation') border-red-100 @else border-purple-100 @enderror" required>
                        @error('schoolLocation')
                        <div>
                            <p class="text-red-100">
                                {{$message}}
                            </p>
                        </div>
                        @enderror
                    </div>
                    <div class="mt-2">
                        <label for="contactNumber" class="block text-sm font-normal text-gray-100">Contact Number</label>
                        <input type="text" value="{{$schoolDetails['contactNumber']}}" name="contactNumber" id="contactNumber" class="w-full text-gray-100 rounded-md py-2 px-2 border @error('contactNumber') border-red-100 @else border-purple-100 @enderror" required>
                        @error('contactNumber')
                        <div>
                            <p class="text-red-100">
                                {{$message}}
                            </p>
                        </div>
                        @enderror
                    </div>
                    <div class="mt-2">
                        <label for="contactEmail" class="block text-sm font-normal text-gray-100">Contact Email</label>
                        <input type="text" value="{{$schoolDetails['contactEmail']}}" name="contactEmail" id="contactEmail" class="w-full text-gray-100 rounded-md py-2 px-2 border @error('contactEmail') border-red-100 @else border-purple-100 @enderror" required>
                        @error('contactEmail')
                        <div>
                            <p class="text-red-100">
                                {{$message}}
                            </p>
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="px-4 py-4">
                    <button type="submit" class="bg-blue-100 text-white rounded-md py-3 px-3  text-sm" >
                        Update
                    </button>
                </div>
            </form>
        </div>

        <div class="pb-5 w-1/2">
            <div class="pt-3">
                <p>Set School Logo</p>
            </div>

            <div class="">
                @if($schoolLogo)
                    <img src="" width="200" alt="school-logo">
                @endif
                <form action="{{route('updateSchoolLogo')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mt-2 p-4">
                        <label for="schoolLogo" class="block text-sm font-normal text-gray-100">School Logo</label>
                        <input type="file" name="schoolLogo" id="schoolLogo" class="w-full text-gray-100 rounded-md py-2 px-2 border @error('schoolLogo') border-red-100 @else border-purple-100 @enderror" required>
                        @error('schoolLogo')
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

        <div class="mt-5">
            <p>
                School Principal:
                <span class="text-blue-100 font-light capitalize">
                    {{$principalDetails['principalName'] ?? 'not set'}}
            </span>
                /!/ -> tooltip: Used on school's report card.
            </p>
        </div>
        <div class="mt-3">
            <form action="{{route('updateSchoolPrincipal')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4">
                    <div class="mt-2">
                        <label for="principalName" class="block text-sm font-normal text-gray-100">Principal Name</label>
                        <input type="text" value="{{$principalDetails['principalName'] ?? old('principalName')}}" name="principalName" id="principalName" class="w-full text-gray-100 rounded-md py-2 px-2 border @error('principalName') border-red-100 @else border-purple-100 @enderror" required>
                        @error('principalName')
                        <div>
                            <p class="text-red-100">
                                {{$message}}
                            </p>
                        </div>
                        @enderror
                    </div>
                    <div class="mt-2">
                        <label for="principalSignature" class="block text-sm font-normal text-gray-100">Principal Signature</label>
                        <input type="file" name="principalSignature" id="principalSignature" class="w-full text-gray-100 rounded-md py-2 px-2 border @error('principalSignature') border-red-100 @else border-purple-100 @enderror" required>
                        @error('principalSignature')
                        <div>
                            <p class="text-red-100">
                                {{$message}}
                            </p>
                        </div>
                        @enderror
                        @if($principalDetails)
                            <img src="{{$principalDetails['principalSignature']}}" width="200" alt="school-logo">
                        @endif
                    </div>
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
