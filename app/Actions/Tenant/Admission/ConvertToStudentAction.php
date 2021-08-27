<?php


namespace App\Actions\Tenant\Admission;


use App\Actions\Tenant\Student\ClassArm\AttachStudentToClassArmAction;
use App\Actions\Tenant\Student\CreateNewStudentAction;
use App\Models\Tenant\AdmissionApplicant;
use App\Models\Tenant\ClassArm;
use App\Models\Tenant\Parents;

class ConvertToStudentAction
{
    public function execute(array $input)
    {
        $dummyParent = Parents::withoutGlobalScope('dummyParent')->find(1);

        $applicant = AdmissionApplicant::query()->where('uuid', $input['applicantId'])->first();

        $newStudent = (new CreateNewStudentAction)->execute($dummyParent, [
            'first_name' => $applicant->student_first_name,
            'last_name' => $applicant->student_last_name,
            'other_name' => $applicant->student_other_name,
            'gender' => $applicant->student_gender,
            'dob' => $applicant->student_dob,
            'address' => $applicant->student_address,
            'class_arm' => $input['classArmId'],
        ]);

        $classArm = ClassArm::whereUuid($input['classArmId'])->first();

        (new AttachStudentToClassArmAction())->execute($classArm, [
            'studentId' => (string) $newStudent->uuid,
        ]);

        $applicant->update([
            'status' => AdmissionApplicant::CLASS_ARM_ADDED,
        ]);
    }

}
