<?php

namespace App\Models\Tenant;

use App\Http\Traits\Tenant\SchoolSessionTrait;
use App\Http\Traits\Tenant\SchoolTermTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class SchoolClass extends Model
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
            ->generateSlugsFrom('class_name')
            ->saveSlugsTo('slug');
    }

    public function classSection()
    {
        return $this->hasMany(ClassSection::class, 'school_class_id', 'uuid');
    }

    public function classSectionType(): HasManyThrough
    {
        return $this->hasManyThrough(ClassSectionType::class,ClassSection::class, 'school_class_id', 'uuid', 'uuid','class_section_types_id');
    }

    public function subject(): HasMany
    {
        return $this->hasMany(ClassSubject::class, 'school_class_id', 'uuid');
    }

    public function classTeacher(): HasMany
    {
        return $this->hasMany(ClassTeacher::class, 'school_class_id', 'uuid');
    }

}
