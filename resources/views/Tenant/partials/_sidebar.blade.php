<!-- Static sidebar for desktop -->
<div class="hidden lg:flex lg:flex-shrink-0">
    <div class="flex flex-col  bg-white" style="width: 256px;">
        <div class="flex flex-col flex-grow pt-10 pb-4 overflow-y-auto">
            <div class="flex-shrink-0 px-4 py-2 mx-auto">
                <a href="#">
                    <img class="h-12 mx-auto" src="images/pexels-teddy-joseph-2955375.png" alt="">
                </a>
               <div class="text-lg text-center text-gray-200 pt-2">John Doe</div>
               <span class="text-base text-center mx-3 text-gray-300">SSS 1b</span>
            </div>
            <nav class="mt-8 flex-1 flex flex-col mx-auto overflow-y-auto" aria-label="Sidebar">
                <div class="px-2 space-y-1 ">
                   <div class="relative" x-data="{ show: false }" >
                    <a href="http://app.scoolyn.com.test/dashboard#" class="text-gray-300 flex items-center w-56 px-8 py-4 text-base  leading-6 font-medium rounded-md focus:outline-none focus:bg-blue-100 focus:text-white" x-on:click="show = !show">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-4 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                          </svg>
                       <span class="focus:text-white">Dashboard</span>
                    </a  >
                </div>

                    <div class="relative" x-data="{ show: false }">
                        <a href="{{route('listSubject')}}" class=" {{url()->current() == url()->route('listSubject') ? 'bg-blue-100 text-white' : 'text-gray-300' }} cursor-pointer flex items-center w-56 px-8 py-4 text-base font-medium leading-6 rounded-md focus:bg-blue-100 focus:text-white" x-on:click="show = !show">
                            <svg class="mr-4 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                           <span class="focus:text-white">Subject</span>
                        </a >
                    </div>

                    <div class="relative" x-data="{ show: false }">
                        <a href="{{route('listClass')}}" class=" {{url()->current() == url()->route('listClass') ? 'bg-blue-100 text-white' : 'text-gray-300' }} cursor-pointer flex items-center w-56 px-8 py-4 text-base font-medium leading-6 rounded-md focus:bg-blue-100 focus:text-white" x-on:click="show = !show">
                            <svg class="mr-4 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="focus:text-white">Classes</span>
                        </a >
                    </div>

                    {{-- test --}}
                    <div class="relative" x-data="{ show: false}">
                        <button  class="cursor-pointer flex focus:outline-none items-center w-56 px-8 py-4 text-base  font-medium leading-6 rounded-md  text-gray-300 focus:bg-blue-100 focus:text-white" x-on:click="show = !show">
                            <svg class="mr-4 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                           <span class="focus:text-white">Users</span>
                        </button >
                          <ul class="" x-show="show">
                            <li>
                              <a href="{{route('listStudent')}}" class=" flex items-center  px-8 py-4 text-base leading-6 font-medium rounded-md text-gray-300 focus:bg-blue-100 focus:text-white">
                                <span class="focus:text-white">Student</span>
                                </a>
                            </li>
                              <li>
                                <a href="" class=" flex items-center px-8 py-4 text-base leading-6 font-medium rounded-md text-gray-300 focus:bg-blue-100 focus:text-white">
                                 <span class="focus:text-white"></span> Parents
                                  </a>
                              </li>
                          </ul>
                    </div>
                    {{-- test --}}

                    <div class="relative" x-data="{ show: false }">
                        <a href="" class="cursor-pointer flex items-center w-56 px-8 py-4 text-base font-medium leading-6 rounded-md  text-gray-300 focus:bg-blue-100 focus:text-white" x-on:click="show = !show" >
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-4 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                              </svg>
                            <span class="focus:text-white">Result</span>
                        </a >
                    </div>

                    <div class="relative" x-data="{ show: false }">
                        <a href="" class="cursor-pointer flex items-center w-56 px-8 py-4 text-base leading-6 font-medium rounded-md text-gray-300 focus:bg-blue-100 focus:text-white" x-on:click="show = !show" >
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-4 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                              </svg>
                            <span class="focus:text-white">Payments/Bills</span>
                        </a >
                    </div>

                    <div class="relative" x-data="{ show: false }">
                        <a href="" class="cursor-pointer flex items-center w-56 px-8 py-4 text-base leading-6 font-medium rounded-md text-gray-300 focus:bg-blue-100 focus:text-white" x-on:click="show = !show" >
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-4 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                              </svg>
                            <span class="focus:text-white">Settings</span>
                        </a >
                    </div>
                </div>

                <div class="mt-16 pt-6 ">
                    <div class="px-2 space-y-1">
                        <a href="" class="cursor-pointer flex items-center  w-56 px-8 py-4 text-base leading-6 font-medium rounded-md text-gray-300 focus:bg-blue-100 focus:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-4 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                              </svg>
                            LogOut
                        </a >
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
<!-- Static sidebar for desktop -->
