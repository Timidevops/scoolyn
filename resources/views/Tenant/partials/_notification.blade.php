<!-- Static sidebar for desktop -->
<div class="hidden lg:flex lg:flex-shrink-0" x-data="Notifications()">
    <div class="flex flex-col bg-gray-400" style="width: 300px;">
        <div class="flex flex-col flex-grow pt-10 pb-4 overflow-y-auto">
            <div class="flex-shrink-0 px-4 py-2 relative">
              <input type="search" name="" id="" class="py-3 px-2 rounded-full w-full bg-white focus:outline-none" placeholder="Search" 
              x-ref="searchField"
              x-model="search"
              x-on:keydown.window.prevent.slash="$refs.searchField.focus()">
              <span class="absolute inset-y-0 right-0 pr-8 py-5 "><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
            </span>
            </div>
            <div class="bg-white mt-2 mx-6  rounded-md ">
                @include('Tenant.partials._calenderUi')
            </div>
        
            <div class="bg-white mx-6 mt-2 rounded-md">
                <span class="mx-4 my-4 text-xs text-gray-200">Notifications</span>
                <ul class="text-xs text-gray-200">
                    <template x-for="item in notification" :key="item">
                    <li class="mx-4 my-3" x-text="item.employee_name">
                    </li>
                    </template>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Static sidebar for desktop -->
<!-- Static sidebar for desktop -->
{{-- <div class="md:hidden flex flex-shrink-0">
    <div class="flex flex-col bg-gray-400 w-full" >
        <div class="flex flex-col flex-grow pt-10 pb-4 overflow-y-auto">
            <div class="flex-shrink-0 px-4 py-2 relative">
              <input type="search" name="" id="" class="py-3 px-2 rounded-full w-full bg-white" placeholder="Search">
              <span class="absolute inset-y-0 right-0 pr-8 py-5 "><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
            </span>
            </div>
          
        
            <div class="bg-white mx-6 mt-2 rounded-md">
                <span class="mx-4 my-4 text-xs text-gray-200">Notifications</span>
                <ul class="text-xs text-gray-200">
                    <li class="mx-4 my-3">
                        Please do well to remind your parents of the upcoming PTF meeting
                    </li>
                    <li class="mx-4 my-3">
                        Please do well to remind your parents of the upcoming PTF meeting
                    </li>
                    <li class="mx-4 my-3">
                        Please do well to remind your parents of the upcoming PTF meeting
                    </li>
                    <li class="mx-4 my-3">
                        Please do well to remind your parents of the upcoming PTF meeting
                    </li>
                    <li class="mx-4 my-3">
                        Please do well to remind your parents of the upcoming PTF meeting
                    </li>
                </ul>
            </div>
            <div class="bg-white mt-2 rounded-md mx-auto ">
                @include('Tenant.partials._calenderUi')
            </div>
        </div>
    </div>
</div> --}}
<!-- Static sidebar for desktop -->
<script>
    function Notifications() {
        return {
          search: "",
          myForData: notification,
          get notification() {
            if (this.search === "") {
              return this.myForData;
            }
            return this.myForData.filter((item) => {
              return item.employee_name
                .toLowerCase()
                .includes(this.search.toLowerCase());
            });
          },
        };
      }
      var notification =[
        {
          employee_name: " Please do well to remind your parents of the upcoming PTF meeting",
        },
        {
          employee_name: "  remind your parents of the upcoming PTF meeting",
        },
        {
          employee_name: " parents of the upcoming PTF meeting",
        },
    ]
</script>