<?php

namespace Tests\Unit\Tenant\AcademicTerm;


use App\Actions\Tenant\AcademicTerm\CreateNewAcademicTermAction;
use App\Models\Tenant\AcademicTerm;
use Tests\TestCase;

class CreateNewAcademicTermTest extends TestCase
{
    /**
     *
     * @return void
     */
    public function test_academic_term_is_created()
    {
        (new CreateNewAcademicTermAction())->execute([
            'term_name' => 'third term'
        ]);

        $getAcademicTerm = AcademicTerm::all()->first();

        $this->assertEquals('third term', $getAcademicTerm->term_name);
        $this->assertEquals('third-term', $getAcademicTerm->slug);
    }
}
