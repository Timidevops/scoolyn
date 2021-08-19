<?php

namespace App\Models\Tenant;

use App\Actions\Tenant\CreateTenantDatabaseAction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Rinvex\Subscriptions\Traits\HasSubscriptions;
use Spatie\Multitenancy\Models\Tenant;

class ScoolynTenant extends Tenant
{
    use HasFactory;

    use HasSubscriptions;

    protected $guarded = [];

    public static function booted()
    {
        static::creating(fn(ScoolynTenant $model) => $model->database = $model->createDatabase());
    }

    public function createDatabase()
    {
        return (new CreateTenantDatabaseAction())->execute($this->name);
    }
}
