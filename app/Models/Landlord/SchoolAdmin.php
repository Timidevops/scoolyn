<?php

namespace App\Models\Landlord;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rinvex\Subscriptions\Traits\HasSubscriptions;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;

class SchoolAdmin extends Model
{
    use HasFactory;
    use SoftDeletes;
    use UsesLandlordConnection;

    protected $guarded = [];

    public function isOnboardDone(): bool
    {
        return (bool) $this->setup_complete;
    }
}
