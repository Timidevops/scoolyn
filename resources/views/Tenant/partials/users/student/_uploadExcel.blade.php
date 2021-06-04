<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
<style>
    .filepond--root{
        margin-bottom: 0 !important;
    }
    .filepond--panel-root{
        background-color: transparent !important;
    }
    .filepond--browser.filepond--browser{
        height: 100%;
    }
    .filepond--root .filepond--credits{
        display: none;
    }
    .filepond--drop-label.filepond--drop-label label{
        display: none;
    }
    .filepond--file-status-sub{
        display: none;
    }
    button.filepond--file-action-button.filepond--action-revert-item-processing{
        display: none;
    }
</style>

<div>
    <div class="lg:mt-2 mt-8 mb-4">
        <div class="mt-2 text-xl text-gray-200">
            Student
        </div>
        <span class="mt-2 text-base text-gray-300"> Total Student</span>
    </div>
    <div class="md:flex">
        <div class="w-full p-3 bg-white rounded-sm">
            <div class=" relative  h-48 rounded-md bg-purple-100  flex justify-center items-center">
                <div class="absolute">
                    <div class="flex flex-col items-center">
                        
                        <span class="block text-gray-700 font-normal text-center ">
                            Click to upload file <br> or <br> drag file here
                                    </span>
                    </div>
                </div>
                <input type="file" class="h-full w-full opacity-1 " name="file">
            </div>

           <div class="flex justify-center items-center my-6">
            <button type="button" class="relative px-2 py-2 bg-gray-100 text-white mx-2 rounded-md">
                <span class="absolute inset-y-0 left-0 my-3 mx-2 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                  </svg>
                </span>
               <span class="mx-5">Download Excel </span>
            </button>
            <button type="button"  class="relative px-2 py-2 bg-gray-100 text-white mx-2 rounded-md">
                <span class="absolute inset-y-0 left-0 my-3 mx-2 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                </span>
               <span class="mx-5">Add by details </span>
            </button>
           </div>

        </div>
    </div>
</div>


<!-- Babel polyfill, contains Promise -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.6.15/browser-polyfill.min.js"></script>

<!-- Get FilePond polyfills from the CDN -->
<script src="https://unpkg.com/filepond-polyfill/dist/filepond-polyfill.js"></script>

<!-- Get FilePond JavaScript and its plugins from the CDN -->
<script src="https://unpkg.com/filepond/dist/filepond.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>

<!-- FilePond init script -->
<script>

    // Register plugins
    FilePond.registerPlugin(
        FilePondPluginFileValidateSize,
    );

    // Set default FilePond options
    FilePond.setOptions({

        // maximum allowed file size
        maxFileSize: '5MB',

        // upload to this server end point
        server: {
            process:{
                url: '/student',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                onload: (response) => {
                    let resp = (JSON.parse(response))
                    window.location = resp['redirect'];
                    return true;
                },
                onerror: (response) => {
                    let resp = (JSON.parse(response));
                    let div  = document.querySelector('.filepond--file-status');
                    div.innerHTML = resp['description'];
                }
            }
        }
    });

    // Turn a file input into a file pond
    let pond = FilePond.create(document.querySelector('input[type="file"]'));

</script>

