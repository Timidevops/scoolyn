<?php

namespace App\Models\Tenant;

use App\Http\Traits\Tenant\AcademicSessionTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\ModelStatus\HasStatuses;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

class SchoolFee extends Model
{
    use HasFactory;
    use SoftDeletes;
    use AcademicSessionTrait;
    use HasStatuses;
    use UsesTenantConnection;

    const NOT_PAID_STATUS = 'not paid';
    const PAID_STATUS = 'paid';
    const NOT_COMPLETE = 'not complete';

    protected $guarded = [];

    protected $casts = [
        'fee_structure_id' => 'array',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'uuid');
    }

    public function academicSession()
    {
        return $this->hasOne(AcademicSession::class, 'uuid', 'academic_session_id');
    }

    public function academicTerm()
    {
        return $this->hasOne(AcademicTerm::class, 'uuid', 'academic_term_id');
    }
}
