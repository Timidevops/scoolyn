<?php

namespace App\Models\Landlord;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;
use Rinvex\Subscriptions\Models\Plan as UsePlan;

class Plan extends UsePlan
{
    use HasFactory;
    use UsesLandlordConnection;

    protected $fillable = [
        'slug',
        'name',
        'description',
        'is_active',
        'price',
        'signup_fee',
        'currency',
        'trial_period',
        'trial_interval',
        'invoice_period',
        'invoice_interval',
        'grace_period',
        'grace_interval',
        'prorate_day',
        'prorate_period',
        'prorate_extend_due',
        'active_subscribers_limit',
        'sort_order',
        'uuid',
    ];

    public static function whereUuid(string $uuid)
    {
        return self::query()->where('uuid', $uuid);
    }

    public function getFeatureByEnName(string $name)
    {
        return collect(PlanFeature::query()
            ->where('plan_id', $this->id)->get())->filter(function ($item) use ($name){
                return $item->name == $name;
        })->first();
    }
}
