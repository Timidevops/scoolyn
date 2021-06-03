<div class="h-screen py-10" x-data="addStudent()">
<div class="bg-white rounded-md "  >
    <div class="flex justify-end px-4 py-4">
       <a href="http://app.scoolyn.com.test/uploadExcel" class="bg-blue-100 text-white rounded-md py-3 px-2 mx-2 md:w-1/5 text-sm">
     
              Upload Excel
        
      </a> 
    </div>
    <form>
        @csrf
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4">
        <div class="mt-2">
            <label for="First name" class="block text-sm font-normal text-gray-100">First name</label>
            <input type="text" name="" id="" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100" x-model="newTodo" ></div>

        <div class="mt-2">
            <label for="Second name" class="block text-sm font-normal text-gray-100">Last name</label>
            <input type="text" name="" id="" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100 "></div>

        <div class="mt-2">
            <label for="Email" class="block text-sm font-normal text-gray-100">Other Names</label>
            <input type="email" name="" id="" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100 "></div>

        <div class="mt-2 relative">
            <label for="Gender" class="block text-sm font-normal text-gray-100">Gender</label>
            <div class="relative inline-block w-full rounded-md ">
                <button type="button" class=" z-0 w-full py-2 pl-3 pr-10 text-left text-gray-100 font-normal border border-purple-100 rounded-md cursor-default focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5" x-text="selectGender.value" x-on:click="open = true">
                    <span class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 my-2 "  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                      </svg>
                      </span>
                </button>
            </div>
            <div  class="border border-purple-100 absolute w-full bg-white" x-show="open" @click.away="open = false">
                <ul class="py-1 overflow-auto h-32 text-base leading-6
                   shadow-xs max-h-60 focus:outline-none sm:text-sm sm:leading-5">
                    <template x-for="gender in genders" :key="gender">
                        <li @click.prevent="selectGender = gender; open = false" class="relative py-2 pl-3  text-gray-200 cursor-default select-none pr-9" :class="{ ' text-blue-100 hover:bg-purple-100': open == true}">
                            <p x-text="gender.value" class="inline-flex"></p>
                        </li>
                    </template>
                </ul>
            </div>
        </div>

        <div class="Birth Day">
            <label for="" class="block text-sm font-normal text-gray-100">Date of birth</label>
            <input type="date" name="" id="" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100 ">
        </div>

        <div class="mt-2">
            <label for="Address" class="block text-sm font-normal text-gray-100">Address</label>
            <input type="text" name="" id="" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100 "></div>

        <div class="mt-2 relative">
            <label for="Phone number" class="block text-sm font-normal text-gray-100">Class</label>
            <div class="relative inline-block w-full rounded-md ">
              <button type="button" class=" z-0 w-full py-2 pl-3 pr-10 text-left text-gray-100 font-normal border border-purple-100 rounded-md cursor-default focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5" x-text="selectCategory.value" x-on:click="classCategory = true">

                <span class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 my-2 "  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                  </svg>
                  </span>
              </button>
              </div>
              <div  class="border border-purple-100 absolute w-full bg-white">
              <div x-show="classCategory"  @click.away="classCategory = false">
             <div>
               <div class="flex items-center py-2 cursor-pointer" x-show="classCategory"  >
                <span class="mx-2">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-100 border border-green-100 rounded-full" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                  </svg>
              </span>
              <span class="text-xs font-normal text-gray-100" x-on:click="newCategory = !newCategory">Add new section</span>
            </div>
            <input type="text"  class="w-full py-2 text-xs px-2 text-gray-100" placeholder="Add a new class" x-show="newCategory">
          </div>
        </div>
              <ul class="py-1 overflow-auto h-32 text-base leading-6
               shadow-xs max-h-60 focus:outline-none sm:text-sm sm:leading-5" x-show="classCategory">
               <div class="py-2 cursor-pointer relative ">
                <input type="search" class="py-2 px-10 w-full text-xs font-normal text-gray-100" placeholder="Search">
                <span class="absolute inset-y-0 left-0 mx-2 my-4">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-100 bg-purple-100
                  rounded-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                  </svg>
                </span>
            </div>
                <template x-for="category in categories" :key="category">
              <li @click.prevent="selectCategory = category; classCategory = false" class="relative py-2 pl-3  text-gray-200 cursor-default select-none pr-9" :class="{ ' text-blue-100 hover:bg-purple-100': classCategory == true}">
             <p x-text="category.value" class="inline-flex"></p>
              </li>
                </template>
              </ul>
              </div>
            </div>

        <div class="mt-2 relative">
            <label for="Section" class="block text-sm font-normal text-gray-100">Section</label>
            <div class="relative inline-block w-full rounded-md ">
              <button type="button" class=" z-0 w-full py-2 pl-3 pr-10 text-left text-gray-100 font-normal border border-purple-100 rounded-md cursor-default focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5" x-text="selectSection.value" x-on:click="sectionCategory = true">

                <span class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 my-2 "  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                  </svg>
                  </span>
              </button>
              </div>
              <div  class="border border-purple-100 absolute w-full bg-white">
              <div x-show="sectionCategory"  @click.away="sectionCategory = false">
             <div>
               <div class="flex items-center py-2 cursor-pointer" x-show="sectionCategory"  >
                <span class="mx-2">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-100 border border-green-100 rounded-full" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                  </svg>
              </span>
              <span class="text-xs font-normal text-gray-100" x-on:click="newSection = !newSection">Add new section</span>
            </div>
            <input type="text"  class="w-full py-2 text-xs px-2 text-gray-100" placeholder="Add a new class" x-show="newSection">
          </div>
        </div>
              <ul class="py-1 overflow-auto h-32 text-base leading-6
               shadow-xs max-h-60 focus:outline-none sm:text-sm sm:leading-5" x-show="sectionCategory">
               <div class="py-2 cursor-pointer relative ">
                <input type="search" class="py-2 px-10 w-full text-xs font-normal text-gray-100" placeholder="Search">
                <span class="absolute inset-y-0 left-0 mx-2 my-4">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-100 bg-purple-100
                  rounded-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                  </svg>
                </span>
            </div>
                <template x-for="section in sections" :key="section">
              <li @click.prevent="selectSection = section; sectionCategory = false" class="relative py-2 pl-3  text-gray-200 cursor-default select-none pr-9" :class="{ ' text-blue-100 hover:bg-purple-100': sectionCategory == true}">
             <p x-text="section.value" class="inline-flex"></p>
              </li>
                </template>
              </ul>
              </div>
            </div>

        <div class="mt-2 relative">
            <label for="Select Parent" class="block text-sm font-normal text-gray-100">Select Parent</label>
            <div class="relative inline-block w-full rounded-md ">
              <button type="button" class=" z-0 w-full py-2 pl-3 pr-10 text-left text-gray-100 font-normal border border-purple-100 rounded-md cursor-default focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5" x-text="selectParent.value" x-on:click="show = true">
                <span class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 my-2 "  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                  </svg>
                  </span>
              </button>
              </div>
              <div  class="border border-purple-100 absolute w-full bg-white" x-show="show" @click.away="show = false">
                  <div class="flex items-center py-2 cursor-pointer"  >
                <span class="mx-2">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-100 border border-green-100 rounded-full" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                  </svg>
              </span>
                      <span class="text-xs font-normal text-gray-100">Add new parent</span>
                  </div>
              <ul class="py-1 overflow-auto h-32 text-base leading-6
               shadow-xs max-h-60 focus:outline-none sm:text-sm sm:leading-5">
                <template x-for="parent in parents" :key="parent">
              <li @click.prevent="selectParent = parent; show = false" class="relative py-2 pl-3  text-gray-200 cursor-default select-none pr-9" :class="{ ' text-blue-100 hover:bg-purple-100': show == true}">
             <p x-text="parent.full_name" class="inline-flex"></p>
              </li>
                </template>
              </ul>
              </div>
            </div>

      </div>
      <div class="px-4 py-4">
        <button type="submit" href="" class="bg-blue-100 text-white rounded-md py-3 px-2  md:w-1/5 text-sm" x-on:click="addToDo">
            Add student
        </button>
    </div>
</form>

</div>
</div>
<script>
    function addStudent() {
          return {
            show: false,
            open: false,
            sectionCategory: false,
            classCategory: false,
            newSection: false,
            newCategory: false,
// test
            newTodo: "", 
            todos: [], 
            addToDo() {
            this.todos.push({
                todo: this.newTodo,
                completed: false
            });

            this.newTodo = "";
        },
// test
              selectCategory: {
              value: "Select class "
                      },

                      selectSection: {
                      value: "Select section "
                              },

                          selectGender: {
                          value: "Select gender "
                                  },

                                  selectParent:{
                                    value: "Select parent "
                                  },
              categories:[
                      {
                      value:'Junior Secondary 1',
                      },
                      {
                      value:'Junior Secondary 2',
                      },
                      {
                      value:'Junior Secondary 3',
                      },
              ],
              sections:[
                      {
                      value:'A',
                      },
                      {
                      value:'B',
                      },
                      {
                      value:'C',
                      },
              ],
              genders:[
                      {
                      value:'Female',
                      },
                      {
                      value:'Male',
                      },
                      {
                      value:'Others',
                      },
              ],
              parents: {!! $parents !!},
                    };
                    }
</script>
