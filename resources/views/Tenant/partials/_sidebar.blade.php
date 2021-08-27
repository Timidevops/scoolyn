<!-- Static sidebar for desktop -->
<div class="hidden md:flex md:flex-shrink-0 max-h-screen" x-data="{navigationOpen: false, isUserDropDownOpen: false, isResultDropDownOpen: false,}" >
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
                   <p class="capitalize">{{Auth::user()->getUserFullName()}}</p>
               </div>
            </div>
            <nav class="mt-8 flex-1 flex flex-col  overflow-y-auto" aria-label="Sidebar">
                <div class="px-2 space-y-1 ">
                   <div>
                    <a href="{{route('dashboard')}}" class="{{url()->current() == url()->route('dashboard') ? 'bg-blue-100 text-white' : 'text-gray-300' }} cursor-pointer flex items-center  px-8 py-4 text-base font-medium leading-6 rounded-md focus:bg-blue-100 focus:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-4 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" :class="{'hidden': navigationOpen === true}">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                          </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-show="navigationOpen === true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                          </svg>
                       <span class="focus:text-white" :class="{'hidden': navigationOpen === true}">Dashboard</span>
                    </a>
                </div>

                    @can('read a subject')
                        <div>
                            <a href="{{route('listSubject')}}" class="{{url()->current() == url()->route('listSubject') ? 'bg-blue-100 text-white' : 'text-gray-300' }} cursor-pointer flex items-center  px-8 py-4 text-base font-medium leading-6 rounded-md focus:bg-blue-100 focus:text-white">
                                <svg class="mr-4 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" :class="{'hidden': navigationOpen === true}">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" x-show="navigationOpen === true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="focus:text-white" :class="{'hidden': navigationOpen === true}">Subject</span>
                            </a >
                        </div>
                    @endcan

                    @can('read a class arm')
                        <div class="">
                            <a href="{{route('listClass')}}" class="{{url()->current() == url()->route('listClass') ? 'bg-blue-100 text-white' : 'text-gray-300' }} cursor-pointer flex items-center  px-8 py-4 text-base font-medium leading-6 rounded-md focus:bg-blue-100 focus:text-white">
                                <svg class="mr-4 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" :class="{'hidden': navigationOpen === true}">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"  x-show="navigationOpen === true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="focus:text-white" :class="{'hidden': navigationOpen == true}">Classes</span>
                            </a >
                        </div>
                    @endcan

                    @can('update admission')
                        <div class="">
                            <a href="{{route('listApplicant')}}" class="{{url()->current() == url()->route('listApplicant') ? 'bg-blue-100 text-white' : 'text-gray-300' }} cursor-pointer flex items-center  px-8 py-4 text-base font-medium leading-6 rounded-md focus:bg-blue-100 focus:text-white">
                                <svg class="mr-4 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" :class="{'hidden': navigationOpen === true}">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"  x-show="navigationOpen === true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="focus:text-white" :class="{'hidden': navigationOpen == true}">Admission</span>
                            </a >
                        </div>
                    @endcan

                    <div class="">
                        <button  class="cursor-pointer flex focus:outline-none items-center  px-8 py-4 text-base  font-medium leading-6 rounded-md  text-gray-300" x-on:click="isResultDropDownOpen = !isResultDropDownOpen">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-4 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" :class="{'hidden': navigationOpen === true}">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-show="navigationOpen === true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                            </svg>
                           <div class="flex items-center space-x-8" :class="{'hidden': navigationOpen === true}">
                            <span class="focus:text-white">Results</span>
                            <span class="">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform"
                                :class="{'rotate-180': isResultDropDownOpen}" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                              </svg>
                            </span>
                           </div>
                        </button >
                        <ul class="space-y-2" x-show="isResultDropDownOpen">
                            @can('read a c.a format')
                                <li>
                                    <a href="{{route('listCAStructure')}}" class="{{url()->current() == url()->route('listCAStructure') ? 'bg-blue-100 text-white' : 'text-gray-300' }} cursor-pointer flex items-center  px-8 py-4 text-base font-medium leading-6 rounded-md focus:bg-blue-100 focus:text-white">
                                        <span class="focus:text-white">Continuous Assessment Format</span>
                                    </a>
                                </li>
                            @endcan

                            @can('read an academic broadsheet')
                                <li>
                                    <a href="{{route('listAcademicBroadsheet')}}" class="{{url()->current() == url()->route('listAcademicBroadsheet') ? 'bg-blue-100 text-white' : 'text-gray-300' }} cursor-pointer flex items-center  px-8 py-4 text-base font-medium leading-6 rounded-md focus:bg-blue-100 focus:text-white">
                                        <span class="focus:text-white">Academic Broadsheet</span>
                                    </a>
                                </li>
                            @endcan

                            @can('read an academic result')
                                <li>
                                    <a href="{{route('listAcademicResult')}}" class="{{url()->current() == url()->route('listAcademicResult') ? 'bg-blue-100 text-white' : 'text-gray-300' }} cursor-pointer flex items-center  px-8 py-4 text-base font-medium leading-6 rounded-md focus:bg-blue-100 focus:text-white">
                                        <span class="focus:text-white">Academic Results</span>
                                    </a>
                                </li>
                            @endcan

                            @can('read an academic grading format')
                                <li>
                                    <a href="{{route('listGradeFormat')}}" class="{{url()->current() == url()->route('listGradeFormat') ? 'bg-blue-100 text-white' : 'text-gray-300' }} cursor-pointer flex items-center  px-8 py-4 text-base font-medium leading-6 rounded-md focus:bg-blue-100 focus:text-white">
                                        <span class="focus:text-white">Academic Grading Format</span>
                                    </a>
                                </li>
                            @endcan

                        </ul>
                    </div>

                    @can('read a user')
                        <div class="">
                            <button  class="cursor-pointer flex focus:outline-none items-center  px-8 py-4 text-base  font-medium leading-6 rounded-md  text-gray-300 " x-on:click="isUserDropDownOpen = !isUserDropDownOpen">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-4 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" :class="{'hidden': navigationOpen === true}">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-show="navigationOpen === true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div class="flex items-center space-x-8" :class="{'hidden': navigationOpen === true}">
                                <span class="focus:text-white">Users</span>
                                <span class=" ">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="ml-3 h-5 w-5 transform"
                                    :class="{'rotate-180': isUserDropDownOpen}" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                  </svg>
                                </span>
                               </div>
                            </button >
                            <ul class="space-y-2" x-show="isUserDropDownOpen">
                                <li>
                                    <a href="{{route('listTeacher')}}" class="{{url()->current() == url()->route('listTeacher') ? 'bg-blue-100 text-white' : 'text-gray-300' }} cursor-pointer flex items-center  px-8 py-4 text-base font-medium leading-6 rounded-md focus:bg-blue-100 focus:text-white">
                                        <span class="focus:text-white">Teacher</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('listStudent')}}" class="{{url()->current() == url()->route('listStudent') ? 'bg-blue-100 text-white' : 'text-gray-300' }} cursor-pointer flex items-center  px-8 py-4 text-base font-medium leading-6 rounded-md focus:bg-blue-100 focus:text-white">
                                        <span class="focus:text-white">Student</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('listParent')}}" class="{{url()->current() == url()->route('listParent') ? 'bg-blue-100 text-white' : 'text-gray-300' }} cursor-pointer flex items-center  px-8 py-4 text-base font-medium leading-6 rounded-md focus:bg-blue-100 focus:text-white">

                                        <span class="focus:text-white"></span> Parents
                                    </a>
                                </li>
                            </ul>
                        </div>
                    @endcan

                    @if(\App\Models\Tenant\Setting::isPaymentStatusOn())
                        @can('read a fee structure')
                            <div class="">
                                <a href="{{route('listFeeStructure')}}" class="{{url()->current() == url()->route('listFeeStructure') ? 'bg-blue-100 text-white' : 'text-gray-300' }} cursor-pointer flex items-center  px-8 py-4 text-base font-medium leading-6 rounded-md focus:bg-blue-100 focus:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-4 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" :class="{'hidden': navigationOpen === true}">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-show="navigationOpen === true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                    <span class="focus:text-white" :class="{'hidden': navigationOpen === true}">Payments/Bills</span>
                                </a >
                            </div>
                        @endcan
                    @endif

                    <div class="">
                        <a href="{{route('listSetting')}}" class="{{url()->current() == url()->route('listSetting') ? 'bg-blue-100 text-white' : 'text-gray-300' }} cursor-pointer flex items-center  px-8 py-4 text-base font-medium leading-6 rounded-md focus:bg-blue-100 focus:text-white" >
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-4 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" :class="{'hidden': navigationOpen === true}">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                              </svg>
                              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-show="navigationOpen === true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                              </svg>
                            <span class="focus:text-white" :class="{'hidden': navigationOpen === true}">Settings</span>
                        </a >
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
                        <form id="logout-form" action="{{route('logout')}}" method="POST">
                            @csrf
                        </form>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
<!-- Static sidebar for desktop -->

  {{-- Mobile Menu --}}
  <div class="md:hidden" x-data="{ isOpen: false }">
 <div class="border-b border-blue-100 shadow-lg">
    <div class="mx-4 my-4 flex items-center justify-between">
        <div class="text-blue-100 text-2xl font-bold">
           <a href=""> Scoolyn</a>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-100 " fill="none" viewBox="0 0 24 24" stroke="currentColor" x-on:click="isOpen=!isOpen" :class="{'hidden': isOpen === true}">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </div>
 </div>
  <div class="bg-gray-100 flex items-center" x-show="isOpen">

    <div class="fixed inset-0 flex z-40">
        <div class=" flex-1 flex flex-col max-w-xs w-full pt-5 pb-4 bg-white">
            <div class="absolute top-0 right-0 -mr-12 pt-2">
                <button class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none  focus:ring-inset focus:ring-white"  x-on:click="isOpen=!isOpen">
                    <span class="sr-only">Close sidebar</span>
                    <!-- Heroicon name: x -->
                    <svg class="h-6 w-6 text-blue-100" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class=" flex items-center justify-between mx-4">
            <div class="flex-shrink-0 text-blue-100 text-2xl font-bold px-4">
                <a href=""> Scoolyn</a>
            </div>
            <button x-on:click="isOpen=!isOpen">
            <svg class="h-6 w-6 text-blue-100" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
           </div>
            <div class="flex-shrink-0 px-4 py-4 mx-auto">
                <a href="#">
                    <img class="h-12 mx-auto" src="{{asset('images/pexels-teddy-joseph-2955375.png')}}" alt="">
                </a>
               <div class="text-lg text-center text-gray-200 pt-2">John Doe</div>
               <span class="text-base text-center mx-3 text-gray-300">SSS 1b</span>
            </div>
             <nav class="mt-8 flex-1 flex flex-col overflow-y-auto" aria-label="Sidebar">
                <div class="px-2 space-y-1 ">
                   <div class="" x-data="{ show: false }" >
                    <a href="{{route('dashboard')}}" class="{{url()->current() == url()->route('dashboard') ? 'bg-blue-100 text-white' : 'text-gray-300' }} cursor-pointer flex items-center  px-8 py-4 text-base font-medium leading-6 rounded-md focus:bg-blue-100 focus:text-white" x-on:click="show = !show">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-4 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                          </svg>
                       <span class="focus:text-white">Dashboard</span>
                    </a  >
                </div>

                    <div class="" x-data="{ show: false }">
                        <a href="{{route('listSubject')}}" class="{{url()->current() == url()->route('listSubject') ? 'bg-blue-100 text-white' : 'text-gray-300' }} cursor-pointer flex items-center  px-8 py-4 text-base font-medium leading-6 rounded-md focus:bg-blue-100 focus:text-white" x-on:click="show = !show">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-4 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                              </svg>
                           <span class="focus:text-white">Subject</span>
                        </a >
                    </div>

                    <div class="" x-data="{ show: false}">
                        <a href="{{route('listClass')}}" class="{{url()->current() == url()->route('listClass') ? 'bg-blue-100 text-white' : 'text-gray-300' }} cursor-pointer flex items-center  px-8 py-4 text-base font-medium leading-6 rounded-md focus:bg-blue-100 focus:text-white" x-on:click="show = !show">
                            <svg class="mr-4 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                           <span class="focus:text-white">Classes</span>
                        </a>
                    </div>

                    <div class="" x-data="{ show: false}">
                        <a href="#" class="cursor-pointer flex items-center  px-8 py-4 text-base  font-medium leading-6 rounded-md  text-gray-300" x-on:click="show = !show">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-4 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                              </svg>
                          <div class="flex items-center space-x-8" >
                                <span class="focus:text-white">Results</span>
                                <span class=" ">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="ml-8 h-5 w-5 transform"
                                    :class="{'rotate-180': show}" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                  </svg>
                                </span>
                               </div>
                        </a >
                          <ul class="space-y-2" x-show="show">
                         <li>
                                <a href="{{route('listCAStructure')}}" class="{{url()->current() == url()->route('listCAStructure') ? 'bg-blue-100 text-white' : 'text-gray-300' }} cursor-pointer flex items-center  px-8 py-4 text-base font-medium leading-6 rounded-md focus:bg-blue-100 focus:text-white">
                                    <span class="focus:text-white">Continuous Assessment Format</span>
                                </a>
                            </li>
                            <li>
                            <a href="{{route('listAcademicBroadsheet')}}" class="{{url()->current() == url()->route('listAcademicBroadsheet') ? 'bg-blue-100 text-white' : 'text-gray-300' }} cursor-pointer flex items-center  px-8 py-4 text-base font-medium leading-6 rounded-md focus:bg-blue-100 focus:text-white">Academic Broadsheet</span>
                              </a>
                          </li>
                            <li>
                              <a href="{{route('listAcademicResult')}}" class="{{url()->current() == url()->route('listAcademicResult') ? 'bg-blue-100 text-white' : 'text-gray-300' }} cursor-pointer flex items-center  px-8 py-4 text-base font-medium leading-6 rounded-md focus:bg-blue-100 focus:text-white">
                               <span class="focus:text-white">Academic Results</span>
                                </a>
                            </li>
                          </ul>
                    </div>

                    <div class="" x-data="{ show: false}">
                        <a href="#" class="cursor-pointer flex items-center  px-8 py-4 text-base  font-medium leading-6 rounded-md  text-gray-300" x-on:click="show = !show">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-4 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                              </svg>
                          <div class="flex items-center space-x-8" >
                                <span class="focus:text-white">Users</span>
                                <span class=" ">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="ml-11 h-5 w-5 transform"
                                    :class="{'rotate-180': show}" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                  </svg>
                                </span>
                               </div>
                        </a >
                          <ul class="space-y-2" x-show="show">
                         <li>
                                <a href="{{route('listTeacher')}}" class="{{url()->current() == url()->route('listTeacher') ? 'bg-blue-100 text-white' : 'text-gray-300' }} cursor-pointer flex items-center  px-8 py-4 text-base font-medium leading-6 rounded-md focus:bg-blue-100 focus:text-white">
                                    <span class="focus:text-white">Teacher</span>
                                </a>
                            </li>
                            <li>
                            <a href="{{route('listStudent')}}" class="{{url()->current() == url()->route('listStudent') ? 'bg-blue-100 text-white' : 'text-gray-300' }} cursor-pointer flex items-center  px-8 py-4 text-base font-medium leading-6 rounded-md focus:bg-blue-100 focus:text-white">Student</span>
                              </a>
                          </li>
                            <li>
                              <a href="{{route('listParent')}}" class="{{url()->current() == url()->route('listParent') ? 'bg-blue-100 text-white' : 'text-gray-300' }} cursor-pointer flex items-center  px-8 py-4 text-base font-medium leading-6 rounded-md focus:bg-blue-100 focus:text-white">
                               <span class="focus:text-white">Parents</span>
                                </a>
                            </li>
                          </ul>
                    </div>

                    <div class="" x-data="{ show: false }">
                        <a href="" class="cursor-pointer flex items-center  px-8 py-4 text-base leading-6 font-medium rounded-md text-gray-300 focus:bg-blue-100 focus:text-white" x-on:click="show = !show">
                              <svg xmlns="http://www.w3.org/2000/svg" class="mr-4 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                              </svg>
                            <span class="focus:text-white">Payments/Bills</span>
                        </a >
                    </div>

                    <div class="" x-data="{ show: false }">
                        <a href="" class="cursor-pointer flex items-center  px-8 py-4 text-base leading-6 font-medium rounded-md text-gray-300 focus:bg-blue-100 focus:text-white" x-on:click="show = !show" >
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-4 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                              </svg>
                            <span class="focus:text-white">Settings</span>
                        </a >
                    </div>
                </div>

                <div class="my-16 py-6 ">
                    <div class="px-2 space-y-1">
                        <a href="" class="cursor-pointer flex items-center   px-8 py-4 text-base leading-6 font-medium rounded-md text-gray-300 focus:bg-blue-100 focus:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-4 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                              </svg>
                            LogOut
                        </a >
                    </div>
                </div>
            </nav>
        </div>
        <div class="flex-shrink-0 w-14" aria-hidden="true">
        </div>
    </div>
</div>
</div>
{{-- /Mobile Menu --}}

