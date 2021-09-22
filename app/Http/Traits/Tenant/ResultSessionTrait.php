<?php

namespace App\Http\Traits\Tenant;


use App\Models\Tenant\AcademicSession;
use App\Models\Tenant\Setting;
use Illuminate\Database\Eloquent\Builder;

trait ResultSessionTrait{

    public static function bootResultSessionTrait()
    {

        static::addGlobalScope('resultSession', function (Builder $builder) {

            $currentSession = AcademicSession::whereUuid(Setting::getCurrentAcademicSessionId());

            $builder
                ->where('academic_session_id', $currentSession->uuid)
                ->where('term', $currentSession->term);
        });
    }
}
