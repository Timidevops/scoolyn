<?php

namespace App\Http\Traits\Tenant;

use App\Scope\Tenant\SchoolTermScope;

trait SchoolTermTrait{
    public static function SchoolTermTrait()
    {
        static::addGlobalScope(new SchoolTermScope());
    }
}
