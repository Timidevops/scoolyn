
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
                        {{$approvedBroadsheet->teacher['full_name'] ?? 'not assigned'}}
                    </span>
            </td>
            <td class="md:px-6 py-4 text-center whitespace-nowrap text-sm text-gray-200 ">
                <a href="{{route('singleAcademicResultBroadsheet',[$classArm->uuid, $approvedBroadsheet->uuid])}}">
                    <button type="button" class="text-blue-100  text-sm " >
                        <svg class="h-4 w-4  mx-2" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             viewBox="0 0 488.85 488.85" style="enable-background:new 0 0 488.85 488.85;" xml:space="preserve">
                            <path d="M244.425,98.725c-93.4,0-178.1,51.1-240.6,134.1c-5.1,6.8-5.1,16.3,0,23.1c62.5,83.1,147.2,134.2,240.6,134.2
                                s178.1-51.1,240.6-134.1c5.1-6.8,5.1-16.3,0-23.1C422.525,149.825,337.825,98.725,244.425,98.725z M251.125,347.025
                                c-62,3.9-113.2-47.2-109.3-109.3c3.2-51.2,44.7-92.7,95.9-95.9c62-3.9,113.2,47.2,109.3,109.3
                                C343.725,302.225,302.225,343.725,251.125,347.025z M248.025,299.625c-33.4,2.1-61-25.4-58.8-58.8c1.7-27.6,24.1-49.9,51.7-51.7
                                c33.4-2.1,61,25.4,58.8,58.8C297.925,275.625,275.525,297.925,248.025,299.625z"/>
                        </svg>
                    </button>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

