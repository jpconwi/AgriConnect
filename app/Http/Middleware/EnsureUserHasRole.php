<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        if (! $user || ! in_array($user->role, $roles)) {
            abort(403, 'You do not have access to this page.');
        }

        if (! $user->isActive()) {
            auth()->logout();
            return redirect('/login')->withErrors([
                'email' => 'Your account is pending admin approval or has been suspended.',
            ]);
        }

        return $next($request);
    }
}
