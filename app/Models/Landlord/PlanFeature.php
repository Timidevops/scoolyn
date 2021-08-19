<?php

namespace App\Models\Landlord;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;

class PlanFeature extends \Rinvex\Subscriptions\Models\PlanFeature
{
    use HasFactory;
    use UsesLandlordConnection;
}
