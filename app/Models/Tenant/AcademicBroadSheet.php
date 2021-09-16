<?php

namespace App\Models\Tenant;

use App\Http\Traits\Tenant\AcademicSessionTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\ModelStatus\HasStatuses;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

class AcademicBroadSheet extends Model
{
    use HasFactory;
    use SoftDeletes;
    use AcademicSessionTrait;
    use HasStatuses;
    use UsesTenantConnection;

    const CREATED_STATUS = 'created';
    const SUBMITTED_STATUS = 'submitted';
    const APPROVED_STATUS = 'approved';
    const NOT_APPROVED_STATUS = 'not-approved';
    const HALF_TERM_STATUS = 'half-term';
    const COMPLETED_STATUS = 'completed-term';

    protected $guarded = [];

    protected $casts = [
        'meta' => 'array'
    ];


}
