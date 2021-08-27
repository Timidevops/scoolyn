<?php

namespace App\Models\Tenant;

use App\Http\Traits\Tenant\SchoolSessionTrait;
use App\Http\Traits\Tenant\SchoolTermTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Teacher extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function classArm(): HasMany
    {
        return $this->hasMany(ClassArm::class, 'class_teacher', 'uuid');
    }

    public function subjectTeacher(): HasMany
    {
        return $this->hasMany(ClassSubject::class, 'teacher_id', 'uuid');
    }

    public static function whereUserId(string $uuid)
    {
        return self::query()->where('user_id', $uuid);
    }

    public static function whereUuid(string $uuid)
    {
        return self::query()->where('uuid', $uuid)->firstOrFail();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'uuid');
    }

}
