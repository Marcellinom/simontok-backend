<?php

namespace App\Services\EditUser;

use App\Models\User;
use Hash;
use Storage;

class EditUserService
{
    public function execute(EditUserRequest $request, User $user)
    {
        if ($request->getName()) $user->setName($request->getName());
        if ($request->getNewPassword()) $user->setPassword(Hash::make($request->getNewPassword()));
        if ($request->getImage()) {
            $id = Storage::disk('public')->put('user/', $request->getImage());
            $user->setImage($id);
        }
        $user->persist();
    }
}
