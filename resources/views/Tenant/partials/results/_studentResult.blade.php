<div class="py-2">
    <span class="block text-xl font-normal">Add Academic Grading Format</span>
  <span class="block font-medium text-gray-500">  Academic Grading Formats</span>
</div>
<form class="bg-white py-4">
    <div class="grid grid-cols-2 gap-2 lg:grid-cols-5 p-4">
        <button type="button" class="relative py-1 border border-purple-100 text-gray-100 rounded-md text-sm">
            Select Class
            <span class="absolute inset-y-0 right-0 mt-2 mr-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
              </svg>
            </span>
        </button>
        <button type="button" class="relative py-1 border border-purple-100 text-gray-100 rounded-md text-sm">
            Select Subject
            <span class="absolute inset-y-0 right-0 mt-2 mr-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
              </svg>
            </span>
        </button>
     
        
        </div>

        <div class="mt-8" x-data="results()">
            <div class="sm:block">
                <div class="max-w-6xl mx-auto  sm:px-6 ">
                    <div class="flex flex-col mt-2">
                        <div class="align-middle min-w-full overflow-x-auto  overflow-hidden ">
                            <table class="min-w-full divide-y  divide-purple-100">
                                <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-blue-100">
                                        Score from
                                    </th>
        
                                    <th class="px-6 py-3 text-left  font-medium text-blue-100 text-sm ">
                                        Score to
                                    </th>
                                    <th class="px-6 py-3 text-left  font-medium text-blue-100 text-sm">
                                        Grade
                                    </th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-blue-100">
                                        Grade Name
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                    <template x-for="(report, index) in studentReport" :key="report" class="bg-white ">
                                        <tr class="bg-white divide-y divide-purple-100"> 
                                            <td class="max-w-0  px-6 py-4 text-left whitespace-nowrap text-xs text-gray-900">
                                                <input id="name" type="text" class="text-gray-200 font-normal rounded-sm border-purple-100 py-1 w-24 focus:outline-none border" x-model="report.score_From" /> 
                                            </td>
                                            <td class="px-6 py-4 text-left whitespace-nowrap text-xs text-gray-200">
                                                <input id="name" type="text" class="text-gray-200 font-normal rounded-sm border-purple-100 py-1 w-24  focus:outline-none border"  x-model="report.score_To"/>
                                            </td>
                                            <td class="px-6 py-4 text-left whitespace-nowrap text-xs text-gray-200">
                                                <input id="name" type="text" class="text-gray-200 font-normal rounded-sm border-purple-100 py-1 w-24  focus:outline-none border"  x-model="report.grade"/>
                                            </td>
                                            <td class="px-6 py-4 text-left whitespace-nowrap text-xs text-gray-200">
                                                <input id="name" type="text" class="text-gray-200 font-normal rounded-sm border-purple-100 py-1 w-24 focus:outline-none border"  x-model="report.grade_Name"/>
                                            </td>
                                           
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <div class="flex justify-end mt-4">
                    <button class="py-2 px-4 bg-blue-100 text-white text-xs rounded font-light ">
                        Add new grade
                    </button>
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
                        score_From:'',
                        score_To:'',
                        grade:'',
                        grade_Name:''
                    },
                  
                ],
                
            }
        }
</script>