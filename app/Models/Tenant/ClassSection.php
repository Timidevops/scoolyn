<?php

namespace App\Models\Tenant;

use App\Http\Traits\Tenant\SchoolSessionTrait;
use App\Http\Traits\Tenant\SchoolTermTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassSection extends Model
{
    use HasFactory;
    use SoftDeletes;
    use SchoolTermTrait;
    use SchoolSessionTrait;

    protected $guarded = [];

    public function classSectionCategory(): HasOneThrough
    {
        return $this->hasOneThrough(ClassSectionCategoryType::class, ClassSectionCategory::class, 'class_section_id', 'uuid', 'uuid', 'class_section_category_types_id');
    }

    public function classTeacher(): MorphOne
    {
        return $this->morphOne(ClassTeacher::class, 'schoolClass');
    }

    public function subjectTeacher(): MorphMany
    {
        return $this->morphMany(SubjectTeacher::class, 'schoolClass');
    }

    public function schoolClass(): MorphMany
    {
        return $this->morphMany(AcademicBroadSheet::class, 'schoolClass');
    }

    public function classFee(): HasMany
    {
        return $this->hasMany(ClassFee::class,'class_section_id', 'uuid');
    }

    public function academicBroadsheet(): MorphMany
    {
        return $this->morphMany(AcademicBroadSheet::class, 'schoolClass');
    }
}
