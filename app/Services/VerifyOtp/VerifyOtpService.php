<?php

namespace App\Services\VerifyOtp;

use App\Exceptions\ExpectedException;
use App\Models\Otp;
use DateTime;

class VerifyOtpService
{
    /**
     * @throws \Exception
     */
    public function execute(VerifyOtpRequest $request)
    {
        if (null === $otp = Otp::where('user_id', $request->getUserId())->first())
            ExpectedException::throw("OTP not found", 1007, 404);
        if ($otp->getOtp() !== $request->getOtp())
            ExpectedException::throw("OTP doesn't match", 1009, 401);
        if (null === $user = $otp->user())
            ExpectedException::throw("User not found for this OTP", 1010, 404);
        if ($user->getEmailVerifiedAt() !== null)
            ExpectedException::throw("User Already Verified", 1011, 401);
        $user->setEmailVerifiedAt(new DateTime());
        $user->persist();
    }
}
