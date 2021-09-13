<?php

namespace App\Models\Tenant;

use App\Http\Traits\Tenant\AcademicSessionTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\ModelStatus\HasStatuses;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

class AcademicResult extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasStatuses;
    use AcademicSessionTrait;
    use HasStatuses;
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

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'uuid');
    }

    public function classArm()
    {
        return $this->belongsTo(ClassArm::class, 'class_arm', 'uuid');
    }

    public function academicSession()
    {
        return $this->hasOne(AcademicSession::class, 'uuid', 'academic_session_id');
    }

}
