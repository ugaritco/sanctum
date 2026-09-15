<?php

namespace Ugarit\Sanctum\Http\Controllers;

use Heritage\Http\JsonResponse;
use Heritage\Http\Request;
use Heritage\Http\Response;

class CsrfCookieController
{
    /**
     * Return an empty response simply to trigger the storage of the CSRF cookie in the browser.
     *
     * @param  \Heritage\Http\Request  $request
     * @return \Heritage\Http\Response|\Heritage\Http\JsonResponse
     */
    public function show(Request $request)
    {
        if ($request->expectsJson()) {
            return new JsonResponse(status: 204);
        }

        return new Response(status: 204);
    }
}
