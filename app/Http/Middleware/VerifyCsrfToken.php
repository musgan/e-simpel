<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
        'admin/akun-saya/update-profil',
        'hawasbid/akun-saya/update-profil',
        'mpn/akun-saya/update-profil',
        'kapan/akun-saya/update-profil',
        'hawasbid/akun-saya/update-profil',
    ];
}
