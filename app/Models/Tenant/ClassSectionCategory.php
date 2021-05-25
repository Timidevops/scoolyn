<?php

namespace App\Models\Tenant;

use App\Http\Traits\Tenant\SchoolSessionTrait;
use App\Http\Traits\Tenant\SchoolTermTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class ClassSectionCategory extends Model
{
    use HasFactory;
    use SoftDeletes;
    use SchoolTermTrait;
    use SchoolSessionTrait;
    use HasSlug;

    protected $guarded = [];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('category_name')
            ->saveSlugsTo('slug');
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

    public function academicBroadsheet(): MorphMany
    {
        return $this->morphMany(AcademicBroadSheet::class, 'schoolClass');
    }
}
