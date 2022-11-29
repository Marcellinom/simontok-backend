<?php

namespace App\Services\ResetPassword;

use App\Exceptions\ExpectedException;
use App\Models\User;
use DB;
use Exception;
use Hash;

class ResetPasswordService
{
    /**
     * @throws Exception
     */
    public function execute(ResetPasswordRequest $request)
    {
        $user = User::where('email', $request->getEmail())->first();

        if (!$user) ExpectedException::throw("USer not registered with this email", 2023);

        $email = $user->getEmail();
        $id = $user->getId();

        if (!Hash::check($id."|".$email, $request->getToken())) ExpectedException::throw("Token Invalid", 2024);

        $user->update(['password' => Hash::make($request->getNewPassword())]);

        DB::table('password_resets')->where('email', $request->getEmail())->delete();
    }
}
