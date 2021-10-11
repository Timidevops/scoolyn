
<div class="lg:px-8">
    <div class="mt-2 text-xl text-gray-200">
        <div class="flex ">
            Change password
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

<div class="py-10 lg:px-8">
    <div class="bg-white rounded-md">
        <form action="{{route('changePassword')}}" method="post">
            @csrf
            <div class="px-4 py-4">
                <label for="currentPassword" class="block text-sm font-normal text-gray-100">Current Password</label>
                <input type="password" name="currentPassword" id="currentPassword" class="w-2/5 text-gray-100 rounded-md py-2 px-2 border @error('currentPassword') border-red-100 @else border-purple-100 @enderror " required>
                @error('currentPassword')
                    <div>
                        <p class="text-red-100">
                            {{$message}}
                        </p>
                    </div>
                @enderror
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4">
                <div class="mt-2">
                    <label for="newPassword" class="block text-sm font-normal text-gray-100">New Password</label>
                    <input type="password" name="newPassword" id="newPassword" class="w-full text-gray-100 rounded-md py-2 px-2 border @error('newPassword') border-red-100 @else border-purple-100 @enderror" required>
                    @error('newPassword')
                        <div>
                            <p class="text-red-100">
                                {{$message}}
                            </p>
                        </div>
                    @enderror
                </div>
                <div class="mt-2">
                    <label for="newPassword_confirmation" class="block text-sm font-normal text-gray-100">Confirm New Password</label>
                    <input type="password" name="newPassword_confirmation" id="newPassword_confirmation" class="w-full text-gray-100 rounded-md py-2 px-2 border @error('newPassword_confirmation') border-red-100 @else border-purple-100 @enderror" required>
                    @error('newPassword_confirmation')
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
                    Change Password
                </button>
            </div>
        </form>
    </div>
</div>
