<?php

namespace Tests\Unit\Tenant\Fee;


use App\Actions\Tenant\Fee\CreateNewSchoolFeeAction;
use App\Models\Tenant\SchoolFee;
use App\Models\Tenant\Student;
use Tests\TestCase;

class CreateNewSchoolFeeTest extends TestCase
{
    /**
     * @return void
     */
    public function test_that_school_fee_is_created()
    {
        $getStudent = Student::factory()->make();

        (new CreateNewSchoolFeeAction())->execute($getStudent, [
            'amount' => 70000,
        ]);

        $getSchoolFee = SchoolFee::all()->first();

        $this->assertEquals(70000, $getSchoolFee->amount);
        $this->assertEquals($getStudent->uuid, $getSchoolFee->student_id);
    }
}
