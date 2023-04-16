<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\UserLevelGroup;
class CekRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {   
        $user = Auth::user()->user_level;
        if($user)
            if(in_array($user->alias, $roles))
                return $next($request);
        
        
        Auth::logout();
        return redirect('/');
        
    }
}
