<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('academic-session', [\App\Http\Controllers\Tenant\AcademicSession\AcademicSessionsController::class, 'store'])->name('storeAcademicSession');

Route::post('academic-term', [\App\Http\Controllers\Tenant\AcademicTerm\AcademicTermsController::class, 'store'])->name('storeAcademicTerm');

Route::post('setting/set-academic-calendar', [\App\Http\Controllers\Tenant\Setting\SetCurrentAcademicCalendarController::class, 'store'])->name('setAcademicCalendar');

Route::post('subject', [\App\Http\Controllers\Tenant\Subject\SubjectsController::class, 'store'])->name('storeSubject');

Route::post('class', [\App\Http\Controllers\Tenant\SchoolClass\SchoolClassesController::class, 'store'])->name('storeSchoolClass');

Route::post('class/subject', [\App\Http\Controllers\Tenant\SchoolClass\ClassSubjectsController::class, 'store'])->name('storeClassSubject');

Route::post('class/teacher', [\App\Http\Controllers\Tenant\SchoolClass\ClassTeachersController::class, 'store'])->name('storeClassTeacher');

Route::post('teacher', [\App\Http\Controllers\Tenant\Teacher\TeachersController::class, 'store'])->name('storeTeacher');

//Route::middleware('tenant')->group(function() {
//    Route::get('/', function () {
//    return view('welcome');
//});
//});

//Route::domain('');
