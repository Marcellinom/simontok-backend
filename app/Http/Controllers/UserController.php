<?php

namespace App\Http\Controllers;


use App\Exceptions\ExpectedException;
use App\Models\Shared\Email;
use App\Services\ForgotPassword\ForgotPasswordRequest;
use App\Services\ForgotPassword\ForgotPasswordService;
use App\Services\LoginUser\LoginUserRequest;
use App\Services\LoginUser\LoginUserService;
use App\Services\RegisterUser\RegisterUserRequest;
use App\Services\RegisterUser\RegisterUserService;
use App\Services\SendEmailOtp\SendEmailOtpRequest;
use App\Services\SendEmailOtp\SendEmailOtpService;
use App\Services\VerifyOtp\VerifyOtpRequest;
use App\Services\VerifyOtp\VerifyOtpService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;
use Validator;
use function use_db_transaction;

class UserController extends Controller
{
    /**
     * @throws Throwable
     */
    public function register(Request $request, RegisterUserService $service): JsonResponse
    {
        Email::validate($request->input('email'));

        $request = new RegisterUserRequest($request->input('name'), $request->input('email'), $request->input('password'));
        use_db_transaction(fn () => $service->execute($request));
        return $this->success();
    }

    /**
     * @throws Throwable
     */
    public function forgot_password(Request $request, ForgotPasswordService $service): JsonResponse
    {
        Email::validate($request->input('email'));

        $request = new ForgotPasswordRequest($request->input('email'));
        use_db_transaction(fn () => $service->execute($request));
        return $this->success();
    }

    /**
     * @throws Throwable
     */
    public function login(Request $request, LoginUserService $service): JsonResponse
    {
        $request = new LoginUserRequest($request->input('email'), $request->input('password'));
        $response = use_db_transaction(fn () => $service->execute($request));
        return $this->successWithData($response);
    }

    /**
     * @throws Throwable
     */
    public function sendOtp(Request $request, SendEmailOtpService $service)
    {
        $request = new SendEmailOtpRequest($request->input('email'));
        use_db_transaction(fn () => $service->execute($request));
        return $this->success();
    }

    /**
     * @throws Throwable
     */
    public function verifyOtp(Request $request, VerifyOtpService $service)
    {
        $request = new VerifyOtpRequest($request->input('user_id'), $request->input('otp'));
        use_db_transaction(fn () => $service->execute($request));
        return $this->success();
    }
}
