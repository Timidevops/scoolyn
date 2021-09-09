<?php

namespace App\Models\Landlord;

use App\Models\Tenant\ScoolynTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;

class PlanFeatureAddon extends Model
{
    use HasFactory;
    use SoftDeletes;
    use UsesLandlordConnection;

    protected $guarded = [];

    public static function getPlanFeatureAddon()
    {
        return self::query()->where('subscriber_id', ScoolynTenant::current()->id)->first();
    }

    public function featureAddon(): BelongsTo
    {
        return $this->belongsTo(FeatureAddon::class, 'feature_addon_id', 'id');
    }
}
