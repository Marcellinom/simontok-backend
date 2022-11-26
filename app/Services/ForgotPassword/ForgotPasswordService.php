<?php

namespace App\Services\ForgotPassword;

use App\Exceptions\ExpectedException;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Crypt;
use DB;
use Exception;
use Illuminate\Mail\Mailable;
use Mail;

class ForgotPasswordService
{
    /**
     * @throws Exception
     */
    public function execute(ForgotPasswordRequest $request)
    {
        $user = User::where('email', $request->getEmail())->first();

        if (!$user) ExpectedException::throw('Email is not registered', 2021);

        $existing_password_reset = DB::table('password_resets')->where('email', $request->getEmail())->first();

        if (
            $existing_password_reset
            and Carbon::now()->sub(CarbonInterval::minutes(5)) < $existing_password_reset->created_at
        ) {
            ExpectedException::throw("password reset is under cooldown", 2022);
        }

        $token = Crypt::encrypt(
            [
                'id' => $user->getId()
            ]
        );

        DB::table('password_resets')->updateOrInsert([
            'email' => $request->getEmail()
        ], [
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        Mail::to($request->getEmail())->queue(
            (new Mailable())->from(config('mail.from'))
                ->subject('Forgot Password')
                ->markdown('forgot_password', [
                    'token' => $token
                ])
        );
    }
}
