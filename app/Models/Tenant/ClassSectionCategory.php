<?php

namespace App\Models\Tenant;

use App\Http\Traits\Tenant\SchoolSessionTrait;
use App\Http\Traits\Tenant\SchoolTermTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

class ClassSectionCategory extends Model
{
    use HasFactory;
    use SoftDeletes;
    use SchoolTermTrait;
    use SchoolSessionTrait;
    use UsesTenantConnection;

    protected $guarded = [];

    public function classSectionCategory()
    {
        return $this->belongsTo(ClassSection::class, 'class_section_id', 'uuid');
    }

    public function classSectionCategoryType()
    {
        return $this->belongsTo(ClassSectionCategoryType::class, 'class_section_category_types_id', 'uuid');
    }

    public function subjectTeacher(): MorphMany
    {
        return $this->morphMany(SubjectTeacher::class, 'schoolClass');
    }

    public function schoolClass(): MorphMany
    {
        return $this->morphMany(AcademicBroadSheet::class, 'schoolClass');
    }

    public function academicBroadsheet(): MorphMany
    {
        return $this->morphMany(AcademicBroadSheet::class, 'schoolClass');
    }
}
