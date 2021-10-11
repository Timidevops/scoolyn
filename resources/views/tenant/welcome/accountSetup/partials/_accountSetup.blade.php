<div class="mt-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
      <h2 class="block text-2xl leading-6 font-medium text-gray-900 capitalize">
        Hello, John Doe
      </h2>
      <span class="block text-base text-gray-100 font-light">
        Kindly complete your account setup.
      </span>
         
            {{-- <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                <div class="bg-purple-300 overflow-hidden rounded-lg ">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 text-3xl font-light text-blue-100">
                                
                            </div>

                            <div class="ml-5 w-0 flex-1">

                                <dl>
                                    <dt class="text-xs font-light text-gray-300 truncate">
                                        Updated 22.04.2021
                                    </dt>
                                    <dd>
                                        <div class="text-lg font-medium text-gray-900">
                                            Student
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-red-200 overflow-hidden rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 text-3xl font-light text-blue-100">
                                
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-xs font-light text-gray-500 truncate">
                                        Updated 22.04.2021
                                    </dt>
                                    <dd>
                                        <div class="text-lg font-medium text-gray-900">
                                            Teacher
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-200 overflow-hidden rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 text-3xl font-light text-blue-100">
                               
                                
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-xs font-light text-gray-500 truncate">
                                        Updated 22.04.2021
                                    </dt>
                                    <dd>
                                        <div class="text-lg font-medium text-gray-900">
                                            Parent
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  --}}
        <div class="mt-4" x-data="timeTable()"> 
            <div class="bg-white px-6 py-8 rounded-md">  
                    <ul class="space-y-4 text-gray-300 medium text-base" >
                        {{-- <template x-for="item in timeTable" :key="item"> --}}
                        <li class="flex items-center space-x-4 ">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" :class="{'text-green-200': Open==true}" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                              </svg>
                            </div>
                            <div>Go to settings and complete your account details</div> 
                        </li>
                        <li class="flex items-center space-x-4 ">
                            <div> 
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                              </svg>
                            </div>
                            <div>Go to settings and complete your account details</div> 
                        </li>
                        <li class="flex items-center space-x-4 ">
                            <div> 
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                              </svg>
                            </div>
                            <div>Go to settings and complete your account details</div> 
                        </li>
                        {{-- </template> --}}
                    </ul>
                    <div class="space-x-2 relative flex justify-end text-gray-300">
                       <span class="pr-10 py-1"> Not now</span>
                        <span class="absolute px-6 pt-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                          </svg>
                        </span>
                    </div>
            </div>
        </div>



    </div>
</div>

 
