<?php

namespace App\Models\Tenant;

use App\Http\Traits\Tenant\SchoolSessionTrait;
use App\Http\Traits\Tenant\SchoolTermTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

class ClassFee extends Model
{
    use HasFactory;
    use SoftDeletes;
    use SchoolTermTrait;
    use SchoolSessionTrait;
    use UsesTenantConnection;

    protected $guarded = [];

    protected $casts = [
        'fee_structure_id' => 'array'
    ];

    public function feeStructure(): BelongsTo
    {
        return $this->belongsTo(FeeStructure::class, 'fee_structure_id', 'uuid');
    }
}
