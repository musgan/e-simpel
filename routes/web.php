<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/','Auth\LoginController@showLoginForm');
Auth::routes();

Route::get('/token-failed', function () {
    return view('token_failed');
});

Route::middleware(['auth','can:master'])->resource('variables','VariableController',['except' => ['store','destroy','create','show']]);
Route::post('variables/gettable', 'VariableController@getTable')->middleware(['auth','can:master']);

Route::group(['namespace' => 'Admin','middleware' => ['auth']], function() {
	Route::get('home', 'HomeController@index')
		->name('home');
	Route::resource('akun-saya','MyAccountController',['except' => ['store','destroy','create','show','edit']]);
	
	Route::post('akun-saya/update-profil','MyAccountController@update_profil');

	Route::get('users/data','UserController@data')->middleware('can:master');
	Route::middleware('can:master')->resource('users','UserController');

	Route::get('hawasbid_indikator','HawasbidIndikatorController@index')
		->middleware('can:master');
    Route::get('hawasbid_indikator/create','HawasbidIndikatorController@create')
        ->middleware('can:master');
    Route::get('hawasbid_indikator/{id}/edit','HawasbidIndikatorController@edit')
        ->middleware('can:master');
    Route::get('hawasbid_indikator/{id}','HawasbidIndikatorController@show')
		->middleware('can:master');
    Route::post('hawasbid_indikator/gettable','HawasbidIndikatorController@getTable')
        ->middleware('can:master');
	Route::post('hawasbid_indikator','HawasbidIndikatorController@post')
		->middleware('can:master');
	Route::put('hawasbid_indikator/{id}','HawasbidIndikatorController@update')
		->middleware('can:master');
	Route::delete('hawasbid_indikator/{id}','HawasbidIndikatorController@destroy')
		->middleware('can:master');

    Route::middleware('can:master')->resource('setting_time_hawasbid','SettingTimeHawasbid');

	Route::post('pengawas-bidang/{sub_menu_category}/{sub_menu}/dokumentasi_rapat','DokumentasiRapatController@store')
		->middleware('can:pengawasan-hawasbid,sub_menu_category,sub_menu');
    Route::post('pengawas-bidang/{sub_menu_category}/{sub_menu}/dokumentasi_rapat/gettable','DokumentasiRapatController@getTable')
        ->middleware('can:pengawasan-hawasbid.view,sub_menu_category,sub_menu');
    Route::delete('pengawas-bidang/{sub_menu_category}/{sub_menu}/dokumentasi_rapat','DokumentasiRapatController@destroy')
		->middleware('can:pengawasan-hawasbid,sub_menu_category,sub_menu');

	Route::get('pengawas-bidang/{sub_menu_category}/{sub_menu}','SecretariatController@index')
        ->middleware('can:pengawasan-hawasbid.view,sector_category,sector_alias');
//	Route::get('pengawas-bidang/{sub_menu_category}/{sub_menu}/{id}/edit','SecretariatController@edit')
//        ->middleware('can:pengawasan-hawasbid,sector_category,sector_alias');
	Route::get('pengawas-bidang/{sub_menu_category}/{sub_menu}/{id}','SecretariatController@show')
        ->middleware('can:pengawasan-hawasbid.view,sub_menu_category,sub_menu');
    Route::post('pengawas-bidang/{sub_menu_category}/{sub_menu}/gettable','SecretariatController@getTable')
        ->middleware('can:pengawasan-hawasbid.view,sub_menu_category,sub_menu');
//    Route::post('pengawas-bidang/{sub_menu_category}/{sub_menu}/upload_evidence/{id}','SecretariatController@upload_evidence')
//		->middleware('role:admin,hawasbid');
//	Route::put('pengawas-bidang/{sub_menu_category}/{sub_menu}/{id}','SecretariatController@update')
//		->middleware('role:admin,hawasbid');

    Route::get('tindak-lanjutan/{sub_menu_category}/{sub_menu}','TindakLanjutanController@index')
        ->middleware('can:pengawasan-tl.view,sector_category,sector_alias');
    Route::get('tindak-lanjutan/{sub_menu_category}/{sub_menu}/{id}/edit','TindakLanjutanController@edit')
        ->middleware('can:pengawasan-tl,sector_category,sector_alias');
    Route::get('tindak-lanjutan/{sub_menu_category}/{sub_menu}/{id}','TindakLanjutanController@show')
        ->middleware('can:pengawasan-tl.view,sector_category,sector_alias');
    Route::post('tindak-lanjutan/{sub_menu_category}/{sub_menu}/gettable','TindakLanjutanController@getTable')
        ->middleware('can:pengawasan-tl.view,sector_category,sector_alias');
    Route::post('tindak-lanjutan/{sub_menu_category}/{sub_menu}/upload_evidence/{id}','TindakLanjutanController@upload_evidence')
        ->middleware('can:pengawasan-tl,sector_category,sector_alias');
    Route::put('tindak-lanjutan/{sub_menu_category}/{sub_menu}/{id}','TindakLanjutanController@update')
        ->middleware('can:pengawasan-tl,sector_category,sector_alias');

    Route::post('tindak-lanjutan/{sub_menu_category}/{sub_menu}/dokumentasi_rapat','DokumentasiRapatController@store')
        ->middleware('can:pengawasan-tl,sector_category,sector_alias');
    Route::post('tindak-lanjutan/{sub_menu_category}/{sub_menu}/dokumentasi_rapat/gettable','DokumentasiRapatController@getTable')
        ->middleware('can:pengawasan-tl.view,sector_category,sector_alias');
    Route::delete('tindak-lanjutan/{sub_menu_category}/{sub_menu}/dokumentasi_rapat','DokumentasiRapatController@destroy')
        ->middleware('can:pengawasan.view,sector_category,sector_alias');

	Route::get('laporan/hawasbid','ReportHawasbid@index');
	Route::post('laporan/hawasbid','ReportHawasbid@print_laporan');

	Route::middleware('can:master')->resource('sector_hawasbid','SectorHawasbid', ['except' => ['store','destroy','create','show']]);
	Route::middleware('can:master')->resource('generate_indikator','GenerateIndikatorController', ['except' => ['update','create','show','edit','destroy']]);
	Route::middleware('can:master')->delete('generate_indikator','GenerateIndikatorController@delete_periode');

	Route::get('performa-hawasbid','PerformaHawasbidController@index')
	    ->middleware('can:master');

	Route::post('performa-hawasbid','PerformaHawasbidController@store')
	    ->middleware('can:master');
});

Route::group(["prefix" => "pr",'middleware' => ['auth']], function() {
    Route::get("lingkup-pengawasan", "LingkupPengawasanController@index")
        ->middleware('can:master');
    Route::get("lingkup-pengawasan/create", "LingkupPengawasanController@create")->middleware('can:master');
    Route::get("lingkup-pengawasan/{id}", "LingkupPengawasanController@show")->middleware('can:master');
    Route::post("lingkup-pengawasan", "LingkupPengawasanController@store")->middleware('can:master');
    Route::post("lingkup-pengawasan/gettable", "LingkupPengawasanController@getTable")->middleware('can:master');
    Route::get("lingkup-pengawasan/{id}/edit", "LingkupPengawasanController@edit")->middleware('can:master');
    Route::put("lingkup-pengawasan/{id}", "LingkupPengawasanController@update")->middleware('can:master');
    Route::delete("lingkup-pengawasan/{id}", "LingkupPengawasanController@destroy")->middleware('can:master');

    Route::get("lingkup-pengawasan-bidang", "LingkupPengawasanBidangController@index")->middleware('can:master');
    Route::post("lingkup-pengawasan-bidang/gettable", "LingkupPengawasanBidangController@getTable")->middleware('can:master');
    Route::get("lingkup-pengawasan-bidang/create", "LingkupPengawasanBidangController@create")->middleware('can:master');
    Route::post("lingkup-pengawasan-bidang", "LingkupPengawasanBidangController@store")->middleware('can:master');
    Route::get("lingkup-pengawasan-bidang/{sector_id}/edit", "LingkupPengawasanBidangController@edit")->middleware('can:master');
    Route::put("lingkup-pengawasan-bidang/{sector_id}", "LingkupPengawasanBidangController@update")->middleware('can:master');

    Route::get('pengawasan-bidang/{sector_category}/{sector_alias}','PengawasanRegulerController@index')->middleware('can:pengawasan-hawasbid.view,sector_category,sector_alias');
    Route::get('pengawasan-bidang/{sector_category}/{sector_alias}/create','PengawasanRegulerController@create')->middleware('can:pengawasan-hawasbid,sector_category,sector_alias');
    Route::post('pengawasan-bidang/{sector_category}/{sector_alias}','PengawasanRegulerController@store')->middleware('can:pengawasan-hawasbid,sector_category,sector_alias');
    Route::post('pengawasan-bidang/{sector_category}/{sector_alias}/gettable','PengawasanRegulerController@getTable')->middleware('can:pengawasan-hawasbid.view,sector_category,sector_alias');
    Route::post('pengawasan-bidang/{sector_category}/{sector_alias}/download','PengawasanRegulerController@download')->middleware('can:pengawasan-hawasbid.view,sector_category,sector_alias');
    Route::get('pengawasan-bidang/{sector_category}/{sector_alias}/{id}/edit','PengawasanRegulerController@edit')->middleware('can:pengawasan-hawasbid,sector_category,sector_alias');
    Route::put('pengawasan-bidang/{sector_category}/{sector_alias}/{id}','PengawasanRegulerController@update')->middleware('can:pengawasan-hawasbid,sector_category,sector_alias');
    Route::get('pengawasan-bidang/{sector_category}/{sector_alias}/{id}','PengawasanRegulerController@show')->middleware('can:pengawasan-hawasbid.view,sector_category,sector_alias');
    Route::delete('pengawasan-bidang/{sector_category}/{sector_alias}/{id}','PengawasanRegulerController@destroy')->middleware('can:pengawasan-hawasbid,sector_category,sector_alias');
    Route::post('pengawasan-bidang/{sector_category}/{sector_alias}/uploadtemplate','PengawasanRegulerController@uploadTemplate')->middleware('can:pengawasan-hawasbid,sector_category,sector_alias');

    Route::get('kesesuaian/{sector_category}/{sector_alias}/create','KesesuaianPengawasanRegularController@create')->middleware('can:kesesuaian,sector_category,sector_alias');
    Route::get('kesesuaian/{sector_category}/{sector_alias}/getbyperiode','KesesuaianPengawasanRegularController@getByPeriode')->middleware('can:kesesuaian.view,sector_category,sector_alias');
    Route::post('kesesuaian/{sector_category}/{sector_alias}','KesesuaianPengawasanRegularController@store')->middleware('can:kesesuaian,sector_category,sector_alias');
    Route::post('kesesuaian/{sector_category}/{sector_alias}/gettable','KesesuaianPengawasanRegularController@getTable')->middleware('can:kesesuaian.view,sector_category,sector_alias');
    Route::get('kesesuaian/{sector_category}/{sector_alias}/{id}/edit','KesesuaianPengawasanRegularController@edit')->middleware('can:kesesuaian,sector_category,sector_alias');
    Route::put('kesesuaian/{sector_category}/{sector_alias}/{id}','KesesuaianPengawasanRegularController@update')->middleware('can:kesesuaian,sector_category,sector_alias');
    Route::get('kesesuaian/{sector_category}/{sector_alias}/{id}','KesesuaianPengawasanRegularController@show')->middleware('can:kesesuaian.view,sector_category,sector_alias');
    Route::delete('kesesuaian/{sector_category}/{sector_alias}/{id}','KesesuaianPengawasanRegularController@destroy')->middleware('can:kesesuaian,sector_category,sector_alias');

    Route::get('tindak-lanjutan/{sector_category}/{sector_alias}','TindakLanjutPengawasanRegularController@index')->middleware('can:pengawasan-tl.view,sector_category,sector_alias');
    Route::post('tindak-lanjutan/{sector_category}/{sector_alias}/gettable','TindakLanjutPengawasanRegularController@getTable')->middleware('can:pengawasan-tl.view,sector_category,sector_alias');
    Route::post('tindak-lanjutan/{sector_category}/{sector_alias}/download','TindakLanjutPengawasanRegularController@download')->middleware('can:pengawasan-tl.view,sector_category,sector_alias');
    Route::get('tindak-lanjutan/{sector_category}/{sector_alias}/{id}','TindakLanjutPengawasanRegularController@show')->middleware('can:pengawasan-tl.view,sector_category,sector_alias');
    Route::get('tindak-lanjutan/{sector_category}/{sector_alias}/{id}/edit','TindakLanjutPengawasanRegularController@edit')->middleware('can:pengawasan-tl,sector_category,sector_alias');
    Route::put('tindak-lanjutan/{sector_category}/{sector_alias}/{id}','TindakLanjutPengawasanRegularController@update')->middleware('can:pengawasan-tl,sector_category,sector_alias');

    Route::post('dokumentasi-rapat/{sector_category}/{sector_alias}','DokumentasiRapatPengawasanRegularController@store')->middleware('can:dokumentasirapat.view,sector_category,sector_alias');
    Route::post('dokumentasi-rapat/{sector_category}/{sector_alias}/gettable','DokumentasiRapatPengawasanRegularController@getTable')->middleware('can:dokumentasirapat.view,sector_category,sector_alias');
    Route::delete('dokumentasi-rapat/{sector_category}/{sector_alias}','DokumentasiRapatPengawasanRegularController@destroy')->middleware('can:dokumentasirapat.view,sector_category,sector_alias');
});

Route::get('redev','RedirectLinkController@redev');// redirect evidence