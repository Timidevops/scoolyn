<?php

namespace App\Models\Landlord;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends \Rinvex\Subscriptions\Models\Plan
{
    use HasFactory;
    protected $connection = 'landlord';
}
