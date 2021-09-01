<?php

namespace App\Models\Tenant;

use App\Http\Traits\Tenant\AcademicSessionTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Spatie\ModelStatus\HasStatuses;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

class ClassArm extends Model
{
    use HasFactory;
    use SoftDeletes;
    use AcademicSessionTrait;
    use HasStatuses;
    use UsesTenantConnection;

    const GENERATING_RESULT_STATUS = 'generating_result';
    const RESULT_GENERATED_STATUS = 'result_generated';
    const RESULT_INCOMPLETE_STATUS = 'result_incomplete';

    protected $guarded = [];

    protected $casts = [
        'students' => 'array',
    ];

    protected static function booted()
    {
        parent::boot();
        if (auth()->check()) {

            if ( ! Auth::user()->hasRole(User::SUPER_ADMIN_USER) ) {

                $teacher = Teacher::whereUserId(Auth::user()->uuid)->first();

                if ( ! $teacher ){
                    abort(404);
                }

                static::addGlobalScope('teacher', function (Builder $builder) use($teacher) {
                    $builder->where('class_teacher', $teacher->uuid);
                });
            }
        }
    }

    public function academicResult(): HasMany
    {
        return $this->hasMany(AcademicResult::class, 'class_arm', 'uuid');
    }

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'school_class_id', 'uuid');
    }

    public function classSection(): BelongsTo
    {
        return $this->belongsTo(ClassSectionType::class, 'class_section_id', 'uuid');
    }

    public function classSectionCategory(): BelongsTo
    {
        return $this->belongsTo(ClassSectionCategoryType::class, 'class_section_category_id', 'uuid');
    }

    public function classSubject()
    {
        return $this
            ->hasMany(ClassSubject::class, 'school_class_id', 'school_class_id')
            ->withoutGlobalScope('teacher');
    }

    public function teacher()
    {
        return $this->hasOne(Teacher::class, 'uuid', 'class_teacher');
    }

    public static function whereUuid(string $uuid)
    {
        return self::query()->where('uuid', $uuid);
    }

}
