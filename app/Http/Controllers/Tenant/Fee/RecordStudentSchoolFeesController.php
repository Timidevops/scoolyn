<?php

namespace App\Http\Controllers\Tenant\Fee;

use App\Actions\Tenant\Transaction\CreateNewTransactionAction;
use App\Http\Controllers\Controller;
use App\Models\Tenant\SchoolFee;
use App\Models\Tenant\Student;
use App\Models\Tenant\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RecordStudentSchoolFeesController extends Controller
{
    public function store(string $uuid, Request $request)
    {
        $this->validate($request, [
            'amount' => ['required'],
        ]);

        $student = Student::whereUuid($uuid);

        if ( ! $student ){
            Session::flash('errorFlash', 'Error processing request.');

            return back();
        }

        if ( $request->input('amount') > $student->schoolFee->schoolFeesLeft() ){
            Session::flash('warningFlash', 'Amount added is more that outstanding school fees.');

            return back();
        }

        (new CreateNewTransactionAction)->execute([
            'reference'      => generateUniqueReference('12','rp_'),
            'type'           => Transaction::CREDIT_TYPE,
            'amount'         => $request->input('amount'),
            'user_id'        => (string) $student->parent->uuid,
            'school_fees_id' => $student->schoolFee->uuid,
            'currency'       => 'ngn',
            'description'    => $request->input('description') ?? 'payment for school fees',
        ]);

        $status = SchoolFee::PAID_STATUS;

        if ( ! $student->schoolFee->isSchoolFeesPaid() ){
            $status = SchoolFee::NOT_COMPLETE;
        }

        $student->schoolFee->setStatus($status);

        Session::flash('successFlash', 'School fees payment recorded successfully!!!');

        return back();
    }
}
