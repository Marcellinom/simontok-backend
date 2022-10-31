<?php

namespace App\Services\RegisterUser;

use App\Exceptions\ExpectedException;
use App\Models\User;
use Hash;

class RegisterUserService
{
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
        $user->persist();
    }
}
