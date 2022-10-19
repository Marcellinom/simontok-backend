<?php

namespace App\Services\RegisterUser;

use App\Models\User;
use Hash;

class RegisterUserService
{
    public function execute(RegisterUserRequest $request)
    {
        $user = new User();
        $user->setName($request->getName());
        $user->setEmail($request->getEmail());
        $user->setPassword(Hash::make($request->getUnhashedPassword()));
        $user->persist();
    }
}
