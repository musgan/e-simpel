<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Datatables;
use App\User;
use App\UserLevel;
use App\UserLevelGroup;
use App\Sector;
use DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->sectors = Sector::select('id','nama','alias','category')->orderBy('id','ASC')->get(); 
    }

    public function index()
    {
        //
        $send = [
            'menu'              => 'Master',
            'sub_menu' => 'users',
            'title' => 'Pengguna',
            'menu_sectors'   => $this->sectors
        ];
        return view('admin.users.index',$send);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $selected_sector = [];
        $send = [
            'menu' => 'users',
            'title' => 'Pengguna',
            'user_levels'   => UserLevel::orderBy('id','ASC')->pluck('nama','id'),
            'sectors'   => Sector::orderBy('sectors.category','ASC')
                ->orderBy("sectors.id","ASC")
                ->select(DB::RAW('CONCAT(category," - ",nama) as nama'),"sectors.id as id")
                ->pluck('nama','id'),
            'selected_sector'   => $selected_sector,
            'menu_sectors'   => $this->sectors
        ];
        return view('admin.users.create',$send);
    }

    public function data(){
        // echo"x";
        $user = User::select('users.id','users.name','users.email','user_levels.nama as nama_level')
            ->join('user_levels','user_levels.id','=','user_level_id');
        return Datatables::of($user)->make(true);
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
        $this->validate($request,[
            'name'  => 'required',
            'email'  => 'required|unique:users',
            'password'  => 'required|confirmed|min:6',
            'user_level_id'  => 'required',
            'nip'   => 'required'
        ]);

        if($request->user_level_id == 10 || $request->user_level_id == 4 || $request->user_level_id == 5 || $request->user_level_id == 6 || $request->user_level_id == 7){
            $this->validate($request,[
                'sector_id'  => 'required'
            ]);
        }

        $send = new User;
        $send->name = $request->name;
        $send->nip = $request->nip;
        $send->email = $request->email;
        $send->password = bcrypt($request->password);
        $send->user_level_id = $request->user_level_id;
        $send->save();

        // perbaharui sektor user
        if($request->user_level_id == 10 || $request->user_level_id == 4 || $request->user_level_id == 5 || $request->user_level_id == 6 || $request->user_level_id == 7){
            $batch = array();
            for($i=0; $i<count($request->sector_id); $i++){
                array_push($batch,array('user_level_id'=> $request->user_level_id,
                    'user_id'   => $send->id,
                    'sector_id' => $request->sector_id[$i]
                ));
            }
            UserLevelGroup::insert($batch);
        }

        return redirect(url(session('role').'/users/create'))->with('status','Berhasil Menambah Data');
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
        $viewdata = User::findOrFail($id);
        $my_sector = UserLevelGroup::where('user_id',$id)
            ->select('sector_id')
            ->get()
            ;
        $selected_sector = [];
        foreach ($my_sector as $key => $value) {
            # code...
            array_push($selected_sector, $value['sector_id']);
        }
        // echo implode(" ", $selected_sector);
        
        $send = [
            'menu' => 'users',
            'title' => 'Pengguna',
            'send'  => $viewdata,
            'user_levels'   => UserLevel::orderBy('id','ASC')->pluck('nama','id'),
            'sectors'   => Sector::orderBy('sectors.category','ASC')
                ->orderBy("sectors.id","ASC")
                ->select(DB::RAW('CONCAT(category," - ",nama) as nama'),"sectors.id as id")
                ->pluck('nama','id'),
            'selected_sector'   => $selected_sector,
            'menu_sectors'   => $this->sectors

        ];
        return view('admin.users.edit',$send);
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
        $this->validate($request,[
            'name'  => 'required',
            'user_level_id'  => 'required',
            'nip'   => 'required'
        ]);

        if($request->user_level_id == 10 || $request->user_level_id == 4 || $request->user_level_id == 5 || $request->user_level_id == 6 || $request->user_level_id == 7){
            $this->validate($request,[
                'sector_id'  => 'required'
            ]);            
        }

        if($request->password){
            $this->validate($request,['password'  => 'required|confirmed|min:6']);
        }

        $send = User::findOrFail($id);
        $send->name = $request->name;
        
        if($request->password)
            $send->password = bcrypt($request->password);
        $send->nip = $request->nip;
        $send->user_level_id = $request->user_level_id;
        $send->save();

        UserLevelGroup::where('user_id',$id)
                ->delete();
        // perbaharui sektor user
        if($request->user_level_id == 10 || $request->user_level_id == 4 || $request->user_level_id == 5 || $request->user_level_id == 6 || $request->user_level_id == 7){
            
            $batch = array();
            for($i=0; $i<count($request->sector_id); $i++){
                array_push($batch,array('user_level_id'=> $request->user_level_id,
                    'user_id'   => $id,
                    'sector_id' => $request->sector_id[$i]
                ));
            }
            UserLevelGroup::insert($batch);
        }

        return redirect(url(session('role').'/users/'.$id.'/edit'))->with('status','Berhasil memperbaharui Data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        //
        if($request->ajax()){
            User::where('id',$id)
            ->delete();
            return Response()->json([
                'status'    => "success",
                'msg'       => "Hapus data berhasil"
            ]);

        }
    }
}
