<?php

namespace App\Models\Tenant;

use App\Http\Traits\Tenant\AcademicSessionTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

class ClassSubject extends Model
{
    use HasFactory;
    use SoftDeletes;
    use AcademicSessionTrait;
    use UsesTenantConnection;

    protected $guarded = [];

    protected $casts = [
        'class_arm' => 'array',
    ];

    protected static function booted()
    {
        parent::boot();

        if (auth()->check()) {
            if ( ! Auth::user()->hasRole(User::SUPER_ADMIN_USER) ) {

                $teacher = Teacher::whereUserId(Auth::user()->uuid)->first();

                static::addGlobalScope('teacher', function (Builder $builder) use($teacher) {
                    $builder->where('teacher_id', $teacher->uuid);
                });
            }
        }
    }

    public function academicBroadsheet()
    {
        return $this->hasMany(AcademicBroadSheet::class, 'class_subject_id', 'uuid');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(SchoolSubject::class, 'subject_id', 'uuid');
    }

    public function teacher(): HasOne
    {
        return $this->hasOne(Teacher::class, 'uuid', 'teacher_id');
    }

    public function getClassArm(string $uuid)
    {
        return ClassArm::withoutGlobalScope('teacher')->where('uuid', $uuid)->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getClassArmsByClassSectionId()
    {
        return ClassArm::withoutGlobalScope('teacher')
            ->where('school_class_id', $this->school_class_id)
            ->where('class_section_id', $this->class_section_id)->get();
    }

    /**
     * @return mixed
     */
    public function getClassArmsByClassSectionCategoryId()
    {
        return ClassArm::withoutGlobalScope('teacher')
            ->where('school_class_id', $this->school_class_id)
            ->where('class_section_id', $this->class_section_id)
            ->where('class_section_category_id', $this->class_section_category_id)->get();
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
        return$this->belongsTo(ClassSectionCategory::class, 'class_section_category_id', 'uuid');
    }

    public function classSectionType(): HasOneThrough
    {
        return $this->hasOneThrough(ClassSectionType::class,ClassSection::class, 'uuid', 'uuid', 'class_section_id','class_section_types_id');
    }

    public function classSectionCategoryType(): HasOneThrough
    {
        return $this->hasOneThrough(ClassSectionCategoryType::class,ClassSectionCategory::class, 'uuid', 'uuid','class_section_category_id', 'class_section_category_types_id');
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public static function whereUuid(string $uuid)
    {
        return self::query()->where('uuid', $uuid);
    }
}
