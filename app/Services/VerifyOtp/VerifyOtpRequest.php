<?php

namespace App\Services\VerifyOtp;

class VerifyOtpRequest
{
    private int $user_id;
    private int $otp;

    /**
     * @param int $user_id
     * @param int $otp
     */
    public function __construct(int $user_id, int $otp)
    {
        $this->user_id = $user_id;
        $this->otp = $otp;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @return int
     */
    public function getOtp(): int
    {
        return $this->otp;
    }
}
