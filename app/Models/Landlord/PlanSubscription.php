<?php

namespace App\Models\Landlord;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanSubscription extends \Rinvex\Subscriptions\Models\PlanSubscription
{
    use HasFactory;
    protected $connection = 'landlord';
}
