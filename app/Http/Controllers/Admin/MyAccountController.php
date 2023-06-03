<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\VariableHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Sector;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class MyAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->sectors = Sector::select('id','nama','alias','category')->orderBy('id','ASC')->get();
        $this->bulan = VariableHelper::getDictOfMonth();
    }

    public function index()
    {
        //
        $data = Auth::user();
        

        $send = [
            'menu' => 'akun_saya',
            'title' => 'Akun Saya',
            'send'  => $data,
            'menu_sectors'   => $this->sectors
        ];

        return view('admin.my_account.index',$send);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request, [
            'name' => 'required',
            'optradio'  => 'required'
        ]);
        $user = Auth::user();
        $user->name = $request->name;

        if($request->password && $request->optradio == 1){
             $this->validate($request,['password'  => 'required|confirmed|min:6']);
             $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect(url('/akun-saya'))->with('status','Berhasil memperbaharui Data');
    }

    public function update_profil(Request $request){
        $this->validate($request,[
            'name'  => 'required',
            'data'  => 'required'
        ]);

        $user = Auth::user();
        $image_name = time().'_'.$user->id.".jpeg";
        if($user->foto){
            if(Storage::exists("public/profil_user/".$user->foto)) {
                Storage::delete("public/profil_user/".$user->foto);
            }
        }
        $request->data->storeAs("public/profil_user",$image_name);

        $user->foto = $image_name;
        $user->save();

        return response()->json([
            'message'   => 'Berhasil memperbaharui foto profil'
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
