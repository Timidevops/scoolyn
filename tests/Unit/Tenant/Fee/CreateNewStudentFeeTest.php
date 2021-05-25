<?php

namespace Tests\Unit\Tenant\Fee;

use App\Actions\Tenant\Fee\CreateNewStudentFeeAction;
use App\Models\Tenant\Student;
use App\Models\Tenant\StudentFee;
use Tests\TestCase;

class CreateNewStudentFeeTest extends TestCase
{
    /**
     * @return void
     */
    public function test_that_student_fee_is_created()
    {
        $getStudent = Student::factory()->make();

        (new CreateNewStudentFeeAction())->execute($getStudent, [
            'fee_structure_id' => 'id-993',
        ]);

        $getStudentFee = StudentFee::all()->first();

        $this->assertEquals('id-993', $getStudentFee->fee_structure_id);
        $this->assertEquals($getStudent->uuid, $getStudentFee->student_id);
    }
}
