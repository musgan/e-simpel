<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;
use Closure;
use Illuminate\Session\TokenMismatchException;

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


    public function handle($request, Closure $next)
    {
        if (
            $this->isReading($request) ||
            $this->runningUnitTests() ||
            $this->inExceptArray($request) ||
            $this->tokensMatch($request)
        ) {
            return $this->addCookieToResponse($request, $next($request));
        }else{
            return redirect('token-failed');
        }

        throw new TokenMismatchException;
    }
}
