<?php

namespace Tests\Feature\Tenant\Fee;

use App\Actions\Tenant\Fee\CreateNewClassSectionFeeAction;
use App\Actions\Tenant\Fee\CreateNewFeeStructureAction;
use App\Actions\Tenant\Fee\CreateNewStudentFeeAction;
use App\Actions\Tenant\SchoolClass\CreateNewClassSectionAction;
use App\Actions\Tenant\SchoolClass\CreateNewSchoolClassAction;
use App\Actions\Tenant\Student\CreateNewStudentAction;
use App\Models\Tenant\ClassFee;
use App\Models\Tenant\FeeStructure;
use App\Models\Tenant\StudentParent;
use App\Models\Tenant\SchoolClass;
use App\Models\Tenant\Student;
use App\Models\Tenant\StudentFee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SchoolFeesControllerTest extends TestCase
{
    /**
     * @return void
     */
    public function test_that_school_fee_controller_is_stored()
    {
        $getParent = StudentParent::factory()->make();
        $getClass = SchoolClass::factory()->make();

        $getClassSection = (new CreateNewClassSectionAction())->execute($getClass, [
            'section_name' => 'a'
        ]);

        (new CreateNewStudentAction())->execute($getParent, [
            'matriculation_number' => '101012',
            'first_name' => 'john',
            'last_name' => 'doe',
            'school_class_id' => $getClass->uuid,
            'class_section_id' => $getClassSection->uuid,
        ]);

        $getStudent = Student::all()->first();

        $feeType = (string) $this->createFeeStructure()->uuid;

        $response = $this->post("school-fee/$getStudent->uuid", [
            'classFee' => (string) $this->createClassFee($feeType, $getClass)->uuid,
            'studentFee' => [$this->createStudentFee($getStudent, $feeType)->uuid,$this->createStudentFee($getStudent, $feeType)->uuid],
        ]);

        $response->assertRedirect('/');
    }

    public function createClassFee($feeType, $getClass)
    {

        $getClassSection = (new CreateNewClassSectionAction())->execute($getClass, [
            'section_name' => 'science'
        ]);

        (new CreateNewClassSectionFeeAction())->execute($getClassSection, [
            'fee_structure_id' => $feeType,
        ]);

       return ClassFee::all()->first();
    }

    public function createStudentFee($getStudent, $feeType)
    {
        (new CreateNewStudentFeeAction())->execute($getStudent, [
            'fee_structure_id' => $feeType,
        ]);

        return StudentFee::all()->first();
    }

    public function createFeeStructure()
    {
        (new CreateNewFeeStructureAction())->execute([
            'name' => 'school fees',
            'amount' => 200000,
        ]);

        return FeeStructure::all()->first();
    }
}
