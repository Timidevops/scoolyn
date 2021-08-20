    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2"
        x-show="accountRegistration" 
        x-transition:enter="transition-transition ease-out duration-200" 
        x-transition:enter-start="opacity-0 translate-y-1" 
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-end="opacity-0 translate-y-1">
       <div>
           <label for="name" class="block text-sm font-medium text-gray-300">Name of School</label>
           <div class="mt-1">
           <input type="text" name="name" id="name" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-purple-100 rounded-md p-2 border">
           </div>
       </div>
       <div>
           <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
           <div class="mt-1">
           <input type="text" name="email" id="email" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-purple-100 rounded-md p-2 border">
           </div>
       </div>
       <div>
           <label for="number" class="block text-sm font-medium text-gray-300">Phone number</label>
           <div class="mt-1">
           <input type="text" name="number" id="number" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-purple-100 rounded-md p-2 border">
           </div>
       </div>
       <div>
           <label for="address" class="block text-sm font-medium text-gray-300">Address</label>
           <div class="mt-1">
           <input type="text" name="address" id="address" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-purple-100 rounded-md p-2 border">
           </div>
       </div>
       <div>
           <label for="nameOfBranches" class="block text-sm font-medium text-gray-300">Number of branches</label>
           <div class="mt-1">
           <select type="number" name="nameOfBranches" id="nameOfBranches" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-purple-100 rounded-md p-2 border">
            <option>branch 1</option>
            <option selected>branch 2</option>
            <option>branch 3</option>
           </select>
           </div>
       </div>
       <div>
           <label for="principalName" class="block text-sm font-medium text-gray-300">Principal Name</label>
           <div class="mt-1">
           <input type="text" name="principalName" id="principalName" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-purple-100 rounded-md p-2 border">
           </div>
       </div>
       <div>
           <label for="privateGovernment" class="block text-sm font-medium text-gray-300">Private/Government</label>
           <div class="mt-1">
           <select type="number" name="privateGovernment" id="privateGovernment" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-purple-100 rounded-md p-2 border">
            <option>Private</option>
            <option selected>Public</option> 
           </select>
           </div>
       </div>
       <div>
           <label for="text" class="block text-sm font-medium text-gray-300">Lorem Ipsum</label>
           <div class="mt-1">
           <input type="text" name="text" id="text" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-purple-100 rounded-md p-2 border"> 
           </div>
       </div>
       <div>
           <label for="privateGovernment" class="block text-sm font-medium text-gray-300">School Logo</label>
           <div class="mt-1">
           <img src="" alt="school logo ">
           </div>
       </div>
    </div>
    <div class="flex justify-end py-4">
        <button type="button" class="bg-blue-100 text-white px-6 py-2 rounded-md text-sm"
        x-on:click="Open=true">
           Next
        </button>
    </div> 