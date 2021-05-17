<!-- Static sidebar for desktop -->
<div class="hidden lg:flex lg:flex-shrink-0">
    <div class="flex flex-col w-64 bg-white">
        <div class="flex flex-col flex-grow pt-10 pb-4 overflow-y-auto">
            <div class="flex-shrink-0 gray-300 text-2xl px-4 mx-auto">
                <a href="#">
                    <img class="h-10 mx-auto" src="images/pexels-teddy-joseph-2955375.png" alt="">
                </a>
               <div class="text-lg text-center">John Doe</div>
               <span class="text-base text-center mx-3">SSS 1b</span>
            </div>
            <nav class="mt-5 flex-1 flex flex-col mx-auto overflow-y-auto" aria-label="Sidebar">
                <div class="px-2 space-y-1">
                    <a href="#" class="gray-300 active:bg-cyan-800 flex items-center px-2 py-2 text-base  leading-6 font-medium rounded-md hover:bg-cyan-800 active:cyan-800" aria-current="page">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-4 h-6 w-6 text-cyan-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                          </svg>
                        Dashboard
                    </a>
                    
                    <div class="relative">
                        <a class="cursor-pointer flex items-center px-2 py-2 text-base  font-medium leading-6 rounded-md  gray-300 hover:bg-cyan-800 active:cyan-800" x-on:click="open = !open">

                            <svg class="mr-4 h-6 w-6 text-cyan-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Subject
                        </a>
                    </div>

                    <div class="relative">
                        <a class="cursor-pointer flex items-center px-2 py-2 text-base  font-medium leading-6 rounded-md  gray-300 hover:bg-cyan-800 active:cyan-800" x-on:click="open = !open">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-4 h-6 w-6 text-cyan-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                              </svg>
                            Result
                        </a>
                    </div>

                    <div class="relative">
                        <a class="cursor-pointer flex items-center px-2 py-2 text-base  font-medium leading-6 rounded-md  gray-300 hover:bg-cyan-800 active:cyan-800" x-on:click="open = !open">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-4 h-6 w-6 text-cyan-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                              </svg>
                            Payments/Bills
                        </a>
                    </div>

                    <div class="relative">
                        <a class="cursor-pointer flex items-center px-2 py-2 text-base  leading-6 font-medium rounded-md text-cyan-100 gray-300 hover:bg-cyan-800 active:cyan-800" x-on:click="open = !open">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-4 h-6 w-6 text-cyan-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                              </svg>
                            Settings
                        </a>
                    </div>
                </div>

                <div class="mt-24 pt-6 ">
                    <div class="px-2 space-y-1">
                        <a class="cursor-pointer flex items-center px-2 py-2 text-base  leading-6 font-medium rounded-md text-cyan-100 gray-300 hover:bg-cyan-800 active:cyan-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-4 h-6 w-6 text-cyan-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                              </svg>
                            LogOut
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
<!-- Static sidebar for desktop -->
