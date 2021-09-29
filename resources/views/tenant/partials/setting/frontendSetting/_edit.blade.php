
<div class="lg:px-8">
    <div class="mt-2 text-xl text-gray-200">
        <div class="flex ">
            Frontend setting
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

    <div class="mt-8 bg-white">
        <div class=" sm:block">
            <div class="max-w-6xl mx-auto  sm:px-6 ">
                <div class="flex flex-col mt-2 py-10 rounded-md">
                    @if($settings)
                        <img src="" width="200" alt="login-image">
                    @endif
                    <form action="{{route('updateFrontendSetting')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mt-2 p-4">
                            <label for="frontImage" class="block text-sm font-normal text-gray-100">Front Page Login / Reset password side image</label>
                            <input type="file" name="frontImage" id="frontImage" class="w-full text-gray-100 rounded-md py-2 px-2 border @error('frontImage') border-red-100 @else border-purple-100 @enderror" required>
                            @error('frontImage')
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
    </div>
</div>
