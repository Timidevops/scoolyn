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

Route::get('uploadExcel', function () {
    return view('Tenant.uploadExcel');
});

Route::get('results', function () {
    return view('Tenant.results');
});
Route::get('/', function () {
    return view('welcome');
});

Route::get('payment', function () {
    return view('Tenant.pages.payment.index');
});
Route::get('login', [\App\Http\Controllers\Tenant\Auth\LoginsController::class, 'form']);
Route::post('login', [\App\Http\Controllers\Tenant\Auth\LoginsController::class, 'login'])->name('login');

Route::group(['middleware' => ['web', WelcomesNewUsers::class]], function (){
    Route::get('set-password/{user}', [\App\Http\Controllers\Tenant\User\WelcomeUsersController::class, 'create'])->name('welcome');
    Route::post('set-password/{user}', [\App\Http\Controllers\Tenant\User\WelcomeUsersController::class, 'store'])->name('storeWelcomeUser');
});


Route::middleware('auth')->group(function (){

    Route::get('dashboard', [\App\Http\Controllers\Tenant\DashboardsController::class, 'index'])->name('dashboard');
    Route::post('logout', [\App\Http\Controllers\Tenant\DashboardsController::class, 'logout'])->name('logout');

    Route::post('user/change-password', [\App\Http\Controllers\Tenant\ChangePasswordsController::class, 'update'])->name('changePassword');

    Route::prefix('auth')->group(function (){

        Route::get('academic-session', [\App\Http\Controllers\Tenant\AcademicSession\AcademicSessionsController::class, 'create'])->name('academicSession');
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

        Route::get('student/subject/{uuid}', [\App\Http\Controllers\Tenant\Student\StudentSubjectsController::class, 'index'])->name('listStudentSubject');
        Route::get('student/subject/add-new/{uuid}', [\App\Http\Controllers\Tenant\Student\StudentSubjectsController::class, 'create'])->name('createStudentSubject');
        Route::post('student/subject/{uuid}', [\App\Http\Controllers\Tenant\Student\StudentSubjectsController::class, 'store'])->name('storeStudentSubject');

        Route::get('parent', [\App\Http\Controllers\Tenant\Parent\ParentsController::class, 'index'])->name('listParent');
        Route::get('parent/add-new', [\App\Http\Controllers\Tenant\Parent\ParentsController::class, 'create'])->name('createParent');
        Route::post('parent', [\App\Http\Controllers\Tenant\Parent\ParentsController::class, 'store'])->name('storeParent');

        Route::get('result/continuous-assessment-format', [\App\Http\Controllers\Tenant\Result\ContinuousAssessmentFormatsController::class, 'index'])->name('listCAStructure');
        Route::get('result/continuous-assessment-format/add-new', [\App\Http\Controllers\Tenant\Result\ContinuousAssessmentFormatsController::class, 'create'])->name('createCAStructure');
        Route::post('result/continuous-assessment-format', [\App\Http\Controllers\Tenant\Result\ContinuousAssessmentFormatsController::class, 'store'])->name('storeCAStructure');

        Route::get('result/academic-broadsheet', [\App\Http\Controllers\Tenant\Result\AcademicBroadsheetsController::class, 'index'])->name('listAcademicBroadsheet');
        Route::get('result/academic-broadsheet/{uuid}', [\App\Http\Controllers\Tenant\Result\AcademicBroadsheetsController::class, 'create'])->name('createAcademicBroadsheet');
        Route::post('result/academic-broadsheet/{uuid}', [\App\Http\Controllers\Tenant\Result\AcademicBroadsheetsController::class, 'store'])->name('storeAcademicBroadsheet');
        Route::patch('result/academic-broadsheet/{uuid}', [\App\Http\Controllers\Tenant\Result\AcademicBroadsheetsController::class, 'update'])->name('updateAcademicBroadsheet');

        Route::get('result/academic-result', [\App\Http\Controllers\Tenant\Result\AcademicResultsController::class, 'index'])->name('listAcademicResult');
        Route::get('result/academic-result/{uuid}', [\App\Http\Controllers\Tenant\Result\AcademicResultsController::class, 'single'])->name('singleAcademicResult');
        Route::get('result/academic-result/{classArmId}/{subjectId}/broadsheet', [\App\Http\Controllers\Tenant\Result\AcademicResultsController::class, 'singleSubject'])->name('singleAcademicResultBroadsheet');
        Route::post('result/academic-result/{classArmId}/{uuid}/broadsheet', [\App\Http\Controllers\Tenant\Result\AcademicResultsController::class, 'approval'])->name('academicResultApproval');

        Route::get('result/academic-grading', [\App\Http\Controllers\Tenant\Result\AcademicGradingFormatsController::class, 'index'])->name('listGradeFormat');
        Route::get('result/academic-grading/add-new', [\App\Http\Controllers\Tenant\Result\AcademicGradingFormatsController::class, 'create'])->name('createGradeFormat');
        Route::post('result/academic-grading', [\App\Http\Controllers\Tenant\Result\AcademicGradingFormatsController::class, 'store'])->name('storeGradeFormat');

        Route::get('result/report-sheet/{uuid}', [\App\Http\Controllers\Tenant\Result\ResultSheetsController::class, 'index'])->name('listReportSheet');
        Route::get('result/report-sheet/{uuid}/student/{id}', [\App\Http\Controllers\Tenant\Result\ResultSheetsController::class, 'single'])->name('singleReportSheet');

        Route::get('fee/format', [\App\Http\Controllers\Tenant\Fee\FeeStructuresController::class, 'index'])->name('listFeeStructure');
        Route::get('fee/format/add-new', [\App\Http\Controllers\Tenant\Fee\FeeStructuresController::class, 'create'])->name('createFeeStructure');
        Route::post('fee/format', [\App\Http\Controllers\Tenant\Fee\FeeStructuresController::class, 'store'])->name('storeFeeStructure');

        Route::post('fee/class', [\App\Http\Controllers\Tenant\Fee\ClassSectionsController::class, 'store'])->name('storeClassFee');

        Route::get('fee/student/{uuid}', [\App\Http\Controllers\Tenant\Fee\StudentFeesController::class, 'index'])->name('listStudentFee');
        Route::post('fee/student', [\App\Http\Controllers\Tenant\Fee\StudentFeesController::class, 'store'])->name('storeStudentFee');

        Route::post('school-fee/{uuid}', [\App\Http\Controllers\Tenant\Fee\SchoolFeesController::class, 'store'])->name('storeSchoolFee');

        Route::get('settings', [\App\Http\Controllers\Tenant\Setting\SettingsController::class, 'index'])->name('listSetting');

        Route::get('settings/change-password', [\App\Http\Controllers\Tenant\Setting\ChangePasswordsController::class, 'edit'])->name('changeAuthPassword');

    });

    Route::get('wards', [\App\Http\Controllers\Tenant\ParentDomain\Ward\WardsController::class, 'index'])->name('listWard');

    Route::get('ward/fees', [\App\Http\Controllers\Tenant\ParentDomain\Fee\FeesController::class, 'index'])->name('listWardFee');
    Route::get('fees/{uuid}/{studentId}', [\App\Http\Controllers\Tenant\ParentDomain\Fee\FeesController::class, 'single'])->name('singleWardFee');
    Route::post('fees/payment/{uuid}/{studentId}', [\App\Http\Controllers\Tenant\ParentDomain\Fee\FeesController::class, 'store'])->name('payWardFee');
    Route::get('fees/print-payment-receipt/{uuid}/{studentId}', [\App\Http\Controllers\Tenant\ParentDomain\Fee\PrintController::class, 'store'])->name('printWardFeeReceipt');


    Route::get('payment/call-back', [\App\Http\Controllers\Tenant\ParentDomain\Fee\CallbackFromCheckoutsController::class, 'update'])->middleware('callback.verify');
    Route::post('payment/call-back', [\App\Http\Controllers\Tenant\ParentDomain\Fee\CallbackFromCheckoutsController::class, 'update'])->middleware([
        'callback.verify',
        'callback.webhook'
    ]);

    Route::get('ward/result', [App\Http\Controllers\Tenant\ParentDomain\Result\ResultsController::class, 'index'])->name('listWardResult');
    Route::get('result/{uuid}/{studentId}', [\App\Http\Controllers\Tenant\ParentDomain\Result\ResultsController::class, 'single'])->name('singleWardResult');
    Route::get('result/print/{uuid}/{studentId}', [\App\Http\Controllers\Tenant\ParentDomain\Result\PrintController::class, 'store'])->name('printWardResult');


    Route::get('profile', [\App\Http\Controllers\Tenant\ParentDomain\Profile\UsersController::class, 'single'])->name('parentProfile');
    Route::patch('profile', [\App\Http\Controllers\Tenant\ParentDomain\Profile\UsersController::class, 'update'])->name('updateParentProfile');


});

//Route::middleware('tenant')->group(function() {
//    Route::get('/', function () {
//    return view('welcome');
//});
//});

//Route::domain('');
