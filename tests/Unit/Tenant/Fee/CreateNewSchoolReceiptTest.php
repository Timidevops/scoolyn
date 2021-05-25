<?php

namespace Tests\Unit\Tenant\Fee;


use App\Actions\Tenant\Fee\Receipt\CreateNewSchoolReceiptAction;
use App\Models\Tenant\SchoolReceipt;
use App\Models\Tenant\Student;
use Tests\TestCase;

class CreateNewSchoolReceiptTest extends TestCase
{
    /**
     * @return void
     */
    public function test_that_school_receipt_is_created()
    {
        $getStudent = Student::factory()->make();

        (new CreateNewSchoolReceiptAction())->execute($getStudent, [
            'school_fee_id' => 'id-902',
            'amount' => 40000,
        ]);

        $getSchoolReceipt = SchoolReceipt::all()->first();

        $this->assertEquals(40000, $getSchoolReceipt->amount);
        $this->assertEquals('id-902', $getSchoolReceipt->school_fee_id);
        $this->assertEquals($getStudent->uuid, $getSchoolReceipt->student_id);
    }
}
