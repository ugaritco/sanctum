<?php

namespace Ugarit\Sanctum\Http\Middleware;

use Ugarit\Sanctum\Exceptions\MissingScopeException;

/**
 * @deprecated
 * @see \Ugarit\Sanctum\Http\Middleware\CheckAbilities
 */
class CheckScopes
{
    /**
     * Handle the incoming request.
     *
     * @param  \Heritage\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$scopes
     * @return \Heritage\Http\Response
     *
     * @throws \Heritage\Auth\AuthenticationException|\Ugarit\Sanctum\Exceptions\MissingScopeException
     */
    public function handle($request, $next, ...$scopes)
    {
        try {
            return (new CheckAbilities())->handle($request, $next, ...$scopes);
        } catch (\Ugarit\Sanctum\Exceptions\MissingAbilityException $e) {
            throw new MissingScopeException($e->abilities());
        }
    }
}
