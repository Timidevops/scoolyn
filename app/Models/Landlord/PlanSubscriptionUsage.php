<?php

namespace App\Models\Landlord;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;

class PlanSubscriptionUsage extends \Rinvex\Subscriptions\Models\PlanSubscriptionUsage
{
    use HasFactory;
    use UsesLandlordConnection;
}
