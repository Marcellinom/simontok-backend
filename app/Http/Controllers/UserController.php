<?php

namespace App\Http\Controllers;


use App\Models\Shared\DbTransaction;
use App\Services\RegisterUser\RegisterUserRequest;
use App\Services\RegisterUser\RegisterUserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class UserController extends Controller
{
    /**
     * @throws Throwable
     */
    public function register(Request $request, RegisterUserService $service): JsonResponse
    {
        $request = new RegisterUserRequest($request->input('name'), $request->input('email'), $request->input('password'));
        DbTransaction::run(fn () => $service->execute($request));
        return $this->success();
    }
}
