<?php

namespace App\Models\Tenant;

use App\Http\Traits\Tenant\AcademicSessionTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\ModelStatus\HasStatuses;

class ClassArm extends Model
{
    use HasFactory;
    use SoftDeletes;
    //use AcademicSessionTrait;
    use HasStatuses;

    const GENERATING_RESULT_STATUS = 'generating_result';
    const RESULT_GENERATED_STATUS = 'result_generated';
    const RESULT_INCOMPLETE_STATUS = 'result_incomplete';

    protected $guarded = [];

    protected $casts = [
        'students' => 'array',
    ];

    public function academicResult(): HasMany
    {
        return $this->hasMany(AcademicResult::class, 'class_arm', 'uuid');
    }

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'school_class_id', 'uuid');
    }

    public function classSection(): BelongsTo
    {
        return $this->belongsTo(ClassSectionType::class, 'class_section_id', 'uuid');
    }

    public function classSectionCategory(): BelongsTo
    {
        return $this->belongsTo(ClassSectionCategoryType::class, 'class_section_category_id', 'uuid');
    }

//    public function classSectionType(): HasOneThrough
//    {
//        return $this->hasOneThrough(ClassSectionType::class,ClassSection::class, 'uuid', 'uuid', 'class_section_id','class_section_types_id');
//    }
//
//    public function classSectionCategoryType(): HasOneThrough
//    {
//        return $this->hasOneThrough(ClassSectionCategoryType::class,ClassSectionCategory::class, 'uuid', 'uuid','class_section_category_id', 'class_section_category_types_id');
//    }

    public function classSubject()
    {
        return $this->hasMany(ClassSubject::class, 'school_class_id', 'school_class_id');
    }

    public function teacher()
    {
        return $this->hasOne(Teacher::class, 'uuid', 'class_teacher');
    }


}
