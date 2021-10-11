<?php

namespace App\Models\Tenant;

use App\Http\Traits\Tenant\AcademicSessionTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\ModelStatus\HasStatuses;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

class Transaction extends Model
{
    use HasFactory;
    use AcademicSessionTrait;
    use SoftDeletes;
    use UsesTenantConnection;
    use HasStatuses;

    protected $guarded = [];

    const CREDIT_TYPE =  'credit';

    protected $casts = [
        'meta' => 'array',
    ];

    public function schoolFees(): BelongsTo
    {
        return $this->belongsTo(SchoolFee::class, 'school_fees_id', 'uuid');
    }

}
