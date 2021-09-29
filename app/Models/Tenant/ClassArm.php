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
    const RESULT_ERROR_STATUS = 'error_generating_result';
    const NEW_REPORT_STATUS = 'new_report_status';
    const SESSION_REPORT_GENERATED_STATUS = 'session_report_generated';
    const SESSION_REPORT_ERROR_STATUS = 'error_generating_session_report';
    const SESSION_COMPLETED_STATUS = 'session_completed';

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

    public function academicResultWithCurrentReport(): HasMany
    {
        return $this->hasMany(AcademicResult::class, 'class_arm', 'uuid')
            ->where('report_card', Setting::getCurrentCardBreakdownFormat());
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

    public function getClassSubjects(bool $withScope = true, string $newAcademicSession = '')
    {
        $classSubjects =  $this->classSubject();
        if ( ! $withScope ){
           $classSubjects =  $this->classSubject()
               ->withoutGlobalScope('academicSession')
               ->where('academic_session_id', $newAcademicSession);
        }

        return $classSubjects->get()->map(function ($classSubject){
            if( $classSubject->classArm ){
                return $classSubject;
            }
            elseif( $classSubject->class_section_id === $this->class_section_id && $classSubject->class_section_category_id == $this->class_section_category_id ){
                return $classSubject;
            }
            else{
                return $classSubject;
            }
        });
    }

    public function hasStudent(string $studentId)
    {
        return (collect($this->students)->contains($studentId));
    }

    public function getStudents()
    {
        return collect($this->students)->map(function ($student){
            return Student::whereUuid($student);
        });
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
