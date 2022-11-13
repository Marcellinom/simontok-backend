<?php

namespace App\Http\Middleware;

use App\Exceptions\ExpectedException;
use App\Models\User;
use Closure;
use Exception;
use Illuminate\Http\Request;

class MustVerifyEmail
{
    /**
     * @throws Exception
     */
    public function handle(Request $request, CLosure $next)
    {
        $user = $request->user();
        if (!$user instanceof User) ExpectedException::throw("invalid User Instance", 1023);

        return $user->getEmailVerifiedAt() ? $next($request) : ExpectedException::throw("Email is not verified", 1024);
    }
}
