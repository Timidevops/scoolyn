<?php


namespace App\Actions\Tenant\User;


class WelcomeNewUserAction
{
    public function execute($user)
    {
        $expiresAt = now()->addDay();

        //$user->sendWelcomeNotification($expiresAt);
    }
}
