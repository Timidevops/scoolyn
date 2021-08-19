<?php

namespace App\Models\Landlord;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;
use Rinvex\Subscriptions\Models\Plan as UsePlan;

class Plan extends UsePlan
{
    use HasFactory;
    use UsesLandlordConnection;
}
