<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class SchoolSubject extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasSlug;
    use UsesTenantConnection;

    protected $guarded = [];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('subject_name')
            ->saveSlugsTo('slug');
    }

    public function classSubject(): HasMany
    {
        return $this->hasMany(ClassSubject::class, 'subject_id', 'uuid');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'uuid');
    }

    public function getRouteKeyName()
    {
        return "uuid";
    }

    public static function whereUuid(string $uuid)
    {
        return self::query()->where('uuid', $uuid)->first();
    }
}
