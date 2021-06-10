<form wire:submit.prevent="store" class="overflow-auto" style="background-color:rgba(190,192,201,0.7);" x-show="showModal" :class="{ 'absolute inset-0 z-10 flex items-center justify-center': showModal }">
    @csrf

    <div class="mt-12 sm:mx-auto sm:w-full sm:max-w-md md:max-w-md  bg-white rounded-lg shadow-md">
        <div class="flex items-center justify-between mt-3 text-gray-200 text-base mx-4 ">
            <div class="block">
                <span> Create Class</span>
                <span>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
            </svg>
          </span>
            </div>
            <button type="button" x-on:click="showModal = false" class="focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </button>
        </div>
        <div class=" mx-4" >
            <div class="mt-6">
                <label for="service" class="block text-xs font-normal text-gray-100">Class name</label>
                <input type="text" wire:model.defer="className" x-bind:value="selected.value">
                <div class="relative inline-block w-full rounded-md ">
                    <button type="button" class=" z-0 w-full py-2 pl-3 pr-10 text-left text-gray-100 font-normal border border-purple-100 rounded-md cursor-default focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5" x-text="selected.title" x-on:click="open = true">

      <span class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 my-2 "  fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
        </span>
                    </button>
                </div>

                <div  class="border border-purple-100">
                    <div x-show="open"  @click.away="open = false">
                        <div>
                            <div class="flex items-center py-2 cursor-pointer" x-show="open"  >
      <span class="mx-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-100 border border-green-100 rounded-full" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
        </svg>
    </span>
                                <span class="text-xs font-normal text-gray-100" x-on:click="newClass = !newClass; isShowClass = !isShowClass">Choose default class</span>
                            </div>
                        </div>
                        <ul x-show="isShowClass" class="py-1 overflow-auto h-32 text-base leading-6 border border-purple-100
              rounded-md shadow-xs max-h-60 focus:outline-none sm:text-sm sm:leading-5">
                            <template x-for="option in classes" :key="option">
                                <li @click.prevent="selected.title = option.class_name; selected.value = option.uuid; open = false; " class="relative py-2 pl-3  text-gray-200 cursor-default select-none pr-9" :class="{ ' text-gray-200 hover:bg-purple-100': open == true}">
                                    <p x-text="option.class_name" class="inline-flex"></p>
                                </li>
                            </template>
                        </ul>
                    </div>


                    <ul class="py-1 overflow-auto h-32 text-base leading-6
     shadow-xs max-h-60 focus:outline-none sm:text-sm sm:leading-5" x-show="newClass">
                        <div class="py-2 cursor-pointer relative ">
                            <input type="search" class="py-2 px-10 w-full text-xs font-normal text-gray-100" placeholder="Search default class" x-model="searchClass">
                            <span class="absolute inset-y-0 left-0 mx-2 my-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-100 bg-purple-100
        rounded-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
      </span>
                        </div>
                        <template x-for="option in options" :key="option">
                            <li @click.prevent="selected.title = option.value; selected.value = option.value; newClass = false;" class="relative py-2 pl-3  text-gray-200 cursor-default select-none pr-9" :class="{ ' text-gray-200 hover:bg-purple-100': open == true}">
                                <p x-text="option.value" class="inline-flex"></p>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>
            {{-- test --}}

            <div class="my-6">
                <label for="service" class="block text-xs font-normal text-gray-100">Section name</label>
                <input type="hidden" name="classSectionType" x-bind:value="select.value">
                <div class="relative inline-block w-full rounded-md ">
                    <button type="button" class=" z-0 w-full py-2 pl-3 pr-10 text-left text-gray-100 font-normal border border-purple-100 rounded-md cursor-default focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5" x-text="select.title" x-on:click="show = true">

                  <span class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 my-2 "  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                    </span>
                    </button>
                </div>
                <div  class="border border-purple-100">
                    <div x-show="show"  @click.away="show = false">
                        <div>
                            <div class="flex items-center py-2 cursor-pointer" x-show="show"  >
                  <span class="mx-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-100 border border-green-100 rounded-full" viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                    </svg>
                </span>
                                <span class="text-xs font-normal text-gray-100" x-on:click="newSection = !newSection">Add new section</span>
                            </div>
                            <input name="newSectionName" type="text" class="w-full py-2 text-xs px-2 text-gray-100" placeholder="Add a new section" x-show="newSection">
                        </div>
                    </div>

                    <ul class="py-1 overflow-auto h-32 text-base leading-6
                 shadow-xs max-h-60 focus:outline-none sm:text-sm sm:leading-5" x-show="show">
                        <div class="py-2 cursor-pointer relative ">
                            <input type="search" class="py-2 px-10 w-full text-xs font-normal text-gray-100" placeholder="Search">
                            <span class="absolute inset-y-0 left-0 mx-2 my-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-100 bg-purple-100
                    rounded-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                  </span>
                        </div>
                        <template x-for="subject in classSection" :key="subject">
                            <li @click.prevent="select.title = subject.section_name; select.value = subject.uuid; show = false" class="relative py-2 pl-3  text-gray-200 cursor-default select-none pr-9" :class="{ ' text-blue-100 hover:bg-purple-100': show == true}">
                                <p x-text="subject.section_name" class="inline-flex"></p>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>

            <div class="my-6">
                <label for="service" class="block text-xs font-normal text-gray-100">Extra Category</label>
                <input type="hidden" name="classSectionCategoryType" x-bind:value="selectCategory.value">
                <div class="relative inline-block w-full rounded-md ">
                    <button type="button" class=" z-0 w-full py-2 pl-3 pr-10 text-left text-gray-100 font-normal border border-purple-100 rounded-md cursor-default focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5" x-text="selectCategory.title" x-on:click="showCategory = true">

                    <span class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 my-2 "  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                      </svg>
                      </span>
                    </button>
                </div>
                <div  class="border border-purple-100">
                    <div x-show="showCategory"  @click.away="showCategory = false">
                        <div>
                            <div class="flex items-center py-2 cursor-pointer" x-show="showCategory"  >
                    <span class="mx-2">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-100 border border-green-100 rounded-full" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                      </svg>
                  </span>
                                <span class="text-xs font-normal text-gray-100" x-on:click="newCategory = !newCategory">Add new section</span>
                            </div>
                            <input type="text" name="newClassSectionCategoryType"  class="w-full py-2 text-xs px-2 text-gray-100" placeholder="Add a new section" x-show="newCategory">
                        </div>
                    </div>

                    <ul class="py-1 overflow-auto h-32 text-base leading-6
                   shadow-xs max-h-60 focus:outline-none sm:text-sm sm:leading-5" x-show="showCategory">
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
                            <li @click.prevent="selectCategory.title = category.category_name; selectCategory.value = category.uuid; showCategory = false" class="relative py-2 pl-3  text-gray-200 cursor-default select-none pr-9" :class="{ ' text-blue-100 hover:bg-purple-100': showCategory == true}">
                                <p x-text="category.category_name" class="inline-flex"></p>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>

            <div class="mb-6">
                <button type="submit" class="bg-blue-100 text-white px-4 py-2 rounded-md text-base" x-on:click="addClass">
                    Create Class
                </button>
            </div>
        </div>

    </div>
</form>
