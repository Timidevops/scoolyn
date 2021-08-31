<?php

namespace App\Http\Traits\Tenant;

use App\Models\Tenant\AcademicSession;
use App\Models\Tenant\AcademicTerm;
use App\Models\Tenant\Setting;
use Illuminate\Database\Eloquent\Builder;

trait AcademicSessionTrait{

    public static function bootAcademicSessionTrait()
    {
        static::addGlobalScope('academicSession', function (Builder $builder) {
            $builder->where('academic_session_id', Setting::getCurrentAcademicSessionId());
        });
    }

}
