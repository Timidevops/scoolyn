<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

class ReportCardBreakdownFormat extends Model
{
    use HasFactory;
    use SoftDeletes;
    use UsesTenantConnection;

    protected $guarded = [];

    public static function whereUuid(string $uuid)
    {
        return self::query()->where('uuid', $uuid)->first();
    }
}
