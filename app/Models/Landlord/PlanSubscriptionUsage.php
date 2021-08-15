<?php

namespace App\Models\Landlord;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanSubscriptionUsage extends \Rinvex\Subscriptions\Models\PlanSubscriptionUsage
{
    use HasFactory;
    protected $connection = 'landord';
}
