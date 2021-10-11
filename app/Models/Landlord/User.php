<?php

namespace App\Models\Landlord;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticates;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;

class User extends Authenticates
{
    use HasFactory;
    use SoftDeletes;
    use UsesLandlordConnection;

    protected $guarded = [];
}
