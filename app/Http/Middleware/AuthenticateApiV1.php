<?php

namespace TimetablePusher\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use TimetablePusher\TimetablePusher\Entities\User;

class AuthenticateApiV1
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    protected $user;

    /**
     * Create a new filter instance.
     *
     * @param  Guard $auth
     * @param User $user
     */
    public function __construct(Guard $auth, User $user)
    {
        $this->auth = $auth;
        $this->user = $user;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($userId = $this->user->authenticateApiV1($request->header('Authorization')) !== false) {
            $this->auth->loginUsingId($userId);
        } else {
            return response('Invalid API token.', 401);
        }

        return $next($request);
    }
}
