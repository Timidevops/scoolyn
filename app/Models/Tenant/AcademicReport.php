<?php

namespace App\Models\Tenant;

use App\Http\Traits\Tenant\SchoolSessionTrait;
use App\Http\Traits\Tenant\SchoolTermTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\ModelStatus\HasStatuses;

class AcademicReport extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasStatuses;
    use SchoolTermTrait;
    use SchoolSessionTrait;

    protected $guarded = [];

    protected $casts = [
        'meta' => 'array',
    ];
}
