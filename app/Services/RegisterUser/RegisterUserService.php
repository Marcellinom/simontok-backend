<?php

namespace App\Services\RegisterUser;

use App\Exceptions\ExpectedException;
use App\Models\User;
use App\Services\SendEmailOtp\SendEmailOtpRequest;
use App\Services\SendEmailOtp\SendEmailOtpService;
use Hash;

class RegisterUserService
{
    private SendEmailOtpService $otp_service;

    /**
     * @param SendEmailOtpService $otp_service
     */
    public function __construct(SendEmailOtpService $otp_service)
    {
        $this->otp_service = $otp_service;
    }

    /**
     * @throws \Exception
     */
    public function execute(RegisterUserRequest $request)
    {
        if (User::where('email', $request->getEmail())->first()) {
            ExpectedException::throw("User already exists", 1021);
        }
        $user = new User();
        $user->setName($request->getName());
        $user->setEmail($request->getEmail());
        $user->setPassword(Hash::make($request->getUnhashedPassword()));
        $user->setImage('user/default.png');
        $user->persist();
        $this->otp_service->execute(new SendEmailOtpRequest($user->getEmail()));
    }
}
