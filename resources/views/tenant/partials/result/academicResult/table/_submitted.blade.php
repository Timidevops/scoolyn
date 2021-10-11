
<table class="min-w-full divide-y  divide-purple-100">
    <thead>
        <tr>
            <th class="px-6 py-3 w-1  text-left text-sm font-medium text-gray-500 uppercase">
                S/N
            </th>
            <th class="px-6 py-3  text-left  font-medium text-gray-500 text-sm">
                <span class="flex items-center mx-1">
                    Subject name
                </span>
            </th>
            <th class="px-6 py-3  text-left  font-medium text-gray-500 text-sm">
                <span class="flex items-center mx-1">
                    Subject teacher
                </span>
            </th>
            <th class="px-6 py-3  text-center  font-medium text-gray-500 text-sm">
                <span class="">
                    Action
                </span>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($submittedBroadsheets as $key => $submittedBroadsheet)
            <tr>
                <td class="max-w-0  px-6 py-4 whitespace-nowrap text-xs text-gray-900">
                    <div class="flex">
                        <a class="group inline-flex space-x-2 truncate">
                            <p class="text-gray-500 truncate">
                                {{$key + 1}}
                            </p>
                        </a>
                    </div>
                </td>
                <td class="px-6 py-4 text-left whitespace-nowrap text-xs text-gray-200">
                    <span class="text-gray-200 font-normal capitalize">
                        {{$submittedBroadsheet->subject['subject_name']}}
                    </span>
                </td>
                <td class="px-6 py-4 text-left whitespace-nowrap text-xs text-gray-200">
                    <span class="text-gray-200 font-normal capitalize">
                        {{$submittedBroadsheet->teacher['full_name'] ?? 'not assigned'}}
                    </span>
                </td>
                <td class="md:px-6 py-4 text-center whitespace-nowrap text-sm text-gray-200 ">
                    <a href="{{route('singleAcademicResultBroadsheet',[$classArm->uuid, $submittedBroadsheet->uuid])}}">
                        <button type="button" class="text-blue-100  text-sm " >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-100 mx-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </button>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

