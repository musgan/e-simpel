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
    public function handle($request, Closure $next, $role)
    {
        $user = Auth::user();
        if($role == "admin" && $user->user_level_id == 1){
            return $next($request);    
        }else if($role == "hawasbid" && $user->user_level_id == 10) {
            if($request->sub_menu){
                $check_segment = \Request::segment(2);
                
                if($check_segment != "pengawas-bidang"){
                    Auth::logout();
                    return redirect('/');
                }
                
                $cek_submenu = UserLevelGroup::where('user_id',$user->id)
                    ->join('sectors','sectors.id','=','sector_id')
                    ->where('sectors.alias',$request->sub_menu)
                    ->count();
                if($cek_submenu > 0){
                    return $next($request);   
                }else{
                    return redirect(session('role').'/home');
                }
            }else return $next($request);    
        
        }

        else if($role == "kapan" && ($user->user_level_id == 4 || $user->user_level_id == 5))  {
            
            if($request->sub_menu){
                $check_segment = \Request::segment(2);
                
                if($check_segment != "tindak-lanjutan"){
                    Auth::logout();
                    return redirect('/');
                }

                $cek_submenu = UserLevelGroup::where('user_id',$user->id)
                    ->join('sectors','sectors.id','=','sector_id')
                    ->where('sectors.alias',$request->sub_menu)
                    ->count();
                if($cek_submenu > 0){
                    return $next($request);   
                }else{
                    return redirect(session('role').'/home');
                }
            }else return $next($request);    
        }

        else if($role == "apm" && $user->user_level_id == 11){
            return $next($request);    
        }
         else if($role == "mpn" && ($user->user_level_id == 2 || $user->user_level_id == 3)){
            return $next($request);    
        }
        else if($role == "zi" && $user->user_level_id == 12){
            return $next($request);    
        }else {
            Auth::logout();
            return redirect('/');
        }
        
    }
}
