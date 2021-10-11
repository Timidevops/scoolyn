<?php

namespace App\Models\Landlord;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;

class FeatureAddon extends Model
{
    use HasFactory;
    use SoftDeletes;
    use UsesLandlordConnection;

    protected $guarded = [];

    public static function whereUuid(string $uuid)
    {
        return self::query()->where('uuid', $uuid);
    }

    public static function whereName(string $name)
    {
        return self::query()->where('name', $name);
    }

}
