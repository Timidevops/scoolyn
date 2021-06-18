<?php

namespace App\Models\Tenant;

use App\Http\Traits\Tenant\SchoolSessionTrait;
use App\Http\Traits\Tenant\SchoolTermTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{
    use HasFactory;
    use SoftDeletes;
    use SchoolTermTrait;
    use SchoolSessionTrait;

    protected $guarded = [];

    public function classTeacher(): HasOne
    {
        return $this->hasOne(ClassTeacher::class,'teacher_id','uuid');
    }

    public function subjectTeacher(): HasMany
    {
        return $this->hasMany(ClassSubject::class, 'teacher_id', 'uuid');
    }

}
