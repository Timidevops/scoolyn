<?php

namespace App\Models\Tenant;

use App\Http\Traits\Tenant\AcademicSessionTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

class StudentSubject extends Model
{
    use HasFactory;
    use SoftDeletes;
    use AcademicSessionTrait;
    use UsesTenantConnection;

    protected $guarded = [];

    protected $casts = [
        'subjects' => 'array'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'uuid');
    }
}
