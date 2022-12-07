<?php

namespace App\Services\SendEmailOtp;

use App\Exceptions\ExpectedException;
use App\Models\Otp;
use App\Models\User;
use Mail;

class SendEmailOtpService
{
    /**
     * @throws \Exception
     */
    public function execute(SendEmailOtpRequest $request)
    {
        $user = User::where('email', $request->getEmail())->first();
        if (!$user) {
            ExpectedException::throw("user not founr", 1006,404);
        }
        $otp = Otp::generateForUser($user);
        $otp->persist();

        Mail::to($user->getEmail())->send($otp->build($user->getName()));
    }
}
