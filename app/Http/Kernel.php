<?php

namespace App\Http;

use App\Http\Middleware\Landlord\CheckAdmissionAutomationFeatureMiddleware;
use App\Http\Middleware\Landlord\CheckCurrentTenantMiddleware;
use App\Http\Middleware\Landlord\CheckOnboardMiddleware;
use App\Http\Middleware\Landlord\CheckTotalStudentFeatureMiddleware;
use App\Http\Middleware\Landlord\IsSubscriptionActiveMiddleware;
use App\Http\Middleware\Tenant\CheckIfAdmissionIsOnMiddleware;
use App\Http\Middleware\Tenant\CheckIfUserIsSuspendedMiddleware;
use App\Http\Middleware\Tenant\IsAcademicCalendarSetMiddleware;
use App\Http\Middleware\Tenant\IsClassArmNullOrEmptyMiddleware;
use App\Http\Middleware\Tenant\IsPaymentOptionOnMiddleware;
use App\Http\Middleware\Tenant\IsReportCardBreakdownFormatSetMiddleware;
use App\Http\Middleware\Tenant\VerifyCallbackMiddleware;
use App\Http\Middleware\Tenant\VerifyCallbackWebhookMiddleware;
use App\Http\Middleware\Tenant\VerifyFlutterwaveCallbackMiddleware;
use App\Http\Middleware\Tenant\VerifyPasswordResetMiddleware;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
         \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \Fruitcake\Cors\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
        'api' => [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
        'tenant' => [
            \Spatie\Multitenancy\Http\Middleware\NeedsTenant::class,
            \Spatie\Multitenancy\Http\Middleware\EnsureValidTenantSession::class,
        ]
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'tenant.callback.verify' => VerifyCallbackMiddleware::class,
        'tenant.callback.webhook' => VerifyCallbackWebhookMiddleware::class,
        'tenant.admissionOn.confirm' => CheckIfAdmissionIsOnMiddleware::class,
        'tenant.verifyPassword.reset' => VerifyPasswordResetMiddleware::class,
        'tenant.academicCalendar.confirm' => IsAcademicCalendarSetMiddleware::class,
        'tenant.reportCardBreakdownFormat.confirm' => IsReportCardBreakdownFormatSetMiddleware::class,
        'tenant.paymentOption.confirm' => IsPaymentOptionOnMiddleware::class,
        'tenant.classArm.isNullOrEmpty' => IsClassArmNullOrEmptyMiddleware::class,
        'landlord.checkOnboard' => CheckOnboardMiddleware::class,
        'landlord.checkCurrentTenant' => CheckCurrentTenantMiddleware::class,
        'landlord.isSubscriptionActive' => IsSubscriptionActiveMiddleware::class,
        'landlord.isTotalStudent.confirm' => CheckTotalStudentFeatureMiddleware::class,
        'landlord.admissionAutomationFeature.confirm' => CheckAdmissionAutomationFeatureMiddleware::class,
        'tenant.checkUserSuspensionStatus' => CheckIfUserIsSuspendedMiddleware::class,
        'tenant.callback.verify.flutterwave' => VerifyFlutterwaveCallbackMiddleware::class,
    ];
}
