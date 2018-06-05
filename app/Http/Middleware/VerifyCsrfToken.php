<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
       'userlogin',
        'editProfile/*',
        'addTicket',
        'new_demande',
        'new_ticket',
        'login',
        'loginUser',
        'edit/*',
        'post_comment/*',
        'multiuploads',
        'uploadImages'
    ];
}
