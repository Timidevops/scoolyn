<?php

namespace App\Models\Tenant;

use App\Http\Traits\Tenant\SchoolSessionTrait;
use App\Http\Traits\Tenant\SchoolTermTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\ModelStatus\HasStatuses;

class AcademicResult extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasStatuses;
    use SchoolTermTrait;
    use SchoolSessionTrait;
    use HasStatuses;

    const PENDING_RESULT_STATUS = 'pending_result';
    const APPROVED_RESULT_STATUS = 'approved_result';
    const DISAPPROVED_RESULT_STATUS = 'disapproved_result';

    protected $guarded = [];

    protected $casts = [
        'subjects' => 'array',
        'ca_format' => 'array',
        'grading_format' => 'array',
    ];
}
