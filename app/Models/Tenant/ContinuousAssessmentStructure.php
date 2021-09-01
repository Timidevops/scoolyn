<?php

namespace App\Models\Tenant;

use App\Http\Traits\Tenant\SchoolSessionTrait;
use App\Http\Traits\Tenant\SchoolTermTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class ContinuousAssessmentStructure extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasSlug;
    use UsesTenantConnection;

    protected $guarded = [];

    protected $casts = [
        'meta' => 'array',
        'school_class' => 'array',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

}
