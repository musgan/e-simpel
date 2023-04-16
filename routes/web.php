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

Route::group(['namespace' => 'Admin','middleware' => ['auth']], function() {
	Route::get('home', 'HomeController@index')
		->name('home')
		->middleware(['role:admin,mpn,hawasbid,kapan']);
	Route::middleware(['role:admin,mpn,hawasbid,kapan'])->resource('akun-saya','MyAccountController',['except' => ['store','destroy','create','show','edit']]);
	
	Route::post('akun-saya/update-profil','MyAccountController@update_profil')
		->middleware('role:admin,mpn,hawasbid,kapan');

	Route::get('users/data','UserController@data')
		->middleware('role:admin');
	Route::middleware('role:admin')
		->resource('users','UserController');
	
	Route::middleware('role:admin')->resource('hawasbid_indikator','HawasbidIndikatorController');
	
	Route::get('hawasbid_indikator','HawasbidIndikatorController@index')
		->middleware('role:admin,mpn');
	Route::get('hawasbid_indikator/{id}','HawasbidIndikatorController@show')
		->middleware('role:admin,mpn,hawasbid');
	Route::get('hawasbid_indikator','HawasbidIndikatorController@create')
		->middleware('role:admin');
	Route::post('hawasbid_indikator','HawasbidIndikatorController@post')
		->middleware('role:admin');
	Route::get('hawasbid_indikator/{id}','HawasbidIndikatorController@edit')
		->middleware('role:admin');
	Route::put('hawasbid_indikator/{id}','HawasbidIndikatorController@update')
		->middleware('role:admin');
	Route::delete('hawasbid_indikator/{id}','HawasbidIndikatorController@destroy')
		->middleware('role:admin');
	
	Route::middleware('role:admin')->resource('setting_time_hawasbid','SettingTimeHawasbid');
	
	
	Route::get('pengawas-bidang/kepaniteraan/{sub_menu}/dokumentasi_rapat','DokumentasiRapatController@index')
		->middleware('role:admin,mpn,hawasbid');
	Route::post('pengawas-bidang/kepaniteraan/{sub_menu}/dokumentasi_rapat','DokumentasiRapatController@store')
		->middleware('role:admin,hawasbid');
	Route::delete('pengawas-bidang/kepaniteraan/{sub_menu}/dokumentasi_rapat','DokumentasiRapatController@destroy')
		->middleware('role:admin,hawasbid');
	
	Route::get('pengawas-bidang/kesekretariatan/{sub_menu}/dokumentasi_rapat','DokumentasiRapatController@index')
		->middleware('role:admin,mpn,hawasbid');
	Route::post('pengawas-bidang/kesekretariatan/{sub_menu}/dokumentasi_rapat','DokumentasiRapatController@store')
		->middleware('role:admin,hawasbid');
	Route::delete('pengawas-bidang/kesekretariatan/{sub_menu}/dokumentasi_rapat','DokumentasiRapatController@destroy')
		->middleware('role:admin,hawasbid');
	
	Route::get('pengawas-bidang/kepaniteraan/{sub_menu}','SecretariatController@index')
		->middleware('role:admin,mpn,hawasbid');
	Route::get('pengawas-bidang/kepaniteraan/{sub_menu}/{id}/edit','SecretariatController@edit')
		->middleware('role:admin,hawasbid');
	Route::get('pengawas-bidang/kepaniteraan/{sub_menu}/{id}','SecretariatController@show')
		->middleware('role:admin,mpn,hawasbid');
	Route::post('pengawas-bidang/kepaniteraan/{sub_menu}/upload_evidence/{id}','SecretariatController@upload_evidence')
		->middleware('role:admin,hawasbid');
	Route::put('pengawas-bidang/kepaniteraan/{sub_menu}/{id}','SecretariatController@update')
		->middleware('role:admin,hawasbid');
	Route::delete('pengawas-bidang/kepaniteraan/{sub_menu}/delete_file/{id}','SecretariatController@destroy_file')
	->middleware('role:admin,hawasbid');

	Route::get('pengawas-bidang/kesekretariatan/{sub_menu}','SecretariatController@index')
		->middleware('role:admin,mpn,hawasbid');
	Route::get('pengawas-bidang/kesekretariatan/{sub_menu}/{id}/edit','SecretariatController@edit')
		->middleware('role:admin,hawasbid');
	Route::get('pengawas-bidang/kesekretariatan/{sub_menu}/{id}','SecretariatController@show')
		->middleware('role:admin,mpn,hawasbid');
	Route::post('pengawas-bidang/kesekretariatan/{sub_menu}/upload_evidence/{id}','SecretariatController@upload_evidence')
		->middleware('role:admin,hawasbid');
	Route::put('pengawas-bidang/kesekretariatan/{sub_menu}/{id}','SecretariatController@update')
		->middleware('role:admin,hawasbid');
	Route::delete('pengawas-bidang/kesekretariatan/{sub_menu}/delete_file/{id}','SecretariatController@destroy_file')
		->middleware('role:admin,hawasbid');

	Route::get('tindak-lanjutan/kepaniteraan/{sub_menu}/dokumentasi_rapat','TLDokumentasiRapatController@index')
		->middleware('role:admin,mpn,kapan');
	Route::post('tindak-lanjutan/kepaniteraan/{sub_menu}/dokumentasi_rapat','TLDokumentasiRapatController@store')
		->middleware('role:admin,kapan');
	Route::delete('tindak-lanjutan/kepaniteraan/{sub_menu}/dokumentasi_rapat','TLDokumentasiRapatController@destroy')
		->middleware('role:admin,kapan');

	Route::get('tindak-lanjutan/kesekretariatan/{sub_menu}/dokumentasi_rapat','TLDokumentasiRapatController@index')
		->middleware('role:admin,kapan,mpn');
	Route::post('tindak-lanjutan/kesekretariatan/{sub_menu}/dokumentasi_rapat','TLDokumentasiRapatController@store')
		->middleware('role:admin,kapan');
	Route::delete('tindak-lanjutan/kesekretariatan/{sub_menu}/dokumentasi_rapat','TLDokumentasiRapatController@destroy')
		->middleware('role:admin,kapan');

	Route::get('tindak-lanjutan/kepaniteraan/{sub_menu}','TindakLanjutanController@index')
		->middleware('role:admin,kapan,mpn');
	Route::get('tindak-lanjutan/kepaniteraan/{sub_menu}/{id}/edit','TindakLanjutanController@edit')
		->middleware('role:admin,kapan,mpn');
	Route::get('tindak-lanjutan/kepaniteraan/{sub_menu}/{id}','TindakLanjutanController@show')
		->middleware('role:admin,kapan,mpn');
	Route::post('tindak-lanjutan/kepaniteraan/{sub_menu}/upload_evidence/{id}','TindakLanjutanController@upload_evidence')
		->middleware('role:admin,kapan');
	Route::put('tindak-lanjutan/kepaniteraan/{sub_menu}/{id}','TindakLanjutanController@update')
		->middleware('role:admin,kapan');
	
	Route::delete('tindak-lanjutan/kepaniteraan/{sub_menu}/delete_file/{id}','TindakLanjutanController@destroy_file')
		->middleware('role:admin,kapan');
	
	Route::get('tindak-lanjutan/kesekretariatan/{sub_menu}','TindakLanjutanController@index')
		->middleware('role:admin,kapan,mpn');
	Route::get('tindak-lanjutan/kesekretariatan/{sub_menu}/{id}/edit','TindakLanjutanController@edit')
		->middleware('role:admin,kapan,mpn');
	Route::get('tindak-lanjutan/kesekretariatan/{sub_menu}/{id}','TindakLanjutanController@show')
		->middleware('role:admin,kapan,mpn');
	Route::post('tindak-lanjutan/kesekretariatan/{sub_menu}/upload_evidence/{id}','TindakLanjutanController@upload_evidence')
		->middleware('role:admin,kapan');
	Route::put('tindak-lanjutan/kesekretariatan/{sub_menu}/{id}','TindakLanjutanController@update')
		->middleware('role:admin,kapan');
	Route::delete('tindak-lanjutan/kesekretariatan/{sub_menu}/delete_file/{id}','TindakLanjutanController@destroy_file')
		->middleware('role:admin,kapan');

	Route::get('laporan/hawasbid','ReportHawasbid@index')
		->middleware('role:admin,mpn,hawasbid,kapan');
	Route::post('laporan/hawasbid','ReportHawasbid@print_laporan')
		->middleware('role:admin,mpn,hawasbid,kapan');

	Route::middleware('role:admin,kapan')->resource('sector_hawasbid','SectorHawasbid', ['except' => ['store','destroy','create','show']]);
	Route::middleware('role:admin,kapan')->resource('generate_indikator','GenerateIndikatorController', ['except' => ['update','create','show','edit','destroy']]);
	Route::middleware('role:admin,kapan')->delete('generate_indikator','GenerateIndikatorController@delete_periode');

	Route::get('performa-hawasbid','PerformaHawasbidController@index')
	->middleware('role:admin,kapan');

	Route::post('performa-hawasbid','PerformaHawasbidController@store')
	->middleware('role:admin,kapan');
});

Route::get('redev','RedirectLinkController@redev');// redirect evidence