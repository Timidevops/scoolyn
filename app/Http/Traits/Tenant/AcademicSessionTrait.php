<?php

namespace App\Http\Traits\Tenant;

use App\Models\Tenant\AcademicSession;
use App\Models\Tenant\AcademicTerm;
use Illuminate\Database\Eloquent\Builder;

trait AcademicSessionTrait{

    public static function bootAcademicSessionTrait()
    {
        static::addGlobalScope('academicSession', function (Builder $builder) {
            $builder
                ->where('academic_session_id', AcademicSession::currentAcademicSession()->uuid)
                ->where('academic_term_id', AcademicTerm::currentAcademicTerm()->uuid);
        });
    }

}
