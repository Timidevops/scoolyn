<form wire:submit.prevent="store">
    @csrf
    @if($errorDiv)
        <div class="mx-8 bg-red-100 p-4">
            <p class="text-white text-sm">
                {{$errorMessage}}
            </p>
        </div>
    @endif

    @if($errors->any())
        <div class="mx-8 bg-red-100 p-4">
            @foreach ($errors->all() as $error)
                <p class="text-white">
                    {!! $error !!}
                </p>
            @endforeach
        </div>
    @endif

    <div class="p-4 lg:px-8">
        <div class="bg-white md:grid-cols-2 gap-6 p-3">
          Download the excel format to begin Parent upload
        </div>
    </div>

    <div class="md:flex mt-5 mb-5 lg:px-8">
        <div class="w-full p-3 bg-white rounded-sm">
        <div class=" relative  h-48 rounded-md bg-purple-100  ">
            <x-forms.filepond
                wire:model="file"
                allowFileTypeValidation
                allowFileSizeValidation
                maxFileSize="4mb"
            />
        </div>

        <div class="flex justify-center items-center my-6">
            <button wire:click="downloadExcelFormat" type="button" class="relative px-2 py-2 bg-gray-100 text-white mx-2 rounded-md">
                <span class="absolute inset-y-0 left-0 my-3 mx-2 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                  </svg>
                </span>
                <span class="mx-5">Download Excel Format</span>
            </button>
            <button type="button"  class="relative px-2 py-2 bg-gray-100 text-white mx-2 rounded-md">
                <span class="absolute inset-y-0 left-0 my-3 mx-2 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                </span>
                <a href="{{route('createParent')}}">
                    <span class="mx-5">Add via form </span>
                </a>
            </button>
        </div>

    </div>
    </div>

    <div class="px-4 py-4 lg:px-8">
        <button type="submit" class="bg-blue-100 text-white rounded-md py-3 px-3  text-sm">
            Submit
        </button>
    </div>

</form>


