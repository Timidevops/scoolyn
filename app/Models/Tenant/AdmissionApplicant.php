<?php

namespace App\Models\Tenant;

use App\Http\Traits\Tenant\AcademicSessionTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdmissionApplicant extends Model
{
    use HasFactory;
    use SoftDeletes;
    use AcademicSessionTrait;

    const APPLIED_STATUS = 'applied';
    const EXAM_SCHEDULED_STATUS = 'exam_scheduled';
    const ADMITTED_STATUS = 'admitted';
    const REJECTED_STATUS = 'rejected';
    const CLASS_ARM_ADDED = 'class_designated';

    protected $guarded = [];
}
