<?php

namespace App\Http\Controllers\Landlord\AdminDomain;

use App\Http\Controllers\Controller;
use App\Models\Tenant\ScoolynTenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardsController extends Controller
{
    public function index()
    {
        return view('landlord.adminDomain.pages.dashboard.index', [
            'totalTenants' => ScoolynTenant::query()->count(),
        ]);
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->to('https://scoolyn.com');
    }
}
