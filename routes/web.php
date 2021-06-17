<?php

use Illuminate\Support\Facades\Route;
use Spatie\WelcomeNotification\WelcomesNewUsers;

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

Route::get('dashboard', function () {
    return view('Tenant.dashboard');
})->name('dashboard');


Route::get('student', function () {
    return view('Tenant.student');
});

Route::get('addStudent', function () {
    return view('Tenant.addStudent');
});

Route::get('uploadExcel', function () {
    return view('Tenant.uploadExcel');
});

Route::get('parents', function () {
    return view('Tenant.parents');
});

Route::get('addParent', function () {
    return view('Tenant.addParent');
});

Route::get('results', function () {
    return view('Tenant.results');
});
Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['web', WelcomesNewUsers::class]], function (){
    Route::get('set-password/{user}', [\App\Http\Controllers\Tenant\User\WelcomeUsersController::class, 'create'])->name('welcome');
    Route::post('set-password/{user}', [\App\Http\Controllers\Tenant\User\WelcomeUsersController::class, 'store'])->name('storeWelcomeUser');
});

Route::post('academic-session', [\App\Http\Controllers\Tenant\AcademicSession\AcademicSessionsController::class, 'store'])->name('storeAcademicSession');

Route::post('academic-term', [\App\Http\Controllers\Tenant\AcademicTerm\AcademicTermsController::class, 'store'])->name('storeAcademicTerm');

Route::post('setting/set-academic-calendar', [\App\Http\Controllers\Tenant\Setting\SetCurrentAcademicCalendarController::class, 'store'])->name('setAcademicCalendar');

Route::get('subject', [\App\Http\Controllers\Tenant\Subject\SubjectsController::class, 'index'])->name('listSubject');
Route::post('subject', [\App\Http\Controllers\Tenant\Subject\SubjectsController::class, 'store'])->name('storeSubject');

Route::get('subject-teacher/{uuid}', [\App\Http\Controllers\Tenant\Subject\SubjectTeachersController::class, 'index'])->name('listSubjectTeacher');
Route::post('subject/teacher', [\App\Http\Controllers\Tenant\Subject\SubjectTeachersController::class, 'store'])->name('storeSubjectTeacher');

Route::get('classes', [\App\Http\Controllers\Tenant\SchoolClass\SchoolClassesController::class, 'index'])->name('listClass');
Route::post('classes', [\App\Http\Controllers\Tenant\SchoolClass\SchoolClassesController::class, 'store'])->name('storeSchoolClass');

Route::get('class-subject/{uuid}', [\App\Http\Controllers\Tenant\SchoolClass\ClassSubjectsController::class, 'index'])->name('listClassSubject');

Route::get('class-teacher/{uuid}', [\App\Http\Controllers\Tenant\SchoolClass\ClassTeachersController::class, 'single'])->name('classTeacher');

Route::get('teacher', [\App\Http\Controllers\Tenant\Teacher\TeachersController::class, 'index'])->name('listTeacher');
Route::get('teacher/add-new', [\App\Http\Controllers\Tenant\Teacher\TeachersController::class, 'create'])->name('createTeacher');
Route::post('teacher', [\App\Http\Controllers\Tenant\Teacher\TeachersController::class, 'store'])->name('storeTeacher');

Route::get('student', [\App\Http\Controllers\Tenant\Student\StudentsController::class, 'index'])->name('listStudent');
Route::get('student/add-new', [\App\Http\Controllers\Tenant\Student\StudentsController::class, 'create'])->name('createStudent');
Route::post('student', [\App\Http\Controllers\Tenant\Student\StudentsController::class, 'store'])->name('storeStudent');

Route::post('student/subject', [\App\Http\Controllers\Tenant\Student\StudentSubjectsController::class, 'store'])->name('storeStudentSubject');

Route::post('parent', [\App\Http\Controllers\Tenant\Parent\ParentsController::class, 'store'])->name('storeParent');

Route::get('result/continuous-assessment-format/add-new', [\App\Http\Controllers\Tenant\Result\ContinuousAssessmentFormatsController::class, 'create'])->name('createCAStructure');
Route::post('result/continuous-assessment-format', [\App\Http\Controllers\Tenant\Result\ContinuousAssessmentFormatsController::class, 'store'])->name('storeCAStructure');

Route::get('result/academic-broadsheet', [\App\Http\Controllers\Tenant\Result\AcademicBroadsheetsController::class, 'create'])->name('createAcademicBroadsheet');
Route::post('result/academic-broadsheet', [\App\Http\Controllers\Tenant\Result\AcademicBroadsheetsController::class, 'store'])->name('storeAcademicBroadsheet');

Route::post('result/academic-report/{uuid}', [\App\Http\Controllers\Tenant\Result\AcademicReportsController::class, 'store'])->name('storeAcademicReport');

Route::post('fee/format', [\App\Http\Controllers\Tenant\Fee\FeeStructuresController::class, 'store'])->name('storeFeeStructure');

Route::post('fee/class', [\App\Http\Controllers\Tenant\Fee\ClassSectionsController::class, 'store'])->name('storeClassFee');

Route::post('fee/student', [\App\Http\Controllers\Tenant\Fee\StudentFeesController::class, 'store'])->name('storeStudentFee');

Route::post('school-fee/{uuid}', [\App\Http\Controllers\Tenant\Fee\SchoolFeesController::class, 'store'])->name('storeSchoolFee');

//Route::middleware('tenant')->group(function() {
//    Route::get('/', function () {
//    return view('welcome');
//});
//});

//Route::domain('');
