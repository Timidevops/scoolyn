<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Models\Landlord\SchoolAdmin;
use App\Models\Landlord\Transaction;
use App\Models\Tenant\ScoolynTenant;
use App\Models\Tenant\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class OnboardingsController extends Controller
{
    protected Model $tenant;

    public function create(string $uuid)
    {
        //@todo return view

        $this->store($uuid);
    }

    public function store(string $uuid)
    {
        //@todo validate request

        $schoolAdmin = SchoolAdmin::query()->where('uuid', $uuid)->first();

        //create new tenant
        $this->tenant = $this->createNewTenant([
            'name' => 'abc',
            'domain' => 'abc.app.scoolyn.com.test'
        ]);

        //@todo db migration

        //@todo db seeding

        //@todo create new admin user

        //@todo create default settings
        //school name, school location, currency set to ngn

        //update onboard process to complete and tenant id
        $schoolAdmin->update([
            'setup_complete' => 1,
            'tenant_id' => $this->tenant->id,
        ]);

        //update initial subscription transaction
        $this->updateTransaction($schoolAdmin->email);

        return redirect()->to('http://abc.app.scoolyn.com.test');
    }

    private function createNewTenant(array $input)
    {
        return ScoolynTenant::query()->create($input);
    }

    private function createNewAdminUser(array $input)
    {
        User::query()->create($input);
    }

    private function updateTransaction(string $userReference)
    {
        $transaction = Transaction::query()->where('user_reference', $userReference)->first();

        $transaction->update([
            'tenant_id' => $this->tenant->id,
        ]);
    }
}
