<?php

namespace App\Models\Landlord;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;

class Marketer extends Model
{
    use HasFactory;
    use SoftDeletes;
    use UsesLandlordConnection;

    protected $guarded = [];

    public static function whereMarketerCode(string $code)
    {
        return self::query()->where('marketer_code', $code);
    }
}
