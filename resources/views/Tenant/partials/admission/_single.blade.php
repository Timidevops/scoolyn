<div>
    <div class="mt-2 text-xl text-gray-200">
        <div class="flex ">
            Applicant:
            <div class="pl-2">
                <span class="capitalize">{{$applicant->student_first_name}}</span>
                <span class="capitalize">{{$applicant->student_other_name}}</span>
                <span class="capitalize">{{$applicant->student_last_name}}</span>
            </div>
        </div>
    </div>
    <a href="{{route('listApplicant')}}"><span class="mt-2  text-sm text-gray-300">/!/ Admission Applicants</span></a>
</div>

<div class="h-screen py-10">
    <div class="bg-white rounded-md ">
    </div>
</div>
