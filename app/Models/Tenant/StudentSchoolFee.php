<?php


namespace App\Models\Tenant;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class StudentSchoolFee
{
    private Model $student;
    public Collection $transactions;
    public $schoolFees;

    public function __construct(Model $student)
    {
        $this->student = $student;

        $this->schoolFees = $student->classArm->schoolClass->schoolFees;

        $this->transactions = Transaction::query()->whereJsonContains('meta', ['student_id' => $student->uuid])->get();
    }

    public function status(): string
    {
        if( $this->transactions->count() == 0 ){
            return SchoolFee::NOT_PAID_STATUS;
        }

        if ( ! $this->isSchoolFeesPaid() ){
            return  SchoolFee::NOT_COMPLETE;
        }

        return SchoolFee::PAID_STATUS;
    }

    public function isSchoolFeesPaid(): bool
    {
        return $this->schoolFeesLeft() == 0;
    }

    public function schoolFeesPaid(): float
    {
        return $this->transactions->sum('amount');
    }

    public function schoolFeesLeft(): float
    {
        return $this->schoolFees ? $this->schoolFees->amount->amount - $this->schoolFeesPaid() : 0;
    }

    public function feesItems()
    {
        return $this->schoolFees ? $this->schoolFees->feesItems : collect([]);
    }
}
