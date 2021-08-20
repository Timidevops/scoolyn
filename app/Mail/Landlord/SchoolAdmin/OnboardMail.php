<?php

namespace App\Mail\Landlord\SchoolAdmin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OnboardMail extends Mailable
{
    use Queueable, SerializesModels;

    public $schoolAdmin;

    /**
     * Create a new message instance.
     *
     * @param $schoolAdmin
     */
    public function __construct($schoolAdmin)
    {
        //
        $this->schoolAdmin = $schoolAdmin;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Scoolyn: School Onboarding Process')->view('Landlord.email.schoolAdmin.onboardMail');
    }
}
