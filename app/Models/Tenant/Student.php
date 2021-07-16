<?php

namespace App\Models\Tenant;

use App\Http\Traits\Tenant\SchoolSessionTrait;
use App\Http\Traits\Tenant\SchoolTermTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory;
    use SoftDeletes;
    use SchoolTermTrait;
    use SchoolSessionTrait;

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
        return $this->hasMany(AcademicReport::class, 'student_id', 'uuid');
    }

    public function studentFee(): HasMany
    {
        return $this->hasMany(StudentFee::class, 'student_id', 'uuid');
    }

    public function schoolFee(): HasMany
    {
        return $this->hasMany(SchoolFee::class, 'student_id', 'uuid');
    }

    public function schoolReceipt(): HasMany
    {
        return $this->hasMany(SchoolReceipt::class, 'student_id', 'uuid');
    }

//    public function schoolClass(): BelongsTo
//    {
//        return $this->belongsTo(SchoolClass::class, 'school_class_id', 'uuid');
//    }

    public function classArm()
    {
        return $this->belongsTo(ClassArm::class, 'class_arm', 'uuid');
    }

//    public function classSection(): HasOneThrough
//    {
//        return $this->hasOneThrough(ClassSectionType::class,ClassSection::class, 'uuid', 'uuid', 'class_section_id','class_section_types_id');
//    }
//
//    public function classSectionCategory(): HasOneThrough
//    {
//        return $this->hasOneThrough(ClassSectionCategoryType::class,ClassSectionCategory::class, 'uuid', 'uuid','class_section_category_id', 'class_section_category_types_id');
//    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
