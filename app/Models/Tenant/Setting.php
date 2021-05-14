<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Setting extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasSlug;

    const ACADEMIC_CALENDAR_SETTING = 'current academic calendar';

    protected $guarded = [];

    protected $casts = [
        'meta' => 'array',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('setting_name')
            ->saveSlugsTo('slug');
    }
}
