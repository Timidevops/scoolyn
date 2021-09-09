<?php

namespace App\Models\Landlord;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;

class Feature extends Model
{
    use HasFactory;
    use SoftDeletes;
    use UsesLandlordConnection;

    const TOTAL_NUMBER_OF_STUDENT = 'number of students';
    const TOTAL_NUMBER_OF_STUDENT_SLUG = 'number-of-students';
    const ADMISSION_AUTOMATION = 'admission automation';

    protected $guarded = [];

    public static function whereUuid(string $uuid)
    {
        return self::query()->where('uuid', $uuid);
    }
}
