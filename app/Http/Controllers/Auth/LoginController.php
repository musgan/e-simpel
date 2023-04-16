<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Sector;
use App\UserLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Crypt;

use DB;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {

        $data = [
            "user_levels"   => UserLevel::OrderBy('id','ASC')->pluck('nama','id'),
            "sectors"   => Sector::OrderBy('id','ASC')->pluck('nama','id')
        ];

        return view('auth.login',$data);
    }


    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    public function authenticated(Request $request, $user)
    {
        $sectors_query = DB::table('user_level_groups')
            ->join('sectors','sectors.id','=','sector_id')
            ->where('user_id',$user->id)
            ->select('nama','alias','category')
            ->orderBy('sectors.category','ASC')
            ->orderBy('sectors.id','ASC')
            ->get();
        $sector_menu = [];
        $sector_category = [];
        $chk_category = "";
        foreach ($sectors_query as $row) {
            # code...
            if($chk_category != $row->category){
                $chk_category = $row->category;
                array_push($sector_category, $chk_category);
            }
            array_push($sector_menu, $row->alias );
        }


        $session_login = [
            'user'  => $user,
            'sector_menu'   => $sector_menu,
            'sector_category'  => $sector_category
        ];
        
        $this->redirectTo = '/home';

        $request->session()->put('session_login',Crypt::encryptString(serialize($session_login)));
    }

}
