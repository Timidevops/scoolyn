<?php

namespace Tests\Unit\Tenant\AcademicSession;


use App\Actions\Tenant\AcademicSession\CreateNewAcademicSessionAction;
use App\Models\Tenant\AcademicSession;
use Tests\TestCase;

class CreateNewAcademicSessionTest extends TestCase
{
    /**
     *
     *
     * @return void
     */
    public function test_that_academic_session_is_created()
    {
        (new CreateNewAcademicSessionAction())->execute([
            'session_name' => '2021/2022',
            'session_year' => '2021'
        ]);

        $getAcademicSession = AcademicSession::all()->first();

        $this->assertEquals('2021/2022', $getAcademicSession->session_name);
        $this->assertEquals('20212022', $getAcademicSession->slug);

    }
}
