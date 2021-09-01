<?php

namespace App\Models\Tenant;

use App\Http\Traits\Tenant\SchoolSessionTrait;
use App\Http\Traits\Tenant\SchoolTermTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class AcademicSession extends Model
{
    use HasFactory;
    use SoftDeletes;
    use SchoolTermTrait;
    use SchoolSessionTrait;
    use HasSlug;
    use UsesTenantConnection;

    protected $guarded = [];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('session_name')
            ->saveSlugsTo('slug');
    }

}
