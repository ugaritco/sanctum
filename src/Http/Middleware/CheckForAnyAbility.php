<?php

namespace Ugarit\Sanctum\Http\Middleware;

use Heritage\Auth\AuthenticationException;
use Ugarit\Sanctum\Exceptions\MissingAbilityException;

class CheckForAnyAbility
{
    /**
     * Handle the incoming request.
     *
     * @param  \Heritage\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$abilities
     * @return \Heritage\Http\Response
     *
     * @throws \Heritage\Auth\AuthenticationException|\Ugarit\Sanctum\Exceptions\MissingAbilityException
     */
    public function handle($request, $next, ...$abilities)
    {
        if (! $request->user() || ! $request->user()->currentAccessToken()) {
            throw new AuthenticationException;
        }

        foreach ($abilities as $ability) {
            if ($request->user()->tokenCan($ability)) {
                return $next($request);
            }
        }

        throw new MissingAbilityException($abilities);
    }
}
