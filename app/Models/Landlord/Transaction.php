<?php

namespace App\Models\Landlord;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;

class Transaction extends Model
{
    use HasFactory;
    use SoftDeletes;
    use UsesLandlordConnection;

    protected $guarded = [];

    public static function whereReference(string $reference)
    {
        return self::query()->where('reference', $reference);
    }

    public function featureAddon(): BelongsTo
    {
        return $this->belongsTo(FeatureAddon::class, 'addon_id', 'uuid');
    }
}
