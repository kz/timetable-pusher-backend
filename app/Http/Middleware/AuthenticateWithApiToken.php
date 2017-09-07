<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class AuthenticateWithApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Get plain token
        $token = str_replace('Bearer:', '', $request->header('Authorization'));
        $token = str_replace(' ', '', $token);
        $token = strtoupper($token);

        // Attempt to get the user
        $user = User::getUserByToken($token);

        // Ensure that the API token is valid
        if (!$user) {
            return response('Invalid API token.', 401);
        }

        // Authenticate the user
        Auth::onceUsingId($user->id);

        return $next($request);
    }
}
