<div class="py-10 lg:px-8 px-4">
    <div class="bg-white rounded-md">
        <div class="flex justify-end px-4 py-4">
            <a href="{{route('uploadParents')}}" class="bg-blue-100 text-white rounded-md py-3 px-2 mx-2 md:w-1/5 text-sm text-center">
                Bulk upload
            </a>
        </div>

        @if($errors->any())
            <div class="mt-1 mb-5 bg-red-100 p-5">
                @foreach ($errors->all() as $error)
                    <p class="text-white">
                        {!! $error !!}
                    </p>
                @endforeach
            </div>
        @endif

        <form x-data="add()" action="{{route('storeParent')}}" method="post">
            @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4">
            <div class="mt-2">
                <label for="firstName" class="block text-sm font-normal text-gray-100">First name</label>
                <input type="text" name="firstName" id="firstName" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100" required>
            </div>

            <div class="mt-2">
                <label for="lastName" class="block text-sm font-normal text-gray-100">Last name</label>
                <input type="text" name="lastName" id="lastName" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100 " required>
            </div>

            <div class="mt-2">
                <label for="email" class="block text-sm font-normal text-gray-100">Email</label>
                <input type="email" name="email" id="email" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100" required>
            </div>

            <div class="mt-2">
                    <label for="phoneNumber" class="block text-sm font-normal text-gray-100">Phone number</label>
                    <input type="number" name="phoneNumber" id="phoneNumber" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100 " required>
            </div>

            <div class="mt-2 relative">
                <label for="Gender" class="block text-sm font-normal text-gray-100">Gender</label>
                <input type="hidden" name="gender" x-bind:value="selectGender.value">
                <div class="relative inline-block w-full rounded-md ">
                    <button type="button" class=" z-0 w-full py-2 pl-3 pr-10 text-left text-gray-100 font-normal border border-purple-100 rounded-md cursor-default focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5" x-text="selectGender.title" x-on:click="open = true">
                        <span class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 my-2 "  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                          </svg>
                          </span>
                    </button>
                </div>
                <div class="border border-purple-100 absolute w-full bg-white" x-show="open" @click.away="open = false">
                    <ul class="py-1 overflow-auto h-32 text-base leading-6
                       shadow-xs max-h-60 focus:outline-none sm:text-sm sm:leading-5">
                        <template x-for="gender in genders" :key="gender">
                            <li @click.prevent="selectGender.title = gender.value; selectGender.value = gender.value; open = false; " class="relative py-2 pl-3  text-gray-200 cursor-default select-none pr-9" :class="{ ' text-blue-100 hover:bg-purple-100': open == true}">
                                <p x-text="gender.value" class="inline-flex"></p>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>
        </div>
            <div class="mt-2 mx-4 ">
                <label for="address" class="block text-sm font-normal text-gray-100">Address</label>
                <textarea name="address" id="address" class="text-gray-100 rounded-md  w-full px-2 py-3 border border-purple-100" rows="5"></textarea>
            </div>


          <div class="px-4 py-4">
            <button type="submit" class="bg-blue-100 text-white rounded-md py-3 px-3  text-sm" >
                Add parent
            </button>
        </div>
    </form>

    </div>
</div>
    <script>
        function add() {
              return {
                open: false,

                selectGender: {
                    title: "Select gender ",
                    value: "",
                },

                  genders:[
                          {
                              value:'Male',
                          },
                          {
                              value:'Female',
                          },
                  ],

                        };
                        }
    </script>
