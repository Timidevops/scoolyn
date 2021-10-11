<?php

namespace App\Models\Tenant;

use App\Http\Traits\Tenant\AcademicSessionTrait;
use App\Http\Traits\Tenant\ResultSessionTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\ModelStatus\HasStatuses;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

class AcademicBroadSheet extends Model
{
    use HasFactory;
    use SoftDeletes;
    use ResultSessionTrait;
    use HasStatuses;
    use UsesTenantConnection;

    const CREATED_STATUS = 'created';
    const SUBMITTED_STATUS = 'submitted';
    const APPROVED_STATUS = 'approved';
    const NOT_APPROVED_STATUS = 'not-approved';

    protected $guarded = [];

    protected $casts = [
        'meta' => 'array'
    ];


}
