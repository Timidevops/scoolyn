<?php

namespace App\Models\Tenant;

use App\Http\Traits\Tenant\AcademicSessionTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory;
    use AcademicSessionTrait;
    use SoftDeletes;

    protected $guarded = [];

    const CREDIT_TYPE =  'credit';

    public function schoolFees(): BelongsTo
    {
        return $this->belongsTo(SchoolFee::class, 'school_fees_id', 'uuid');
    }

}
