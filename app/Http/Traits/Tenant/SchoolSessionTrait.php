<?php

namespace App\Http\Traits\Tenant;

use App\Scope\Tenant\SchoolSessionScope;

trait SchoolSessionTrait{
    public static function bootSchoolSessionTrait()
    {
        static::addGlobalScope(new SchoolSessionScope());
    }
}
