<!-- Static sidebar for desktop -->
<div class="hidden md:flex md:flex-shrink-0 max-h-screen" x-data="{navigationOpen: false, isSchoolDropdownOpen: false, isPlanDropdownOpen: false,}" >
    <div class="flex flex-col bg-white  w-auto">
        <button type="button" class="p-2 flex ml-auto bg-blue-100 text-white focus:outline-none"
                x-on:click="navigationOpen = !navigationOpen">
            <svg class="w-6 h-6" :class="{'transform rotate-180': navigationOpen === true}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </button>
        <div class="flex flex-col flex-grow pt-5 pb-4 overflow-y-auto">
            <div class="flex-shrink-0 px-4 py-2 mx-auto" :class="{'hidden': navigationOpen === true}">
                <a href="">
                    <img class="h-12 mx-auto" src="{{asset('images/pexels-teddy-joseph-2955375.png')}}" alt="">
                </a>
                <div class="text-lg text-center text-gray-200 pt-2">
                    <p class="capitalize">{{Auth::user()->name}}</p>
                </div>
            </div>
            <nav class="mt-8 flex-1 flex flex-col  overflow-y-auto" aria-label="Sidebar">
                <div class="px-2 space-y-1 ">
                    <div>
                        <a href="{{route('landlordDashboard')}}" class="{{url()->current() == url()->route('landlordDashboard') ? 'bg-blue-100 text-white' : 'text-gray-300' }} cursor-pointer flex items-center  px-8 py-4 text-base font-medium leading-6 rounded-md focus:bg-blue-100 focus:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-4 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" :class="{'hidden': navigationOpen === true}">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-show="navigationOpen === true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            <span class="focus:text-white" :class="{'hidden': navigationOpen === true}">Dashboard</span>
                        </a>
                    </div>
                    <div class="">
                        <button  class="cursor-pointer flex focus:outline-none items-center  px-8 py-4 text-base  font-medium leading-6 rounded-md  text-gray-300 " x-on:click="isSchoolDropdownOpen = !isSchoolDropdownOpen">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-4 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" :class="{'hidden': navigationOpen === true}">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-show="navigationOpen === true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="flex items-center space-x-8" :class="{'hidden': navigationOpen === true}">
                                <span class="focus:text-white">Schools</span>
                                <span class=" ">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="ml-3 h-5 w-5 transform"
                                         :class="{'rotate-180': isSchoolDropdownOpen}" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                  </svg>
                                </span>
                            </span>
                        </button >
                        <ul class="space-y-2" x-show="isSchoolDropdownOpen">
                            <li>
                                <a href="{{route('listSchool')}}" class="{{url()->current() == url()->route('listSchool') ? 'bg-blue-100 text-white' : 'text-gray-300' }} cursor-pointer flex items-center  px-8 py-4 text-base font-medium leading-6 rounded-md focus:bg-blue-100 focus:text-white">
                                    <span class="focus:text-white">View Schools</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('createSchool')}}" class="{{url()->current() == url()->route('createSchool') ? 'bg-blue-100 text-white' : 'text-gray-300' }} cursor-pointer flex items-center  px-8 py-4 text-base font-medium leading-6 rounded-md focus:bg-blue-100 focus:text-white">
                                    <span class="focus:text-white">Add New School</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="">
                        <button  class="cursor-pointer flex focus:outline-none items-center  px-8 py-4 text-base  font-medium leading-6 rounded-md  text-gray-300 " x-on:click="isPlanDropdownOpen = !isPlanDropdownOpen">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-4 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" :class="{'hidden': navigationOpen === true}">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-show="navigationOpen === true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="flex items-center space-x-8" :class="{'hidden': navigationOpen === true}">
                                <span class="focus:text-white">Plans</span>
                                <span class=" ">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="ml-3 h-5 w-5 transform"
                                         :class="{'rotate-180': isPlanDropdownOpen}" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                  </svg>
                                </span>
                            </span>
                        </button >
                        <ul class="space-y-2" x-show="isPlanDropdownOpen">
                            <li>
                                <a href="{{route('listPlan')}}" class="{{url()->current() == url()->route('listSchool') ? 'bg-blue-100 text-white' : 'text-gray-300' }} cursor-pointer flex items-center  px-8 py-4 text-base font-medium leading-6 rounded-md focus:bg-blue-100 focus:text-white">
                                    <span class="focus:text-white">View Plans</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('createPlan')}}" class="{{url()->current() == url()->route('createSchool') ? 'bg-blue-100 text-white' : 'text-gray-300' }} cursor-pointer flex items-center  px-8 py-4 text-base font-medium leading-6 rounded-md focus:bg-blue-100 focus:text-white">
                                    <span class="focus:text-white">Add New Plan</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="my-16 py-6 ">
                    <div class="px-2 space-y-1">
                        <p onclick=" return document.getElementById('logout-form').submit()"
                           class="cursor-pointer flex items-center   px-8 py-4 text-base leading-6 font-medium rounded-md text-gray-300 focus:bg-blue-100 focus:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-4 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" :class="{'hidden': navigationOpen === true}">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-show="navigationOpen === true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span class="focus:text-white" :class="{'hidden': navigationOpen === true}">LogOut</span>
                        </p >
                        <form id="logout-form" action="{{route('landlordLogout')}}" method="POST">
                            @csrf
                        </form>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
<!-- Static sidebar for desktop -->
