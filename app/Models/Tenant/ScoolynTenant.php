<?php

namespace App\Models\Tenant;

use App\Actions\Tenant\CreateTenantDatabaseAction;
use App\Models\Landlord\SchoolAdmin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Rinvex\Subscriptions\Traits\HasSubscriptions;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;
use Spatie\Multitenancy\Models\Tenant;

class ScoolynTenant extends Tenant
{
    use HasFactory;

    use UsesLandlordConnection;

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

    public function schoolAdmin(): HasOne
    {
        return $this->hasOne(SchoolAdmin::class, 'tenant_id', 'id');
    }

    public static function getCurrentSubscription()
    {
        return ScoolynTenant::current()->activeSubscriptions()->whereNull('cancels_at')->first() ?? self::getLastSubscription();
    }

    public static function isSubscriptionActive(): bool
    {
        return (bool) self::current()->activeSubscriptions()->whereNull('cancels_at')->first();
    }

    public static function getLastSubscription()
    {
        return ScoolynTenant::current()->subscriptions()->latest()->first();
    }

    public static function getSubscriptionStatus()
    {
        $subscription =  ScoolynTenant::current()->activeSubscriptions()->whereNull('cancels_at')->first() ?? self::getLastSubscription();

        if ( $subscription->ended() ){
            return 'expired';
        }

        if ( $subscription->canceled() ){
            return 'cancelled';
        }

        return  'active';
    }
}
