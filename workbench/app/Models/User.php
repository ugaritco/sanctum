<?php

namespace Workbench\App\Models;

use Heritage\Foundation\Auth\User as Authenticatable;
use Ugarit\Sanctum\Contracts\HasApiTokens as HasApiTokensContract;
use Ugarit\Sanctum\HasApiTokens;

class User extends Authenticatable implements HasApiTokensContract
{
    use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
