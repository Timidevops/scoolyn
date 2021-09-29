<div>
    <div class="mt-2 text-xl text-gray-200">
        <div class="flex ">
            School Details
        </div>
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

<div class="py-10">
    <div class="bg-white rounded-md px-4 py-4">
        <div>
            <div class="flex items-center">
                <div class="w-1/2">
                    School Name:
                    <span class="text-blue-100 font-light capitalize">
                    {{$schoolDetails['schoolName']}}
                    </span>
                </div>
                <div class="w-1/2">
                    <div class='has-tooltip'>
                        <div class='tooltip'>
                            <div class="relative">
                                <div class="bg-blue-100 shadow text-white text-xs rounded py-1 px-4 right-0 bottom-full">
                                    Contact Scoolyn support to change school's name
                                    <svg class="absolute text-blue-100 h-2 left-0 ml-3 top-full" x="0px" y="0px" viewBox="0 0 255 255" xml:space="preserve"><polygon class="fill-current" points="0,0 127.5,127.5 255,0"/></svg>
                                </div>
                            </div>
                        </div>
                        <span class="text-sm text-gray-300">
                    <svg class="h-6 w-6" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                        <path d="M437.02,74.98C388.667,26.629,324.38,0,256,0S123.333,26.629,74.98,74.98C26.629,123.333,0,187.62,0,256
                s26.629,132.667,74.98,181.02C123.333,485.371,187.62,512,256,512s132.667-26.629,181.02-74.98
                C485.371,388.667,512,324.38,512,256S485.371,123.333,437.02,74.98z M256,70c30.327,0,55,24.673,55,55c0,30.327-24.673,55-55,55
                c-30.327,0-55-24.673-55-55C201,94.673,225.673,70,256,70z M326,420H186v-30h30V240h-30v-30h110v180h30V420z"/>
                </svg>
                </span>
                    </div>
                </div>
            </div>
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
            <div class="flex items-center">
                <div class="w-1/2">
                    School Principal:
                    <span class="text-blue-100 font-light capitalize">
                    {{$principalDetails['principalName'] ?? 'not set'}}
                    </span>
                </div>
                <div class="w-1/2">
                    <div class='has-tooltip'>
                        <div class='tooltip'>
                            <div class="relative">
                                <div class="bg-blue-100 shadow text-white text-xs rounded py-1 px-4 right-0 bottom-full">
                                    Used on school's report card
                                    <svg class="absolute text-blue-100 h-2 left-0 ml-3 top-full" x="0px" y="0px" viewBox="0 0 255 255" xml:space="preserve"><polygon class="fill-current" points="0,0 127.5,127.5 255,0"/></svg>
                                </div>
                            </div>
                        </div>
                        <span class="text-sm text-gray-300">
                    <svg class="h-6 w-6" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                        <path d="M437.02,74.98C388.667,26.629,324.38,0,256,0S123.333,26.629,74.98,74.98C26.629,123.333,0,187.62,0,256
                s26.629,132.667,74.98,181.02C123.333,485.371,187.62,512,256,512s132.667-26.629,181.02-74.98
                C485.371,388.667,512,324.38,512,256S485.371,123.333,437.02,74.98z M256,70c30.327,0,55,24.673,55,55c0,30.327-24.673,55-55,55
                c-30.327,0-55-24.673-55-55C201,94.673,225.673,70,256,70z M326,420H186v-30h30V240h-30v-30h110v180h30V420z"/>
                </svg>
                </span>
                    </div>
                </div>
            </div>
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
                        <label for="principalSignature" class="block text-sm font-normal text-gray-100">Principal's Signature</label>
                        <input type="file" name="principalSignature" id="principalSignature" class="w-full text-gray-100 rounded-md py-2 px-2 border @error('principalSignature') border-red-100 @else border-purple-100 @enderror" required>
                        @error('principalSignature')
                        <div>
                            <p class="text-red-100">
                                {{$message}}
                            </p>
                        </div>
                        @enderror
                        @if($principalDetails)
                            <img src="{{$principalDetails['principalSignature']}}" width="200" alt="principal-signature">
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
