<?php

namespace Tests\Unit\Tenant\Subject;


use App\Actions\Tenant\Subject\CreateNewSubjectAction;
use App\Models\Tenant\Subject;
use Tests\TestCase;

class CreateNewSubjectTest extends TestCase
{
    /**
     *
     * @return void
     */
    public function test_subject_is_created()
    {
        (new CreateNewSubjectAction())->execute([
            'subject_name' => 'further maths',
        ]);

        $getSubject = Subject::all()->first();

        $this->assertEquals('further maths', $getSubject->subject_name);
        $this->assertEquals('further-maths', $getSubject->slug);
    }
}
