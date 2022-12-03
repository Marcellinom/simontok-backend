<?php

namespace App\Services\RegisterUser;

use App\Exceptions\ExpectedException;
use App\Models\Pembeli;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Hash;

class RegisterUserService
{
    /**
     * @throws \Exception
     */
    public function execute(RegisterUserRequest $request)
    {
        if (User::where('email', $request->getEmail())->exists()) {
            ExpectedException::throw("User already exists", 1021);
        }
        $user = User::create(            [
            'name' => $request->getName(),
            'email' => $request->getEmail(),
            'password' => Hash::make($request->getUnhashedPassword()),
            'created_at' => Carbon::now()->getTimestamp(),
            'updated_at' => Carbon::now()->getTimestamp(),
        ]);

        Pembeli::persist((new Pembeli())
            ->setUserId($user->getId())
            ->setAlamat($request->getAlamat())
        );
    }
}
