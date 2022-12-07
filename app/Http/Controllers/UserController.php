<?php

namespace App\Http\Controllers;

use App\Models\Shared\Email;
use App\Services\EditUser\EditUserRequest;
use App\Services\EditUser\EditUserService;
use App\Services\ForgotPassword\ForgotPasswordRequest;
use App\Services\ForgotPassword\ForgotPasswordService;
use App\Services\GetMarketplace\GetMarketplaceRequest;
use App\Services\GetMarketplace\GetMarketplaceService;
use App\Services\LoginUser\LoginUserRequest;
use App\Services\LoginUser\LoginUserService;
use App\Services\RegisterUser\RegisterUserRequest;
use App\Services\RegisterUser\RegisterUserService;
use App\Services\ResetPassword\ResetPasswordRequest;
use App\Services\ResetPassword\ResetPasswordService;
use App\Services\SendEmailOtp\SendEmailOtpRequest;
use App\Services\SendEmailOtp\SendEmailOtpService;
use App\Services\VerifyOtp\VerifyOtpRequest;
use App\Services\VerifyOtp\VerifyOtpService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;
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
    public function reset_password(Request $request, ResetPasswordService $service): JsonResponse
    {
        Email::validate($request->input('email'));
        use_db_transaction(fn () => $service->execute(
                new ResetPasswordRequest(
                    $request->input('email'),
                    $request->input('token'),
                    $request->input('new_password')
                )
            )
        );
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
    public function sendOtp(Request $request, SendEmailOtpService $service): JsonResponse
    {
        $request = new SendEmailOtpRequest($request->input('email'));
        use_db_transaction(fn () => $service->execute($request));
        return $this->success();
    }

    /**
     * @throws Throwable
     */
    public function verifyOtp(Request $request, VerifyOtpService $service): JsonResponse
    {
        $request = new VerifyOtpRequest($request->input('user_id'), $request->input('otp'));
        use_db_transaction(fn () => $service->execute($request));
        return $this->success();
    }

    /**
     * @throws Throwable
     */
    public function editUser(Request $request, EditUserService $service): JsonResponse
    {
        use_db_transaction(fn () => $service->execute(new EditUserRequest(
            $request->input('name'),
            $request->input('new_password'),
            $request->hasFile('image') ? $request->file('image') : null
        ), $request->user()));
        return $this->success();
    }
}
