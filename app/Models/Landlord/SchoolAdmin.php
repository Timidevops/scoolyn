<?php

namespace App\Models\Landlord;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rinvex\Subscriptions\Traits\HasSubscriptions;

class SchoolAdmin extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasSubscriptions;

    protected $connection = 'landlord';

    protected $guarded = [];

    public function isOnboardDone(): bool
    {
        return (bool) $this->setup_complete;
    }
}
