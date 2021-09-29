<!-- Static sidebar for desktop -->
<div class="hidden md:flex md:flex-shrink-0 max-h-screen" x-data="{navigationOpen: false, isUserDropDownOpen: false, isResultDropDownOpen: false,}" >
    <div class="flex flex-col bg-white  w-auto">
        <button type="button" class="p-2 flex ml-auto bg-blue-100 text-white focus:outline-none"
        x-on:click="navigationOpen = !navigationOpen">
            <svg class="w-6 h-6" :class="{'transform rotate-180': navigationOpen === false}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
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
                                <svg :class="{'hidden': navigationOpen === true}" class="mr-4 h-6 w-6" stroke="currentColor" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                     viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                            <path d="M486.4,256h-8.533V51.2h8.533c14.138,0,25.6-11.462,25.6-25.6S500.539,0,486.4,0H25.6C11.461,0,0,11.461,0,25.6
                                                s11.461,25.6,25.6,25.6h8.533V256H25.6C11.461,256,0,267.462,0,281.6c0,14.138,11.461,25.6,25.6,25.6h460.8
                                                c14.138,0,25.6-11.462,25.6-25.6C512,267.462,500.539,256,486.4,256z M25.6,34.133c-4.71-0.006-8.527-3.823-8.533-8.533
                                                c0.006-4.71,3.823-8.527,8.533-8.533h460.8c4.713,0,8.533,3.82,8.533,8.533s-3.82,8.533-8.533,8.533H25.6z M460.8,51.2V256H51.2
                                                V51.2H460.8z M486.4,290.133H25.6c-4.713,0-8.533-3.82-8.533-8.533s3.82-8.533,8.533-8.533h460.8
                                                c4.71,0.006,8.527,3.823,8.533,8.533C494.927,286.31,491.11,290.127,486.4,290.133z"/>
                                    <path d="M145.067,195.696c4.713,0,8.533-3.821,8.533-8.533v-41.776l25.6,10.878v50.922l0.019,0.093
                                                c0.01,1.084,0.227,2.156,0.638,3.158c0.587,0.92,1.189,1.829,1.807,2.729c0.787,0.805,1.727,1.446,2.763,1.886l42.432,18.017
                                                c18.652,7.852,39.683,7.844,58.329-0.021l42.386-17.997c1.036-0.44,1.976-1.081,2.763-1.886c0.618-0.899,1.22-1.809,1.807-2.729
                                                c0.412-1.003,0.628-2.075,0.638-3.158l0.018-0.093v-50.922l33.796-14.362c5.41-2.514,8.871-7.938,8.871-13.904
                                                c0-5.966-3.461-11.39-8.871-13.904l-105.3-44.745c-3.383-1.45-7.213-1.45-10.596,0l-105.296,44.745
                                                c-5.48,2.434-8.973,7.909-8.871,13.904v59.163C136.534,191.875,140.354,195.696,145.067,195.696z M315.733,201.541l-37.167,15.78
                                                c-14.414,6.073-30.668,6.081-45.088,0.021l-37.213-15.801v-38.023l54.438,23.132c3.383,1.45,7.213,1.45,10.596,0l54.433-23.132
                                                V201.541z M256,85.641L355.675,128l-34.69,14.742l-0.075,0.032L256,170.358l-64.91-27.584l-0.075-0.032L156.325,128L256,85.641z"
                                    />
                                    <path d="M494.933,460.8h-17.067v-10.971c-0.219-21.605-12.617-41.235-32.031-50.716c13.592-11.603,18.513-30.447,12.329-47.214
                                                c-6.183-16.767-22.161-27.904-40.032-27.904s-33.849,11.137-40.032,27.904c-6.183,16.767-1.263,35.611,12.329,47.214
                                                c-19.414,9.482-31.812,29.111-32.031,50.716V460.8h-42.667v-10.971c-0.219-21.605-12.617-41.235-32.031-50.716
                                                c13.592-11.603,18.513-30.447,12.329-47.214c-6.183-16.767-22.161-27.904-40.032-27.904c-17.871,0-33.849,11.137-40.032,27.904
                                                c-6.183,16.767-1.263,35.611,12.329,47.214c-19.414,9.482-31.812,29.111-32.031,50.716V460.8H153.6v-10.971
                                                c-0.219-21.605-12.617-41.235-32.031-50.716c13.592-11.603,18.513-30.447,12.329-47.214
                                                c-6.183-16.767-22.161-27.904-40.032-27.904c-17.871,0-33.849,11.137-40.032,27.904c-6.183,16.767-1.263,35.611,12.329,47.214
                                                c-19.414,9.482-31.812,29.111-32.031,50.716V460.8H17.067C7.645,460.809,0.009,468.445,0,477.867v17.067
                                                c0.009,9.422,7.645,17.057,17.067,17.067h477.867c9.422-0.009,17.057-7.645,17.067-17.067v-17.067
                                                C511.991,468.445,504.355,460.809,494.933,460.8z M418.133,341.333c14.138,0,25.6,11.461,25.6,25.6s-11.461,25.6-25.6,25.6
                                                c-14.132-0.015-25.585-11.468-25.6-25.6C392.533,352.795,403.995,341.333,418.133,341.333z M375.467,449.829
                                                c1.329-22.591,20.037-40.23,42.667-40.23s41.337,17.639,42.667,40.23V460.8h-85.333V449.829z M256,341.333
                                                c14.138,0,25.6,11.461,25.6,25.6s-11.462,25.6-25.6,25.6c-14.132-0.015-25.585-11.468-25.6-25.6
                                                C230.4,352.795,241.862,341.333,256,341.333z M213.333,449.829c1.329-22.591,20.037-40.23,42.667-40.23
                                                s41.337,17.639,42.667,40.23V460.8h-85.333V449.829z M93.867,341.333c14.138,0,25.6,11.461,25.6,25.6s-11.461,25.6-25.6,25.6
                                                c-14.132-0.015-25.585-11.468-25.6-25.6C68.267,352.795,79.728,341.333,93.867,341.333z M51.2,449.829
                                                c0.718-22.871,19.793-40.856,42.667-40.229c22.873-0.627,41.948,17.358,42.667,40.229V460.8H51.2V449.829z M17.067,494.933
                                                v-17.067h477.867l0.012,17.067H17.067z"/>

                                </svg>
                                <svg x-show="navigationOpen === true" class="h-6 w-6" stroke="currentColor" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                     viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                            <path d="M486.4,256h-8.533V51.2h8.533c14.138,0,25.6-11.462,25.6-25.6S500.539,0,486.4,0H25.6C11.461,0,0,11.461,0,25.6
                                                s11.461,25.6,25.6,25.6h8.533V256H25.6C11.461,256,0,267.462,0,281.6c0,14.138,11.461,25.6,25.6,25.6h460.8
                                                c14.138,0,25.6-11.462,25.6-25.6C512,267.462,500.539,256,486.4,256z M25.6,34.133c-4.71-0.006-8.527-3.823-8.533-8.533
                                                c0.006-4.71,3.823-8.527,8.533-8.533h460.8c4.713,0,8.533,3.82,8.533,8.533s-3.82,8.533-8.533,8.533H25.6z M460.8,51.2V256H51.2
                                                V51.2H460.8z M486.4,290.133H25.6c-4.713,0-8.533-3.82-8.533-8.533s3.82-8.533,8.533-8.533h460.8
                                                c4.71,0.006,8.527,3.823,8.533,8.533C494.927,286.31,491.11,290.127,486.4,290.133z"/>
                                            <path d="M145.067,195.696c4.713,0,8.533-3.821,8.533-8.533v-41.776l25.6,10.878v50.922l0.019,0.093
                                                c0.01,1.084,0.227,2.156,0.638,3.158c0.587,0.92,1.189,1.829,1.807,2.729c0.787,0.805,1.727,1.446,2.763,1.886l42.432,18.017
                                                c18.652,7.852,39.683,7.844,58.329-0.021l42.386-17.997c1.036-0.44,1.976-1.081,2.763-1.886c0.618-0.899,1.22-1.809,1.807-2.729
                                                c0.412-1.003,0.628-2.075,0.638-3.158l0.018-0.093v-50.922l33.796-14.362c5.41-2.514,8.871-7.938,8.871-13.904
                                                c0-5.966-3.461-11.39-8.871-13.904l-105.3-44.745c-3.383-1.45-7.213-1.45-10.596,0l-105.296,44.745
                                                c-5.48,2.434-8.973,7.909-8.871,13.904v59.163C136.534,191.875,140.354,195.696,145.067,195.696z M315.733,201.541l-37.167,15.78
                                                c-14.414,6.073-30.668,6.081-45.088,0.021l-37.213-15.801v-38.023l54.438,23.132c3.383,1.45,7.213,1.45,10.596,0l54.433-23.132
                                                V201.541z M256,85.641L355.675,128l-34.69,14.742l-0.075,0.032L256,170.358l-64.91-27.584l-0.075-0.032L156.325,128L256,85.641z"
                                            />
                                            <path d="M494.933,460.8h-17.067v-10.971c-0.219-21.605-12.617-41.235-32.031-50.716c13.592-11.603,18.513-30.447,12.329-47.214
                                                c-6.183-16.767-22.161-27.904-40.032-27.904s-33.849,11.137-40.032,27.904c-6.183,16.767-1.263,35.611,12.329,47.214
                                                c-19.414,9.482-31.812,29.111-32.031,50.716V460.8h-42.667v-10.971c-0.219-21.605-12.617-41.235-32.031-50.716
                                                c13.592-11.603,18.513-30.447,12.329-47.214c-6.183-16.767-22.161-27.904-40.032-27.904c-17.871,0-33.849,11.137-40.032,27.904
                                                c-6.183,16.767-1.263,35.611,12.329,47.214c-19.414,9.482-31.812,29.111-32.031,50.716V460.8H153.6v-10.971
                                                c-0.219-21.605-12.617-41.235-32.031-50.716c13.592-11.603,18.513-30.447,12.329-47.214
                                                c-6.183-16.767-22.161-27.904-40.032-27.904c-17.871,0-33.849,11.137-40.032,27.904c-6.183,16.767-1.263,35.611,12.329,47.214
                                                c-19.414,9.482-31.812,29.111-32.031,50.716V460.8H17.067C7.645,460.809,0.009,468.445,0,477.867v17.067
                                                c0.009,9.422,7.645,17.057,17.067,17.067h477.867c9.422-0.009,17.057-7.645,17.067-17.067v-17.067
                                                C511.991,468.445,504.355,460.809,494.933,460.8z M418.133,341.333c14.138,0,25.6,11.461,25.6,25.6s-11.461,25.6-25.6,25.6
                                                c-14.132-0.015-25.585-11.468-25.6-25.6C392.533,352.795,403.995,341.333,418.133,341.333z M375.467,449.829
                                                c1.329-22.591,20.037-40.23,42.667-40.23s41.337,17.639,42.667,40.23V460.8h-85.333V449.829z M256,341.333
                                                c14.138,0,25.6,11.461,25.6,25.6s-11.462,25.6-25.6,25.6c-14.132-0.015-25.585-11.468-25.6-25.6
                                                C230.4,352.795,241.862,341.333,256,341.333z M213.333,449.829c1.329-22.591,20.037-40.23,42.667-40.23
                                                s41.337,17.639,42.667,40.23V460.8h-85.333V449.829z M93.867,341.333c14.138,0,25.6,11.461,25.6,25.6s-11.461,25.6-25.6,25.6
                                                c-14.132-0.015-25.585-11.468-25.6-25.6C68.267,352.795,79.728,341.333,93.867,341.333z M51.2,449.829
                                                c0.718-22.871,19.793-40.856,42.667-40.229c22.873-0.627,41.948,17.358,42.667,40.229V460.8H51.2V449.829z M17.067,494.933
                                                v-17.067h477.867l0.012,17.067H17.067z"/>

                                </svg>
                                <span class="focus:text-white" :class="{'hidden': navigationOpen == true}">Classes</span>
                            </a >
                        </div>
                    @endcan

                    @if(\App\Models\Landlord\FeatureChecker::hasAdmissionAutomationFeature())
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
                    @endif

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
                                @can('read admin user')
                                    <li>
                                        <a href="{{route('listAdminUser')}}" class="{{url()->current() == url()->route('listTeacher') ? 'bg-blue-100 text-white' : 'text-gray-300' }} cursor-pointer flex items-center  px-8 py-4 text-base font-medium leading-6 rounded-md focus:bg-blue-100 focus:text-white">
                                            <span class="focus:text-white">Admin</span>
                                        </a>
                                    </li>
                                @endcan
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

            </div>
            <button x-on:click="isOpen=!isOpen">
            <svg class="h-6 w-6 text-blue-100" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
           </div>
            <div class="flex-shrink-0 px-4 py-2 mx-auto">
                <a href="">
                    <img class="h-12 mx-auto" src="{{asset('images/pexels-teddy-joseph-2955375.png')}}" alt="">
                </a>
                <div class="text-lg text-center text-gray-200 pt-2">
                    <p class="capitalize">{{Auth::user()->getUserFullName()}}</p>
                </div>
            </div>
             <nav class="mt-8 flex-1 flex flex-col overflow-y-auto" aria-label="Sidebar">
                <div class="px-2 space-y-1 ">
                   <div class="" x-data="{ show: false }" >
                    <a href="{{route('dashboard')}}" class="{{url()->current() == url()->route('dashboard') ? 'bg-blue-100 text-white' : 'text-gray-300' }} cursor-pointer flex items-center  px-8 py-4 text-base font-medium leading-6 rounded-md focus:bg-blue-100 focus:text-white" x-on:click="show = !show">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-4 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                          </svg>
                       <span class="focus:text-white">Dashboard</span>
                    </a>
                </div>

                    @can('read a subject')
                        <div class="" x-data="{ show: false }">
                        <a href="{{route('listSubject')}}" class="{{url()->current() == url()->route('listSubject') ? 'bg-blue-100 text-white' : 'text-gray-300' }} cursor-pointer flex items-center  px-8 py-4 text-base font-medium leading-6 rounded-md focus:bg-blue-100 focus:text-white" x-on:click="show = !show">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-4 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                              </svg>
                           <span class="focus:text-white">Subject</span>
                        </a >
                    </div>
                    @endcan

                    @can('read a class arm')
                        <div class="" x-data="{ show: false}">
                        <a href="{{route('listClass')}}" class="{{url()->current() == url()->route('listClass') ? 'bg-blue-100 text-white' : 'text-gray-300' }} cursor-pointer flex items-center  px-8 py-4 text-base font-medium leading-6 rounded-md focus:bg-blue-100 focus:text-white" x-on:click="show = !show">
                            <svg class="mr-4 h-6 w-6" stroke="currentColor" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                 viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                            <path d="M486.4,256h-8.533V51.2h8.533c14.138,0,25.6-11.462,25.6-25.6S500.539,0,486.4,0H25.6C11.461,0,0,11.461,0,25.6
                                                s11.461,25.6,25.6,25.6h8.533V256H25.6C11.461,256,0,267.462,0,281.6c0,14.138,11.461,25.6,25.6,25.6h460.8
                                                c14.138,0,25.6-11.462,25.6-25.6C512,267.462,500.539,256,486.4,256z M25.6,34.133c-4.71-0.006-8.527-3.823-8.533-8.533
                                                c0.006-4.71,3.823-8.527,8.533-8.533h460.8c4.713,0,8.533,3.82,8.533,8.533s-3.82,8.533-8.533,8.533H25.6z M460.8,51.2V256H51.2
                                                V51.2H460.8z M486.4,290.133H25.6c-4.713,0-8.533-3.82-8.533-8.533s3.82-8.533,8.533-8.533h460.8
                                                c4.71,0.006,8.527,3.823,8.533,8.533C494.927,286.31,491.11,290.127,486.4,290.133z"/>
                                <path d="M145.067,195.696c4.713,0,8.533-3.821,8.533-8.533v-41.776l25.6,10.878v50.922l0.019,0.093
                                                c0.01,1.084,0.227,2.156,0.638,3.158c0.587,0.92,1.189,1.829,1.807,2.729c0.787,0.805,1.727,1.446,2.763,1.886l42.432,18.017
                                                c18.652,7.852,39.683,7.844,58.329-0.021l42.386-17.997c1.036-0.44,1.976-1.081,2.763-1.886c0.618-0.899,1.22-1.809,1.807-2.729
                                                c0.412-1.003,0.628-2.075,0.638-3.158l0.018-0.093v-50.922l33.796-14.362c5.41-2.514,8.871-7.938,8.871-13.904
                                                c0-5.966-3.461-11.39-8.871-13.904l-105.3-44.745c-3.383-1.45-7.213-1.45-10.596,0l-105.296,44.745
                                                c-5.48,2.434-8.973,7.909-8.871,13.904v59.163C136.534,191.875,140.354,195.696,145.067,195.696z M315.733,201.541l-37.167,15.78
                                                c-14.414,6.073-30.668,6.081-45.088,0.021l-37.213-15.801v-38.023l54.438,23.132c3.383,1.45,7.213,1.45,10.596,0l54.433-23.132
                                                V201.541z M256,85.641L355.675,128l-34.69,14.742l-0.075,0.032L256,170.358l-64.91-27.584l-0.075-0.032L156.325,128L256,85.641z"
                                />
                                <path d="M494.933,460.8h-17.067v-10.971c-0.219-21.605-12.617-41.235-32.031-50.716c13.592-11.603,18.513-30.447,12.329-47.214
                                                c-6.183-16.767-22.161-27.904-40.032-27.904s-33.849,11.137-40.032,27.904c-6.183,16.767-1.263,35.611,12.329,47.214
                                                c-19.414,9.482-31.812,29.111-32.031,50.716V460.8h-42.667v-10.971c-0.219-21.605-12.617-41.235-32.031-50.716
                                                c13.592-11.603,18.513-30.447,12.329-47.214c-6.183-16.767-22.161-27.904-40.032-27.904c-17.871,0-33.849,11.137-40.032,27.904
                                                c-6.183,16.767-1.263,35.611,12.329,47.214c-19.414,9.482-31.812,29.111-32.031,50.716V460.8H153.6v-10.971
                                                c-0.219-21.605-12.617-41.235-32.031-50.716c13.592-11.603,18.513-30.447,12.329-47.214
                                                c-6.183-16.767-22.161-27.904-40.032-27.904c-17.871,0-33.849,11.137-40.032,27.904c-6.183,16.767-1.263,35.611,12.329,47.214
                                                c-19.414,9.482-31.812,29.111-32.031,50.716V460.8H17.067C7.645,460.809,0.009,468.445,0,477.867v17.067
                                                c0.009,9.422,7.645,17.057,17.067,17.067h477.867c9.422-0.009,17.057-7.645,17.067-17.067v-17.067
                                                C511.991,468.445,504.355,460.809,494.933,460.8z M418.133,341.333c14.138,0,25.6,11.461,25.6,25.6s-11.461,25.6-25.6,25.6
                                                c-14.132-0.015-25.585-11.468-25.6-25.6C392.533,352.795,403.995,341.333,418.133,341.333z M375.467,449.829
                                                c1.329-22.591,20.037-40.23,42.667-40.23s41.337,17.639,42.667,40.23V460.8h-85.333V449.829z M256,341.333
                                                c14.138,0,25.6,11.461,25.6,25.6s-11.462,25.6-25.6,25.6c-14.132-0.015-25.585-11.468-25.6-25.6
                                                C230.4,352.795,241.862,341.333,256,341.333z M213.333,449.829c1.329-22.591,20.037-40.23,42.667-40.23
                                                s41.337,17.639,42.667,40.23V460.8h-85.333V449.829z M93.867,341.333c14.138,0,25.6,11.461,25.6,25.6s-11.461,25.6-25.6,25.6
                                                c-14.132-0.015-25.585-11.468-25.6-25.6C68.267,352.795,79.728,341.333,93.867,341.333z M51.2,449.829
                                                c0.718-22.871,19.793-40.856,42.667-40.229c22.873-0.627,41.948,17.358,42.667,40.229V460.8H51.2V449.829z M17.067,494.933
                                                v-17.067h477.867l0.012,17.067H17.067z"/>

                                </svg>
                           <span class="focus:text-white">Classes</span>
                        </a>
                    </div>
                    @endcan

                    @if(\App\Models\Landlord\FeatureChecker::hasAdmissionAutomationFeature())
                        @can('update admission')
                        <div class="" x-data="{ show: false}">
                            <a href="{{route('listApplicant')}}" class="{{url()->current() == url()->route('listApplicant') ? 'bg-blue-100 text-white' : 'text-gray-300' }} cursor-pointer flex items-center  px-8 py-4 text-base font-medium leading-6 rounded-md focus:bg-blue-100 focus:text-white" x-on:click="show = !show">
                                <svg class="mr-4 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="focus:text-white">Admission</span>
                            </a>
                        </div>
                    @endcan
                    @endif

                    <div class="" x-data="{ show: false}">
                        <div class="cursor-pointer flex items-center  px-8 py-4 text-base  font-medium leading-6 rounded-md  text-gray-300" x-on:click="show = !show">
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
                        </div>
                        <ul class="space-y-2" x-show="show">
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
                        <div class="" x-data="{ show: false}">
                        <div class="cursor-pointer flex items-center  px-8 py-4 text-base  font-medium leading-6 rounded-md  text-gray-300" x-on:click="show = !show">
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
                        </div>
                          <ul class="space-y-2" x-show="show">
                            <li>
                                <a href="{{route('listTeacher')}}" class="{{url()->current() == url()->route('listTeacher') ? 'bg-blue-100 text-white' : 'text-gray-300' }} cursor-pointer flex items-center  px-8 py-4 text-base font-medium leading-6 rounded-md focus:bg-blue-100 focus:text-white">
                                    <span class="focus:text-white">Teacher</span>
                                </a>
                            </li>
                            <li>
                            <a href="{{route('listStudent')}}" class="{{url()->current() == url()->route('listStudent') ? 'bg-blue-100 text-white' : 'text-gray-300' }} cursor-pointer flex items-center  px-8 py-4 text-base font-medium leading-6 rounded-md focus:bg-blue-100 focus:text-white">
                                <span>Student</span>
                              </a>
                          </li>
                            <li>
                              <a href="{{route('listParent')}}" class="{{url()->current() == url()->route('listParent') ? 'bg-blue-100 text-white' : 'text-gray-300' }} cursor-pointer flex items-center  px-8 py-4 text-base font-medium leading-6 rounded-md focus:bg-blue-100 focus:text-white">
                               <span class="focus:text-white">Parents</span>
                                </a>
                            </li>
                              @can('read admin user')
                                  <li>
                                      <a href="{{route('listAdminUser')}}" class="{{url()->current() == url()->route('listTeacher') ? 'bg-blue-100 text-white' : 'text-gray-300' }} cursor-pointer flex items-center  px-8 py-4 text-base font-medium leading-6 rounded-md focus:bg-blue-100 focus:text-white">
                                          <span class="focus:text-white">Admin</span>
                                      </a>
                                  </li>
                              @endcan
                          </ul>
                    </div>
                    @endcan

                    @if(\App\Models\Tenant\Setting::isPaymentStatusOn())
                        @can('read a fee structure')
                            <div class="" x-data="{ show: false }">
                        <a href="{{route('listFeeStructure')}}" class="cursor-pointer flex items-center  px-8 py-4 text-base leading-6 font-medium rounded-md text-gray-300 focus:bg-blue-100 focus:text-white" x-on:click="show = !show">
                              <svg xmlns="http://www.w3.org/2000/svg" class="mr-4 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                              </svg>
                            <span class="focus:text-white">Payments/Bills</span>
                        </a >
                    </div>
                        @endcan
                    @endif

                    <div>
                        <a href="{{route('listSetting')}}" class="{{url()->current() == url()->route('listSetting') ? 'bg-blue-100 text-white' : 'text-gray-300' }} cursor-pointer flex items-center  px-8 py-4 text-base leading-6 font-medium rounded-md focus:bg-blue-100 focus:text-white">
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
                        <p onclick=" return document.getElementById('logout-form').submit()" class="cursor-pointer flex items-center   px-8 py-4 text-base leading-6 font-medium rounded-md text-gray-300 focus:bg-blue-100 focus:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-4 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                              </svg>
                            LogOut
                        </p >
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


<form id="logout-form" action="{{route('logout')}}" method="POST">
    @csrf
</form>
