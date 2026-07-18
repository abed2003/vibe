<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Resolves the authenticated user on *public* API routes when the request
 * carries a Bearer token, without ever rejecting the request when it doesn't
 * (or when the token is invalid). This lets guest-accessible endpoints (feed,
 * video show, comments) still personalize their payload — liked_by_me,
 * saved_by_me, owner.is_followed_by_me, comment "mine" — for logged-in
 * viewers, since `$request->user()` would otherwise only resolve through the
 * default session guard and ignore the token.
 */
class OptionalSanctumUser
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->bearerToken() && ! $request->user()) {
            // The sanctum guard is a RequestGuard: user() resolves the token
            // or returns null, it never throws or challenges.
            $user = Auth::guard('sanctum')->user();

            if ($user) {
                Auth::setUser($user);
                $request->setUserResolver(static fn () => $user);
            }
        }

        return $next($request);
    }
}
