<?php

namespace App\Models\Tenant;

use App\Http\Traits\Tenant\SchoolSessionTrait;
use App\Http\Traits\Tenant\SchoolTermTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubjectTeacher extends Model
{
    use HasFactory;
    use SoftDeletes;
    use SchoolTermTrait;
    use SchoolSessionTrait;

    protected $guarded = [];

    public function teacher(): HasOne
    {
        return $this->hasOne(Teacher::class, 'uuid', 'teacher_id');
    }

    public function subject(): HasOne
    {
        return $this->hasOne(Subject::class, 'uuid', 'subject_id');
    }

    public function schoolClass(): HasOne
    {
        return $this->hasOne(SchoolClass::class, 'uuid', 'school_class_id');
    }

    public function classSection(): HasOneThrough
    {
        return $this->hasOneThrough(ClassSectionType::class,ClassSection::class, 'uuid', 'uuid', 'class_section_id','class_section_types_id');
    }

    public function classSectionCategory(): HasOneThrough
    {
        return $this->hasOneThrough(ClassSectionCategoryType::class,ClassSectionCategory::class, 'uuid', 'uuid','class_section_category_id', 'class_section_category_types_id');
    }
}
