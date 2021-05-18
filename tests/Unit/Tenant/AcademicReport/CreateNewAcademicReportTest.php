<?php

namespace Tests\Unit\Tenant\AcademicReport;


use App\Actions\Tenant\Result\AcademicReport\CreateNewAcademicReportAction;
use App\Models\Tenant\AcademicReport;
use App\Models\Tenant\Student;
use Tests\TestCase;

class CreateNewAcademicReportTest extends TestCase
{
    /**
     * @return void
     */
    public function test_that_academic_report_is_created()
    {
        $getStudent = Student::factory()->make();

        (new CreateNewAcademicReportAction())->execute($getStudent, [
            'meta' => [
                'subject_one' => [
                    'test_one' => '15',
                    'test_two' => '15',
                    'examination' => '70',
                ],
                'subject_two' => [
                    'test_one' => '15',
                    'test_two' => '15',
                    'examination' => '70',
                ],
            ]
        ]);

        $getAcademicReport = AcademicReport::all()->first();

        $this->assertEquals($getStudent->uuid, $getAcademicReport->student_id);
        $this->assertIsArray($getAcademicReport->meta);
        $this->assertCount(2, $getAcademicReport->meta);
        $this->assertEquals('subject_one', collect($getAcademicReport->meta)->keys()[0]);
        $this->assertCount(3, $getAcademicReport->meta['subject_one']);
    }
}
