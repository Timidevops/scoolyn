<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

class StudentParent extends Model
{
    use HasFactory;
    use SoftDeletes;
    use UsesTenantConnection;

    protected $guarded = [];
    protected $table = 'parents';

    protected static function booted()
    {
        static::addGlobalScope('dummyParent', function (Builder $builder) {
            $builder->where('id', '!=', 1);
        });
    }

    public function ward(): HasMany
    {
        return $this->hasMany(Student::class, 'parent_id', 'uuid');
    }

}
