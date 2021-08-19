<?php

namespace App\Models\Landlord;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;

class PlanSubscription extends \Rinvex\Subscriptions\Models\PlanSubscription
{
    use HasFactory;
    use UsesLandlordConnection;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('rinvex.subscriptions.tables.plan_subscriptions'));
        $this->setRules([
            'name' => 'required|string|strip_tags|max:150',
            'description' => 'nullable|string|max:32768',
            'slug' => 'required|alpha_dash|max:150|unique:'.config('rinvex.subscriptions.tables.plan_subscriptions').',slug',
            'plan_id' => 'required|integer|exists:'.config('env.landlord.landlordConnection').'.'.config('rinvex.subscriptions.tables.plans').',id',
            'subscriber_id' => 'required|integer',
            'subscriber_type' => 'required|string|strip_tags|max:150',
            'trial_ends_at' => 'nullable|date',
            'starts_at' => 'required|date',
            'ends_at' => 'required|date',
            'cancels_at' => 'nullable|date',
            'canceled_at' => 'nullable|date',
        ]);
    }
}
