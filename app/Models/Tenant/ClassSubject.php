<?php

namespace App\Models\Tenant;

use App\Http\Traits\Tenant\SchoolSessionTrait;
use App\Http\Traits\Tenant\SchoolTermTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassSubject extends Model
{
    use HasFactory;
    use SoftDeletes;
    use SchoolTermTrait;
    use SchoolSessionTrait;

    protected $guarded = [];

    protected $casts = [
        'class_arm' => 'array'
    ];

    public function academicBroadsheet()
    {
        return $this->hasOne(AcademicBroadSheet::class, 'class_subject_id', 'uuid');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'uuid');
    }

    public function teacher(): HasOne
    {
        return $this->hasOne(Teacher::class, 'uuid', 'teacher_id');
    }

    public function getClassArm(string $uuid)
    {
        return ClassArm::query()->where('uuid', $uuid)->first();
    }

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'school_class_id', 'uuid');
    }

    public function classSection(): BelongsTo
    {
        return $this->belongsTo(ClassSection::class, 'class_section_id', 'uuid');
    }

    public function classSectionCategory(): BelongsTo
    {
        return$this->belongsTo(ClassSectionCategory::class, 'class_section_category_id', 'uuid');
    }

    public function classSectionType(): HasOneThrough
    {
        return $this->hasOneThrough(ClassSectionType::class,ClassSection::class, 'uuid', 'uuid', 'class_section_id','class_section_types_id');
    }

    public function classSectionCategoryType(): HasOneThrough
    {
        return $this->hasOneThrough(ClassSectionCategoryType::class,ClassSectionCategory::class, 'uuid', 'uuid','class_section_category_id', 'class_section_category_types_id');
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
