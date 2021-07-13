<div class="mt-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
      <h2 class="block text-2xl leading-6 font-medium text-gray-900">Hello, John Doe</h2>
      <span class="block text-base text-gray-100 font-light">
          Look up your school's info.
      </span>
      <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
        <div class="bg-white overflow-hidden rounded-lg">
          <div class="p-5">
            <div class="flex items-center">
              <div class="flex-shrink-0 text-3xl font-light">
                14
              </div>
            
              <div class="ml-5 w-0 flex-1">
                 
                <dl>
                  <dt class="text-xs font-medium text-gray-500 truncate">
                    Update
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

        <div class="bg-white overflow-hidden rounded-lg">
            <div class="p-5">
              <div class="flex items-center">
                <div class="flex-shrink-0 text-3xl font-light">
                  14
                </div>
                <div class="ml-5 w-0 flex-1">
                  <dl>
                    <dt class="text-xs font-medium text-gray-500 truncate">
                        Update
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

          <div class="bg-white overflow-hidden rounded-lg">
            <div class="p-5">
              <div class="flex items-center">
                <div class="flex-shrink-0 text-3xl font-light">
                    14
                </div>
                <div class="ml-5 w-0 flex-1">
                  <dl>
                    <dt class="text-xs font-medium text-gray-500 truncate">
                      Update
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
      </div>
        <div class="mt-4" x-data="{
            Table: [
               { date: '8am', subject: 'Maths' },
              { date: '9am', subject: 'English' },
              { date: '10am', subject: 'Science' },
              { date: '11am', subject: 'Break Time' },
              { date: '12pm', subject: 'Computer' },
              { date: '1pm', subject: 'Computer' },
              { date: '2pm', subject: 'Computer' },
              { date: '3pm', subject: 'Computer' },
              { date: '4pm', subject: 'Computer' },
            ]
          }">
            Time Table
            <div class="bg-white px-4 py-4 rounded">
                <span>Tuesday, 23 day</span>

                <div>
                    <ul class="" >
                        <template x-for="(time, index) in Table" :key="time">
                        <li >
                            <span x-text="time.date" class="block"></span>
                         <div class="flex flex-row space-x-2">
                             <img src="/images/Group 172.svg" alt="Group 172"> 
                             <div class="flex items-center space-x-4 bg-purple-100 px-2 py-2 rounded">
                                 <img src="/images/Line 14.svg" alt="line">
                                 <span x-text="time.subject" class="text-xs"></span>
                                </div>
                            </div>  
                        </li>
                        </template>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- <script>
    function timeTable() {
                return {
                    Table:[
                       {
                            score_From:'8am',
                          
                        },
                      
                    ],
                    
                }
            }
    </script> --}}