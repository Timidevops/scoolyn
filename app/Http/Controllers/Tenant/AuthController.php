<?php

namespace App\Http\Controllers\Tenant;

use App\Models\Tenant\AcademicSession;
use App\Models\Tenant\AcademicTerm;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class AuthController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public string $currentAcademicSession;

    public function __construct()
    {
     $this->getCurrentAcademicSession();
    }
    private function getCurrentAcademicSession()
    {
        $academicSession = AcademicSession::currentAcademicSession()
            ? AcademicSession::currentAcademicSession()->session_name
            : '-';

        $academicTerm = AcademicTerm::currentAcademicTerm()
            ? AcademicTerm::currentAcademicTerm()->term_name
            : '-';

        $this->currentAcademicSession = "{$academicSession}, {$academicTerm}";
    }
}
