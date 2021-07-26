<div>
    <div class="mt-2 text-xl text-gray-200">
        Settings
    </div>
</div>

<div class="bg-white rounded-md md:flex md:items-center md:mt-2 py-6 px-2 ">
    <table>
        <tr>
            <td>
                <a href="{{route('academicSession')}}">
                    <span>Set Academic Session</span>
                </a>
                <p class="text-sm text-gray-100">
                    Current Academic Session: {{$currentAcademicSession}}
                </p>
            </td>
            <td>

            </td>
        </tr>
    </table>
</div>
