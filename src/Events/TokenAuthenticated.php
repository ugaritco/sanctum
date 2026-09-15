<?php

namespace Ugarit\Sanctum\Events;

class TokenAuthenticated
{
    /**
     * Create a new event instance.
     *
     * @param  \Ugarit\Sanctum\PersonalAccessToken  $token  The personal access token that was authenticated.
     */
    public function __construct(public $token)
    {
    }
}
