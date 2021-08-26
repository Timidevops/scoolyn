<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Parents extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

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
