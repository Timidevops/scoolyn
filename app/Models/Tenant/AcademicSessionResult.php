<?php

namespace App\Models\Tenant;

use App\Http\Traits\Tenant\AcademicSessionTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\ModelStatus\HasStatuses;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

class AcademicSessionResult extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasStatuses;
    use AcademicSessionTrait;
    use UsesTenantConnection;

    const PENDING_STATUS = 'pending_status';
    const ACTIVE_STATUS = 'active_status';

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
