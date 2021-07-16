<?php

namespace App\Models\Tenant;

use App\Http\Traits\Tenant\SchoolSessionTrait;
use App\Http\Traits\Tenant\SchoolTermTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Subject extends Model
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
            ->generateSlugsFrom('subject_name')
            ->saveSlugsTo('slug');
    }

    public function schoolSubject()
    {
        return $this->hasOne(SchoolSubject::class, 'subject_id', 'uuid');
    }

    public function subjectTeacher(): HasMany
    {
        return $this->hasMany(SubjectTeacher::class, 'subject_id', 'uuid');
    }

    public function classSubject(): HasMany
    {
        return $this->hasMany(ClassSubject::class, 'subject_id', 'uuid');
    }

    public function getRouteKeyName()
    {
        return "uuid";
    }
}
