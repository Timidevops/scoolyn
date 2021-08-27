<div class="lg:px-8">
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
        <div class="bg-white rounded-md lg:px-8 py-5">
            <div class="my-5">
                <p>Admission status: {{$applicant->status}}</p>
                <p>Exam date: {{$applicant->exam_schedule ?? 'not assigned'}}</p>
            </div>
            <div class="my-5">
                @if( $applicant->status != \App\Models\Tenant\AdmissionApplicant::CLASS_ARM_ADDED )
                    @if($applicant->status == \App\Models\Tenant\AdmissionApplicant::ADMITTED_STATUS )
                        <livewire:tenant.admission.convert-to-student :applicant="$applicant->uuid" />
                    @else
                        <form action="{{route('updateApplicant',$applicant->uuid)}}" method="post">
                            @csrf
                            @method('PATCH')
                            <div class="pb-3 pt-3 flex items-end">
                                <div class="w-1/2 px-1">
                                    <label for="admissionStatus" class="block text-sm font-normal text-gray-100">Change Admission Status</label>
                                    <select id="admissionStatus" name="admissionStatus" class="w-full capitalize text-gray-100 rounded-md py-2 px-2 border border-purple-100 ">
                                        <option value="">-- Select Status --</option>
                                        <option value="{{\App\Models\Tenant\AdmissionApplicant::ADMITTED_STATUS}}">
                                            {{str_replace('_', ' ', \App\Models\Tenant\AdmissionApplicant::ADMITTED_STATUS)}}
                                        </option>
                                        <option value="{{\App\Models\Tenant\AdmissionApplicant::REJECTED_STATUS}}">
                                            {{str_replace('_', ' ', \App\Models\Tenant\AdmissionApplicant::REJECTED_STATUS)}}
                                        </option>
                                    </select>
                                </div>
                                <div class="w-1/2 px-1">
                                    <label for="examDate" class="block text-sm font-normal text-gray-100">Schedule Exam Date</label>
                                    <input type="date" id="examDate" name="examDate" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100">
                                </div>
                                <div class="w-2/5 px-1">
                                    <button type="submit" class="bg-blue-100 w-full text-white rounded-md py-3 px-3  text-sm" >
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                    @endif
                @endif
            </div>
            <div class="flex my-5">
                <div class="w-1/2">
                    <img src="" alt="passport">
                </div>
                <div class="w-1/2">
                    <h3 class="text-blue-100">Basic Information</h3>
                    <p>First Name: {{$applicant['student_first_name']}}</p>
                    <p>Last Name: {{$applicant['student_last_name']}}</p>
                    <p>Other Name: {{$applicant['student_other_name']}}</p>
                    <p>DOB: {{$applicant['student_dob']}}</p>
                    <p>Gender: {{$applicant['student_gender']}}</p>
                    <p>Blood Group: {{$applicant['student_blood_group']}}</p>
                    <p>Religion: {{$applicant['student_religion']}}</p>
                    <p>Address: {{$applicant['student_address']}}</p>
                </div>
            </div>
            <div class="flex my-5">
                <div class="w-1/2">
                    <h3 class="text-blue-100">Academic Information</h3>
                    <p>Previous school: {{$applicant['previous_school']}}</p>
                    <p>Previous class: {{$applicant['previous_class']}}</p>
                    <p>Seeking to: {{$applicant['class']}}</p>
                    <p>Class Section: {{$applicant['section']}}</p>
                </div>
                <div class="w-1/2">
                    <h3 class="text-blue-100">Guardian Information</h3>
                    <p>Guardian name: {{$applicant['guardian_name']}}</p>
                    <p>Relationship: {{$applicant['guardian_relationship']}}</p>
                    <p>Phone number: {{$applicant['guardian_contact_number']}}</p>
                    <p>Email: {{$applicant['guardian_contact_email']}}</p>
                    <p>Address: {{$applicant['guardian_address']}}</p>
                    <p>Profession: {{$applicant['guardian_profession']}}</p>
                </div>
            </div>
        </div>
    </div>
</div>
