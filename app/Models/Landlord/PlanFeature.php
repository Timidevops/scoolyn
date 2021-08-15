<?php

namespace App\Models\Landlord;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanFeature extends \Rinvex\Subscriptions\Models\PlanFeature
{
    use HasFactory;
    protected $connection = 'mysql';
}
