
  <div class="relative grid grid-cols-1 gap-6 max-w-md"
  x-show="Open"
  x-transition:enter="transition-transition ease-out duration-200"
  x-transition:enter-start="opacity-0 translate-y-1"
  x-transition:enter-end="opacity-100 translate-y-0"
  x-transition:leave="transition ease-in duration-150"
  x-transition:leave-end="opacity-0 translate-y-1">
      <div>
          <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
          <div class="mt-1">
              <input type="text" id="email" placeholder="{{$email}}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-purple-100 rounded-md p-2 border" disabled>
          </div>
      </div>
     <div>
         <label for="adminPassword" class="block text-sm font-medium text-gray-300">Set Password</label>
         <div class="mt-1">
            <input type="password" name="adminPassword" id="adminPassword" class="border-purple-100 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm rounded-md p-2 border" required>
         </div>
     </div>
     <div>
         <label for="confirmPassword" class="block text-sm font-medium text-gray-300">Confirm Password  </label>
         <div class="mt-1">
            <input type="password" name="adminPassword_confirmation" id="confirmPassword" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-purple-100 rounded-md p-2 border" required>
         </div>
     </div>
     <div class="flex justify-bottom-end  pb-52 md:py-4">
        <button type="submit" class="bg-blue-100 text-white px-6 py-2 rounded-md text-sm">
           Submit
        </button>
    </div>
  </div>
