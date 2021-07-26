<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassSection extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function classSectionType(): BelongsTo
    {
        return $this->belongsTo(ClassSectionType::class, 'class_section_types_id', 'uuid');
    }

    public function classSectionCategory(): HasMany
    {
        return $this->hasMany(ClassSectionCategory::class, 'class_section_id', 'uuid');
    }

    public function classSectionCategoryType(): HasOneThrough
    {
        return $this->hasOneThrough(ClassSectionCategoryType::class, ClassSectionCategory::class, 'class_section_id', 'uuid', 'uuid', 'class_section_category_types_id');
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
