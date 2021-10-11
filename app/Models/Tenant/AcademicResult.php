<?php

namespace App\Models\Tenant;

use App\Http\Traits\Tenant\ResultSessionTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\ModelStatus\HasStatuses;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

class AcademicResult extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasStatuses;
    use ResultSessionTrait;
    use UsesTenantConnection;

    const PENDING_RESULT_STATUS = 'pending_result';
    const APPROVED_RESULT_STATUS = 'approved_result';
    const DISAPPROVED_RESULT_STATUS = 'disapproved_result';

    protected $guarded = [];

    protected $casts = [
        'subjects' => 'array',
        'ca_format' => 'array',
        'grading_format' => 'array',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id', 'uuid');
    }

    public function classArm(): BelongsTo
    {
        return $this->belongsTo(ClassArm::class, 'class_arm', 'uuid')->withoutGlobalScope('teacher');
    }

    public function academicSession(): HasOne
    {
        return $this->hasOne(AcademicSession::class, 'uuid', 'academic_session_id');
    }

    public function getTerm(): HasOne
    {
        return $this->hasOne(AcademicTerm::class, 'uuid', 'term');
    }

    public function getReportCard(): HasOne
    {
        return $this->hasOne(ReportCardBreakdownFormat::class, 'uuid', 'report_card');
    }

}
