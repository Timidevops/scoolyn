
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
    @foreach($approvedBroadsheets as $key => $approvedBroadsheet)
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
                        {{$approvedBroadsheet->subject['subject_name']}}
                    </span>
            </td>
            <td class="px-6 py-4 text-left whitespace-nowrap text-xs text-gray-200">
                    <span class="text-gray-200 font-normal capitalize">
                        {{$approvedBroadsheet->teacher['full_name']}}
                    </span>
            </td>
            <td class="md:px-6 py-4 text-center whitespace-nowrap text-sm text-gray-200 ">
                <a href="{{route('singleAcademicResult',$approvedBroadsheet->uuid)}}">
                    <button type="button" class="text-blue-100  text-sm " >
                        /!/
                    </button>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

