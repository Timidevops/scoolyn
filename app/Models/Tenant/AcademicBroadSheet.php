<?php

namespace App\Models\Tenant;

use App\Http\Traits\Tenant\AcademicSessionTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\ModelStatus\HasStatuses;

class AcademicBroadSheet extends Model
{
    use HasFactory;
    use SoftDeletes;
    use AcademicSessionTrait;
    use HasStatuses;

    const CREATED_STATUS = 'created';
    const SUBMITTED_STATUS = 'submitted';
    const APPROVED_STATUS = 'approved';
    const NOT_APPROVED_STATUS = 'not-approved';

    protected $guarded = [];

    protected $casts = [
        'meta' => 'array'
    ];

}
