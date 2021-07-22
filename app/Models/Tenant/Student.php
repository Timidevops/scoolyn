<?php

namespace App\Models\Tenant;

use App\Http\Traits\Tenant\SchoolSessionTrait;
use App\Http\Traits\Tenant\SchoolTermTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory;
    use SoftDeletes;
    use SchoolTermTrait;
    use SchoolSessionTrait;

    protected $guarded = [];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Parents::class, 'parent_id', 'uuid');
    }

    public function subjects()
    {
        return $this->hasOne(StudentSubject::class, 'student_id', 'uuid');
    }

    public function academicReport(): HasMany
    {
        return $this->hasMany(AcademicReport::class, 'student_id', 'uuid');
    }

    public function studentFee(): HasMany
    {
        return $this->hasMany(StudentFee::class, 'student_id', 'uuid');
    }

    public function schoolFee(): HasMany
    {
        return $this->hasMany(SchoolFee::class, 'student_id', 'uuid');
    }

    public function schoolReceipt(): HasMany
    {
        return $this->hasMany(SchoolReceipt::class, 'student_id', 'uuid');
    }

//    public function schoolClass(): BelongsTo
//    {
//        return $this->belongsTo(SchoolClass::class, 'school_class_id', 'uuid');
//    }

    public function classArm()
    {
        return $this->belongsTo(ClassArm::class, 'class_arm', 'uuid');
    }

//    public function classSection(): HasOneThrough
//    {
//        return $this->hasOneThrough(ClassSectionType::class,ClassSection::class, 'uuid', 'uuid', 'class_section_id','class_section_types_id');
//    }
//
//    public function classSectionCategory(): HasOneThrough
//    {
//        return $this->hasOneThrough(ClassSectionCategoryType::class,ClassSectionCategory::class, 'uuid', 'uuid','class_section_category_id', 'class_section_category_types_id');
//    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}

//<<<<<<< HEAD
//                    <div class="relative" x-data="{ show: false}">
//                        <button  class="cursor-pointer flex focus:outline-none items-center w-56 px-8 py-4 text-base  font-medium leading-6 rounded-md  text-gray-300 focus:bg-blue-100 focus:text-white" x-on:click="show = !show">
//                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-4 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" >
//                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
//                            </svg>
//                            <span class="focus:text-white">Results</span>
//                        </button >
//                        <ul class="" x-show="show">
//                            <li>
//                                <a href="{{route('listCAStructure')}}" class=" flex items-center  px-8 py-4 text-base leading-6 font-medium rounded-md text-gray-300 focus:bg-blue-100 focus:text-white">
//                                    <span class="focus:text-white">Continuous Assessment Format</span>
//                                </a>
//                            </li>
//                            <li>
//                                <a href="{{route('listAcademicBroadsheet')}}" class=" flex items-center  px-8 py-4 text-base leading-6 font-medium rounded-md text-gray-300 focus:bg-blue-100 focus:text-white">
//                                    <span class="focus:text-white">Academic Broadsheet</span>
//                                </a>
//                            </li>
//                            <li>
//                                <a href="{{route('listAcademicResult')}}" class=" flex items-center  px-8 py-4 text-base leading-6 font-medium rounded-md text-gray-300 focus:bg-blue-100 focus:text-white">
//                                    <span class="focus:text-white">Academic Results</span>
//                                </a>
//                            </li>
//                            <li>
//                                <a href="{{route('listGradeFormat')}}" class=" flex items-center px-8 py-4 text-base leading-6 font-medium rounded-md text-gray-300 focus:bg-blue-100 focus:text-white">
//                                    <span class="focus:text-white">Academic Grading Format</span>
//                                </a>
//                            </li>
//                        </ul>
//                    </div>
//
//                    <div class="relative" x-data="{ show: false}">
//                        <button  class="cursor-pointer flex focus:outline-none items-center w-56 px-8 py-4 text-base  font-medium leading-6 rounded-md  text-gray-300 focus:bg-blue-100 focus:text-white" x-on:click="show = !show">
//                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-4 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
//=======

