<?php

namespace App\Services\LoginUser;

use App\Exceptions\ExpectedException;
use App\Models\User;
use Hash;

class LoginUserService
{
    /**
     * @throws \Exception
     */
    public function execute(LoginUserRequest $request): LoginUserResponse
    {
        $user = User::where('email', $request->getEmail())->first();
        if (!$user) ExpectedException::throw("user not found", 1003);
        if (!Hash::check($request->getPassword(), $user->getPassword())) {
            ExpectedException::throw("Invalid Password", 1002);
        }
        $token = $user->createToken('remember_token');
        return new LoginUserResponse($token->plainTextToken);
    }
}
