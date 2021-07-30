<!-- Static sidebar for desktop -->
<div class="hidden lg:flex lg:flex-shrink-0 max-h-screen " x-data="{navigationOpen: false, isUserDropDownOpen: false, isResultDropDownOpen: false,}" >
    <div class="flex flex-col bg-white w-auto ">
        <button type="button" class="p-2  flex ml-auto bg-blue-100 text-white focus:outline-none"
                x-on:click="navigationOpen = !navigationOpen">
            <svg class="w-6 h-6" :class="{'transform rotate-180': navigationOpen === true}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </button>
        <div class="flex flex-col flex-grow pt-5 pb-4 overflow-y-auto">
            <div class="flex-shrink-0 px-4 py-2 mx-auto" :class="{'hidden': navigationOpen === true}">
                <a href="#">
                    <img class="h-12 mx-auto" src="{{asset('images/pexels-teddy-joseph-2955375.png')}}" alt="">
                </a>
                <div class="text-lg text-center text-gray-200 pt-2">
                    <p class="capitalize"> Parent Name </p>
                </div>
                <span class="text-base text-center mx-3 text-gray-300">SSS 1b</span>
            </div>

        </div>
    </div>
</div>
