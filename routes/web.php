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

Route::get('plan/payment/{uuid}', [\App\Http\Controllers\Landlord\SubscriptionPaymentsController::class, 'create']);
Route::post('plan/payment', [\App\Http\Controllers\Landlord\SubscriptionPaymentsController::class, 'store'])->name('storePlan');

//@todo add middleware...
Route::get('checkout/payment/call-back', [\App\Http\Controllers\Landlord\SubscriptionPaymentCallbacksController::class, 'update']);
Route::post('checkout/payment/call-back');

Route::middleware('landlord.checkOnboard')->group(function (){
    Route::get('onboarding/{uuid}', [\App\Http\Controllers\Landlord\OnboardingsController::class, 'create'])->name('appOnboarding');
    Route::post('onboarding/{uuid}', [\App\Http\Controllers\Landlord\OnboardingsController::class, 'store'])->name('storeAppOnboarding');
});

Route::middleware(['landlord.checkCurrentTenant'])->group(function (){
    Route::get('results', function () {
        return view('Tenant.results');
    });

    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    Route::middleware(['tenant.admissionOn.confirm', 'landlord.admissionAutomationFeature.confirm'])->group(function (){
        Route::get('admission-apply-online', [\App\Http\Controllers\Tenant\GuestDomain\Admission\ApplicantsController::class, 'create']);
        Route::post('admission-apply-online', [\App\Http\Controllers\Tenant\GuestDomain\Admission\ApplicantsController::class, 'store'])->name('storeAdmission');
    });

    Route::middleware('guest')->group(function () {

        Route::get('login', [\App\Http\Controllers\Tenant\Auth\LoginsController::class, 'form'])->name('loginForm');
        Route::post('login', [\App\Http\Controllers\Tenant\Auth\LoginsController::class, 'login'])->name('login');

        Route::get('forgot-password', [\App\Http\Controllers\Tenant\Auth\ForgetPasswordsController::class, 'create'])->name('forgotPasswordForm');
        Route::post('forgot-password', [\App\Http\Controllers\Tenant\Auth\ForgetPasswordsController::class, 'store'])->name('forgotPassword');

        Route::get('reset-password', [\App\Http\Controllers\Tenant\Auth\ForgetPasswordsController::class, 'edit'])
            ->name('password.reset')
            ->middleware('tenant.verifyPassword.reset');
        Route::post('reset-password', [\App\Http\Controllers\Tenant\Auth\ForgetPasswordsController::class, 'update'])->name('resetPassword');

    });

    Route::group(['middleware' => ['web', WelcomesNewUsers::class]], function (){
        Route::get('set-password/{user}', [\App\Http\Controllers\Tenant\User\WelcomeUsersController::class, 'create'])->name('welcome');
        Route::post('set-password/{user}', [\App\Http\Controllers\Tenant\User\WelcomeUsersController::class, 'store'])->name('storeWelcomeUser');
    });

    Route::post('logout', [\App\Http\Controllers\Tenant\DashboardsController::class, 'logout'])->name('logout')->middleware('auth');

    Route::middleware(['auth', 'landlord.isSubscriptionActive', 'tenant.checkUserSuspensionStatus'])->group(function (){

        Route::get('dashboard', [\App\Http\Controllers\Tenant\DashboardsController::class, 'index'])->name('dashboard');
        Route::get('hide-to-list', [\App\Http\Controllers\Tenant\DashboardsController::class, 'hideTodoList'])->name('hideTodoList');

        Route::post('user/change-password', [\App\Http\Controllers\Tenant\ChangePasswordsController::class, 'update'])->name('changePassword');

        Route::prefix('auth')->group(function (){

            Route::middleware('tenant.academicCalendar.confirm')->group(function (){

                Route::get('subject', [\App\Http\Controllers\Tenant\Subject\SubjectsController::class, 'index'])->name('listSubject');
                Route::post('subject', [\App\Http\Controllers\Tenant\Subject\SubjectsController::class, 'store'])->name('storeSubject');


                Route::middleware('landlord.admissionAutomationFeature.confirm')->group(function (){
                    Route::get('admission/applicant', [\App\Http\Controllers\Tenant\Admission\ApplicantsController::class, 'index'])->name('listApplicant');
                    Route::post('admission/applicant-update', [\App\Http\Controllers\Tenant\Admission\ApplicantsController::class, 'store'])->name('updateApplicants');

                    Route::get('admission/applicant/{uuid}', [\App\Http\Controllers\Tenant\Admission\ApplicantsController::class, 'single'])->name('singleApplicant');
                    Route::patch('admission/applicant/{uuid}', [\App\Http\Controllers\Tenant\Admission\ApplicantsController::class, 'update'])->name('updateApplicant');

                });

                Route::get('classes', [\App\Http\Controllers\Tenant\SchoolClass\SchoolClassesController::class, 'index'])->name('listClass');

                Route::get('subject-teacher/{uuid}', [\App\Http\Controllers\Tenant\Subject\SubjectTeachersController::class, 'index'])->name('listSubjectTeacher');

                Route::get('class-subject/{uuid}', [\App\Http\Controllers\Tenant\SchoolClass\ClassSubjectsController::class, 'index'])->name('listClassSubject');

                Route::get('class-teacher/{uuid}', [\App\Http\Controllers\Tenant\SchoolClass\ClassTeachersController::class, 'single'])->name('classTeacher');

                Route::get('admin-user', [\App\Http\Controllers\Tenant\AdminUser\AdminsController::class, 'index'])->name('listAdminUser');
                Route::get('admin-user/add-new', [\App\Http\Controllers\Tenant\AdminUser\AdminsController::class, 'create'])->name('createAdminUser');
                Route::post('admin-user', [\App\Http\Controllers\Tenant\AdminUser\AdminsController::class, 'store'])->name('storeAdminUser');
                Route::get('admin-user/{uuid}', [\App\Http\Controllers\Tenant\AdminUser\AdminsController::class, 'edit'])->name('editAdminUser');
                Route::patch('admin-user/{uuid}', [\App\Http\Controllers\Tenant\AdminUser\AdminsController::class, 'update'])->name('updateAdminUser');

                Route::get('teacher', [\App\Http\Controllers\Tenant\Teacher\TeachersController::class, 'index'])->name('listTeacher');
                Route::get('teacher/add-new', [\App\Http\Controllers\Tenant\Teacher\TeachersController::class, 'create'])->name('createTeacher');
                Route::get('teacher/upload-teachers', [\App\Http\Controllers\Tenant\Teacher\UploadTeachersController::class, 'create'])->name('uploadTeachers');
                Route::get('teacher/{uuid}', [\App\Http\Controllers\Tenant\Teacher\TeachersController::class, 'edit'])->name('editTeacher');
                Route::delete('teacher/{uuid}', [\App\Http\Controllers\Tenant\Teacher\TeachersController::class, 'delete'])->name('deleteTeacher');

                Route::post('teacher/{uuid}/suspend-access', [\App\Http\Controllers\Tenant\Teacher\SuspendController::class, 'store'])->name('suspendTeacherAccess');
                Route::post('teacher/{uuid}/unsuspend-access', [\App\Http\Controllers\Tenant\Teacher\SuspendController::class, 'unSuspend'])->name('unSuspendTeacherAccess');

                Route::get('student', [\App\Http\Controllers\Tenant\Student\StudentsController::class, 'index'])->name('listStudent');
                Route::middleware('landlord.isTotalStudent.confirm')->group(function (){
                    Route::get('student/add-new', [\App\Http\Controllers\Tenant\Student\StudentsController::class, 'create'])->name('createStudent');
                    Route::get('student/upload-student', [\App\Http\Controllers\Tenant\Student\UploadStudentsController::class, 'create'])->name('uploadStudent');
                });

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

                Route::post('result/report-sheet-addition/{uuid}/student/{id}', [\App\Http\Controllers\Tenant\Result\ResultAdditionalCommentsController::class, 'store'])->name('storeReportComment');

                Route::middleware('tenant.paymentOption.confirm')->group(function (){

                    Route::get('fee/format', [\App\Http\Controllers\Tenant\Fee\FeeStructuresController::class, 'index'])->name('listFeeStructure');
                    Route::get('fee/format/add-new', [\App\Http\Controllers\Tenant\Fee\FeeStructuresController::class, 'create'])->name('createFeeStructure');
                    Route::post('fee/format', [\App\Http\Controllers\Tenant\Fee\FeeStructuresController::class, 'store'])->name('storeFeeStructure');

                    Route::post('fee/class', [\App\Http\Controllers\Tenant\Fee\ClassSectionsController::class, 'store'])->name('storeClassFee');

                    Route::get('fee/student/{uuid}', [\App\Http\Controllers\Tenant\Fee\StudentFeesController::class, 'index'])->name('listStudentFee');
                    Route::post('fee/student', [\App\Http\Controllers\Tenant\Fee\StudentFeesController::class, 'store'])->name('storeStudentFee');

                    Route::post('school-fee/{uuid}', [\App\Http\Controllers\Tenant\Fee\SchoolFeesController::class, 'store'])->name('storeSchoolFee');

                    Route::get('fee/student/{uuid}/receipt', [\App\Http\Controllers\Tenant\Fee\ReceiptsController::class, 'index'])->name('listStudentReceipt');

                    Route::post('record-student-school-fees/{uuid}', [\App\Http\Controllers\Tenant\Fee\RecordStudentSchoolFeesController::class, 'store'])->name('recordStudentSchoolFees');

                });

            });

            Route::prefix('settings')->group(function (){

                Route::get('/', [\App\Http\Controllers\Tenant\Setting\SettingsController::class, 'index'])->name('listSetting');

                Route::get('academic-session', [\App\Http\Controllers\Tenant\AcademicSession\AcademicSessionsController::class, 'index'])->name('listAcademicCalendar');
                Route::get('academic-calendar', [\App\Http\Controllers\Tenant\AcademicSession\AcademicSessionsController::class, 'create'])->name('academicSession');
                Route::post('academic-calendar', [\App\Http\Controllers\Tenant\AcademicSession\AcademicSessionsController::class, 'store'])->name('storeAcademicSession');

                Route::get('admission', [\App\Http\Controllers\Tenant\Setting\AdmissionSettingsController::class, 'edit'])->name('admissionSetting')->middleware('tenant.academicCalendar.confirm');
                Route::post('admission', [\App\Http\Controllers\Tenant\Setting\AdmissionSettingsController::class, 'update'])->name('storeAdmissionSetting')->middleware('tenant.academicCalendar.confirm');

                Route::get('school-details', [\App\Http\Controllers\Tenant\Setting\SchoolDetailsController::class, 'edit'])->name('schoolDetailsSettings');
                Route::post('school-details', [\App\Http\Controllers\Tenant\Setting\SchoolDetailsController::class, 'update'])->name('updateSchoolDetailsSettings');

                Route::post('school-detail/principal', [\App\Http\Controllers\Tenant\Setting\PrincipalDetailsController::class, 'update'])->name('updateSchoolPrincipal');

                Route::post('school-detail/logo', [\App\Http\Controllers\Tenant\Setting\SchoolLogoController::class, 'update'])->name('updateSchoolLogo');

                Route::get('frontend', [\App\Http\Controllers\Tenant\Setting\FrontendSettingsController::class, 'edit'])->name('frontendSetting');
                Route::post('frontend', [\App\Http\Controllers\Tenant\Setting\FrontendSettingsController::class, 'update'])->name('updateFrontendSetting');

                Route::get('change-password', [\App\Http\Controllers\Tenant\Setting\ChangePasswordsController::class, 'edit'])->name('changeAuthPassword');

            });

            Route::prefix('subscription')->group(function (){
                Route::get('addon/student', [\App\Http\Controllers\Tenant\Setting\SubscriptionAddonsController::class, 'index'])->name('subscriptionStudentAddon');
                Route::post('addon/student/{uuid}', [\App\Http\Controllers\Tenant\Setting\SubscriptionAddonsController::class, 'store'])->name('postSubscriptionStudentAddon');

                //@todo add middleware
                Route::get('payment/callback/addon', [\App\Http\Controllers\Tenant\Setting\Subscripton\Addon\CheckoutCallbackController::class, 'store'])->name('addonPaymentCallback');
            });

        });

        Route::get('wards', [\App\Http\Controllers\Tenant\ParentDomain\Ward\WardsController::class, 'index'])->name('listWard');

        Route::middleware('tenant.paymentOption.confirm')->group(function (){
            Route::get('ward/fees', [\App\Http\Controllers\Tenant\ParentDomain\Fee\FeesController::class, 'index'])->name('listWardFee');
            Route::get('fees/{uuid}/{studentId}', [\App\Http\Controllers\Tenant\ParentDomain\Fee\FeesController::class, 'single'])->name('singleWardFee');
            Route::post('fees/payment/{uuid}/{studentId}', [\App\Http\Controllers\Tenant\ParentDomain\Fee\FeesController::class, 'store'])->name('payWardFee');
            Route::get('print-school-receipt/{uuid}/{studentId}', [\App\Http\Controllers\Tenant\ParentDomain\Fee\PrintController::class, 'store'])->name('printWardFeeReceipt');

            Route::get('school-fees/payment/call-back', [\App\Http\Controllers\Tenant\ParentDomain\Fee\CallbackFromCheckoutsController::class, 'update'])->middleware('tenant.callback.verify')->name('getSchoolFeesCallback');
            Route::post('school-fees/payment/call-back', [\App\Http\Controllers\Tenant\ParentDomain\Fee\CallbackFromCheckoutsController::class, 'update'])->middleware([
                'tenant.callback.verify',
                'tenant.callback.webhook'
            ]);
        });

        Route::get('ward/result', [App\Http\Controllers\Tenant\ParentDomain\Result\ResultsController::class, 'index'])->name('listWardResult');
        Route::get('result/{uuid}/{studentId}', [\App\Http\Controllers\Tenant\ParentDomain\Result\ResultsController::class, 'single'])->name('singleWardResult');
        Route::get('result/print/{uuid}/{studentId}', [\App\Http\Controllers\Tenant\ParentDomain\Result\PrintController::class, 'store'])->name('printWardResult');

        Route::get('profile', [\App\Http\Controllers\Tenant\ParentDomain\Profile\UsersController::class, 'single'])->name('parentProfile');
        Route::patch('profile', [\App\Http\Controllers\Tenant\ParentDomain\Profile\UsersController::class, 'update'])->name('updateParentProfile');

    });

    Route::get('auth/subscription', [\App\Http\Controllers\Tenant\Setting\SubscriptionSettingsController::class, 'edit'])
        ->name('subscriptionSetting')
        ->middleware('auth');

});

Route::get('inactive-subscription', [\App\Http\Controllers\Landlord\Subscription\InActiveSubscriptionController::class, 'index'])
    ->middleware('landlord.checkCurrentTenant')
    ->name('inactiveSubscription');

Route::prefix('be-admin')->group(function (){
    Route::get('login', [\App\Http\Controllers\Landlord\AdminDomain\Auth\LoginsController::class, 'form'])->middleware('guest');
    Route::post('login', [\App\Http\Controllers\Landlord\AdminDomain\Auth\LoginsController::class, 'store'])->name('landlordLogin')->middleware('guest');

    Route::middleware('auth:admin')->group(function (){
        Route::get('dashboard', [\App\Http\Controllers\Landlord\AdminDomain\DashboardsController::class, 'index'])->name('landlordDashboard');
        Route::post('logout', [\App\Http\Controllers\Landlord\AdminDomain\DashboardsController::class, 'logout'])->name('landlordLogout');

        Route::get('schools', [\App\Http\Controllers\Landlord\AdminDomain\Tenant\TenantsController::class, 'index'])->name('listSchool');
        Route::get('school/add-new', [\App\Http\Controllers\Landlord\AdminDomain\Tenant\TenantsController::class, 'create'])->name('createSchool');
        Route::post('schools', [\App\Http\Controllers\Landlord\AdminDomain\Tenant\TenantsController::class, 'store'])->name('storeSchool');

        Route::get('subscription/plans', [\App\Http\Controllers\Landlord\AdminDomain\Subscription\PlansController::class, 'index'])->name('listPlan');
        Route::get('subscription/plan/add-new', [\App\Http\Controllers\Landlord\AdminDomain\Subscription\PlansController::class, 'create'])->name('createPlan');
        Route::post('subscription/plans', [\App\Http\Controllers\Landlord\AdminDomain\Subscription\PlansController::class, 'store'])->name('storePlan');
        Route::get('subscription/plan/{uuid}', [\App\Http\Controllers\Landlord\AdminDomain\Subscription\PlansController::class, 'edit'])->name('singlePlan');
        Route::post('subscription/plan/{uuid}/feature', [\App\Http\Controllers\Landlord\AdminDomain\Subscription\PlanFeaturesController::class, 'store'])->name('storePlanFeature');

        Route::get('subscription/features', [\App\Http\Controllers\Landlord\AdminDomain\Subscription\FeaturesController::class, 'index'])->name('listFeature');
        Route::get('subscription/feature/add-new', [\App\Http\Controllers\Landlord\AdminDomain\Subscription\FeaturesController::class, 'create'])->name('createFeature');
        Route::post('subscription/features', [\App\Http\Controllers\Landlord\AdminDomain\Subscription\FeaturesController::class, 'store'])->name('storeFeature');

        Route::get('subscription/feature/addon', [\App\Http\Controllers\Landlord\AdminDomain\Subscription\FeatureAddonsController::class, 'index'])->name('listFeatureAddon');
        Route::post('subscription/feature/addon', [\App\Http\Controllers\Landlord\AdminDomain\Subscription\FeatureAddonsController::class, 'store'])->name('storeFeatureAddon');
    });

});
