<?php

namespace App\Models\Tenant;

use App\Http\Traits\Tenant\SchoolSessionTrait;
use App\Http\Traits\Tenant\SchoolTermTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

class Student extends Model
{
    use HasFactory;
    use SoftDeletes;
    use UsesTenantConnection;

    protected $guarded = [];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Parents::class, 'parent_id', 'uuid');
    }

    public function subjects()
    {
        return $this->hasOne(StudentSubject::class, 'student_id', 'uuid');
    }

    public function academicReport(): HasMany
    {
        return $this->hasMany(AcademicResult::class, 'student_id', 'uuid');
    }

    public function schoolFee(): HasOne
    {
        return $this->hasOne(SchoolFee::class, 'student_id', 'uuid');
    }

    public function schoolReceipt(): HasMany
    {
        return $this->hasMany(SchoolReceipt::class, 'student_id', 'uuid');
    }

    public function classArm()
    {
        return $this->belongsTo(ClassArm::class, 'class_arm', 'uuid');
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public static function whereUuid(string $uuid)
    {
        return self::query()->where('uuid', $uuid)->first();
    }
}


