<form class="bg-white">
    <div class="grid grid-cols-2 gap-2 lg:grid-cols-5 p-4">
        <button type="button" class="relative py-1 border border-purple-100 text-gray-100 rounded-md text-sm">
            Select Exam
            <span class="absolute inset-y-0 right-0 mt-2 mr-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
              </svg>
            </span>
        </button>
        <button type="button" class="relative py-1 border border-purple-100 text-gray-100 rounded-md text-sm">
            Select Class
            <span class="absolute inset-y-0 right-0 mt-2 mr-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
              </svg>
            </span>
        </button>
        <button type="button" class="relative py-1 border border-purple-100 text-gray-100 rounded-md text-sm">
            Select Section
            <span class="absolute inset-y-0 right-0 mt-2 mr-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
              </svg>
            </span>
        </button>
        <button type="button" class="relative py-1 px-2 border border-purple-100 text-gray-100 rounded-md text-sm">
            Select Subject
            <span class="absolute inset-y-0 right-0 mt-2 mr-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
              </svg>
            </span>
        </button>
        <button type="button" class="py-1 border border-purple-100 text-white rounded-md bg-blue-100 text-sm">Filter</button>
        
        </div>

        <div class="mt-8" x-data="results()">
            <div class="sm:block">
                <div class="max-w-6xl mx-auto  sm:px-6 ">
                    <div class="flex flex-col mt-2">
                        <div class="align-middle min-w-full overflow-x-auto  overflow-hidden ">
                            <table class="min-w-full divide-y  divide-purple-100">
                                <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">
                                        Name
                                    </th>
        
                                    <th class="px-6 py-3 text-left  font-medium text-gray-500 text-sm ">
                                        CA Test
                                    </th>
                                    <th class="px-6 py-3 text-left  font-medium text-gray-500 text-sm">
                                        Exam
                                    </th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">
                                        Grade
                                    </th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">
                                       Action
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                    <template x-for="(report, index) in studentReport" :key="report" class="bg-white divide-y divide-primary">
                                        <tr class="bg-white"> 
                                            <td class="max-w-0  px-6 py-4 text-left whitespace-nowrap text-xs text-gray-900">
                                                <input id="name" type="text" class="text-gray-200 font-normal w-24 focus:outline-none" x-model="report.name" /> 
                                            </td>
                                            <td class="px-6 py-4 text-left whitespace-nowrap text-xs text-gray-200">
                                                <input id="name" type="text" class="text-gray-200 font-normal w-10 focus:outline-none"  x-model="report.test"/>
                                            </td>
                                            <td class="px-6 py-4 text-left whitespace-nowrap text-xs text-gray-200">
                                                <input id="name" type="text" class="text-gray-200 font-normal w-10 focus:outline-none"  x-model="report.exam"/>
                                            </td>
                                            <td class="px-6 py-4 text-left whitespace-nowrap text-xs text-gray-200">
                                                <input id="name" type="text" class="text-gray-200 font-normal w-10 focus:outline-none"  x-model="report.grade"/>
                                            </td>
                                            <td class="md:px-6 py-4 text-left whitespace-nowrap text-sm text-gray-200">
                                                <button class="focus:outline-none" type="submit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-100" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                      </svg>
                                                </button>
                                               
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</form>

<script>
function results() {
            return {
                studentReport:[
                   {
                        name:'',
                        test:'',
                        exam:'',
                        grade:''
                    },
                  
                ],
                
            }
        }
</script>