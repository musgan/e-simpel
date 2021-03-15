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

Route::group(['namespace' => 'Admin','prefix'=>'admin','middleware' => ['auth','role:admin']], function() {
  // Other routes under the Admin namespace here...
	Route::get('home', 'HomeController@index')->name('home');
	Route::resource('akun-saya','MyAccountController',['except' => ['store','destroy','create','show','edit']]);
	Route::post('akun-saya/update-profil','MyAccountController@update_profil');
	
	Route::get('users/data','UserController@data');
	Route::resource('users','UserController');
	
	Route::resource('hawasbid_indikator','HawasbidIndikatorController');

	Route::get('pengawas-bidang/kepaniteraan/{sub_menu}/dokumentasi_rapat','DokumentasiRapatController@index');
	Route::post('pengawas-bidang/kepaniteraan/{sub_menu}/dokumentasi_rapat','DokumentasiRapatController@store');
	Route::delete('pengawas-bidang/kepaniteraan/{sub_menu}/dokumentasi_rapat','DokumentasiRapatController@destroy');

	Route::get('pengawas-bidang/kesektariatan/{sub_menu}/dokumentasi_rapat','DokumentasiRapatController@index');
	Route::post('pengawas-bidang/kesektariatan/{sub_menu}/dokumentasi_rapat','DokumentasiRapatController@store');
	Route::delete('pengawas-bidang/kesektariatan/{sub_menu}/dokumentasi_rapat','DokumentasiRapatController@destroy');


	Route::get('pengawas-bidang/kepaniteraan/{sub_menu}','SecretariatController@index');
	Route::get('pengawas-bidang/kepaniteraan/{sub_menu}/{id}/edit','SecretariatController@edit');
	Route::get('pengawas-bidang/kepaniteraan/{sub_menu}/{id}','SecretariatController@show');
	Route::post('pengawas-bidang/kepaniteraan/{sub_menu}/upload_evidence/{id}','SecretariatController@upload_evidence');
	Route::put('pengawas-bidang/kepaniteraan/{sub_menu}/{id}','SecretariatController@update');
	
	Route::delete('pengawas-bidang/kepaniteraan/{sub_menu}/delete_file/{id}','SecretariatController@destroy_file');

	Route::get('pengawas-bidang/kesektariatan/{sub_menu}','SecretariatController@index');
	Route::get('pengawas-bidang/kesektariatan/{sub_menu}/{id}/edit','SecretariatController@edit');
	Route::get('pengawas-bidang/kesektariatan/{sub_menu}/{id}','SecretariatController@show');
	Route::post('pengawas-bidang/kesektariatan/{sub_menu}/upload_evidence/{id}','SecretariatController@upload_evidence');
	Route::put('pengawas-bidang/kesektariatan/{sub_menu}/{id}','SecretariatController@update');
	Route::delete('pengawas-bidang/kesektariatan/{sub_menu}/delete_file/{id}','SecretariatController@destroy_file');


	Route::get('tindak-lanjutan/kepaniteraan/{sub_menu}/dokumentasi_rapat','TLDokumentasiRapatController@index');
	Route::post('tindak-lanjutan/kepaniteraan/{sub_menu}/dokumentasi_rapat','TLDokumentasiRapatController@store');
	Route::delete('tindak-lanjutan/kepaniteraan/{sub_menu}/dokumentasi_rapat','TLDokumentasiRapatController@destroy');

	Route::get('tindak-lanjutan/kesektariatan/{sub_menu}/dokumentasi_rapat','TLDokumentasiRapatController@index');
	Route::post('tindak-lanjutan/kesektariatan/{sub_menu}/dokumentasi_rapat','TLDokumentasiRapatController@store');
	Route::delete('tindak-lanjutan/kesektariatan/{sub_menu}/dokumentasi_rapat','TLDokumentasiRapatController@destroy');



	Route::get('tindak-lanjutan/kepaniteraan/{sub_menu}','TindakLanjutanController@index');
	Route::get('tindak-lanjutan/kepaniteraan/{sub_menu}/{id}/edit','TindakLanjutanController@edit');
	Route::get('tindak-lanjutan/kepaniteraan/{sub_menu}/{id}','TindakLanjutanController@show');
	Route::post('tindak-lanjutan/kepaniteraan/{sub_menu}/upload_evidence/{id}','TindakLanjutanController@upload_evidence');
	Route::put('tindak-lanjutan/kepaniteraan/{sub_menu}/{id}','TindakLanjutanController@update');
	
	Route::delete('tindak-lanjutan/kepaniteraan/{sub_menu}/delete_file/{id}','TindakLanjutanController@destroy_file');

	Route::get('tindak-lanjutan/kesektariatan/{sub_menu}','TindakLanjutanController@index');
	Route::get('tindak-lanjutan/kesektariatan/{sub_menu}/{id}/edit','TindakLanjutanController@edit');
	Route::get('tindak-lanjutan/kesektariatan/{sub_menu}/{id}','TindakLanjutanController@show');
	Route::post('tindak-lanjutan/kesektariatan/{sub_menu}/upload_evidence/{id}','TindakLanjutanController@upload_evidence');
	Route::put('tindak-lanjutan/kesektariatan/{sub_menu}/{id}','TindakLanjutanController@update');
	Route::delete('tindak-lanjutan/kesektariatan/{sub_menu}/delete_file/{id}','TindakLanjutanController@destroy_file');


	Route::get('laporan/hawasbid','ReportHawasbid@index');
	Route::post('laporan/hawasbid','ReportHawasbid@print_laporan');

	Route::resource('sector_hawasbid','SectorHawasbid', ['except' => ['store','destroy','create','show']]);
	Route::resource('generate_indikator','GenerateIndikatorController', ['except' => ['update','create','show','edit','destroy']]);
	Route::delete('generate_indikator','GenerateIndikatorController@delete_periode');

});

// MPN or Monitor Pengadilan Negeri
Route::group(['namespace' => 'Admin','prefix'=>'mpn','middleware' => ['auth','role:mpn']], function() {
  // Other routes under the Admin namespace here...
	Route::get('home', 'HomeController@index')->name('home');
	Route::resource('akun-saya','MyAccountController',['except' => ['store','destroy','create','show','edit']]);
	Route::post('akun-saya/update-profil','MyAccountController@update_profil');
	
	
	Route::resource('hawasbid_indikator','HawasbidIndikatorController',['except'	=> ['create','edit','update','store','destroy']]);

	Route::get('pengawas-bidang/kepaniteraan/{sub_menu}/dokumentasi_rapat','DokumentasiRapatController@index');
	
	Route::get('pengawas-bidang/kesektariatan/{sub_menu}/dokumentasi_rapat','DokumentasiRapatController@index');
	

	Route::get('pengawas-bidang/kepaniteraan/{sub_menu}','SecretariatController@index');
	Route::get('pengawas-bidang/kepaniteraan/{sub_menu}/{id}','SecretariatController@show');
	
	
	Route::get('pengawas-bidang/kesektariatan/{sub_menu}','SecretariatController@index');
	Route::get('pengawas-bidang/kesektariatan/{sub_menu}/{id}','SecretariatController@show');
	

	Route::get('tindak-lanjutan/kepaniteraan/{sub_menu}/dokumentasi_rapat','TLDokumentasiRapatController@index');
	
	Route::get('tindak-lanjutan/kesektariatan/{sub_menu}/dokumentasi_rapat','TLDokumentasiRapatController@index');
	


	Route::get('tindak-lanjutan/kepaniteraan/{sub_menu}','TindakLanjutanController@index');
	Route::get('tindak-lanjutan/kepaniteraan/{sub_menu}/{id}/edit','TindakLanjutanController@edit');
	Route::get('tindak-lanjutan/kepaniteraan/{sub_menu}/{id}','TindakLanjutanController@show');
	
	
	Route::get('tindak-lanjutan/kesektariatan/{sub_menu}','TindakLanjutanController@index');
	Route::get('tindak-lanjutan/kesektariatan/{sub_menu}/{id}/edit','TindakLanjutanController@edit');
	Route::get('tindak-lanjutan/kesektariatan/{sub_menu}/{id}','TindakLanjutanController@show');
	
	Route::get('laporan/hawasbid','ReportHawasbid@index');
	Route::post('laporan/hawasbid','ReportHawasbid@print_laporan');

});

// HAWASBID
Route::group(['namespace' => 'Admin','prefix'=>'hawasbid','middleware' => ['auth','role:hawasbid']], function() {
  // Other routes under the Admin namespace here...
	Route::get('home', 'HomeController@index')->name('home');
	Route::resource('akun-saya','MyAccountController',['except' => ['store','destroy','create','show','edit']]);
	Route::post('akun-saya/update-profil','MyAccountController@update_profil');
	
	Route::get('pengawas-bidang/kepaniteraan/{sub_menu}/dokumentasi_rapat','DokumentasiRapatController@index');
	Route::post('pengawas-bidang/kepaniteraan/{sub_menu}/dokumentasi_rapat','DokumentasiRapatController@store');
	Route::delete('pengawas-bidang/kepaniteraan/{sub_menu}/dokumentasi_rapat','DokumentasiRapatController@destroy');

	Route::get('pengawas-bidang/kesektariatan/{sub_menu}/dokumentasi_rapat','DokumentasiRapatController@index');
	Route::post('pengawas-bidang/kesektariatan/{sub_menu}/dokumentasi_rapat','DokumentasiRapatController@store');
	Route::delete('pengawas-bidang/kesektariatan/{sub_menu}/dokumentasi_rapat','DokumentasiRapatController@destroy');
	

	Route::get('pengawas-bidang/kepaniteraan/{sub_menu}','SecretariatController@index');
	Route::get('pengawas-bidang/kepaniteraan/{sub_menu}/{id}/edit','SecretariatController@edit');
	Route::get('pengawas-bidang/kepaniteraan/{sub_menu}/{id}','SecretariatController@show');
	Route::post('pengawas-bidang/kepaniteraan/{sub_menu}/upload_evidence/{id}','SecretariatController@upload_evidence');
	Route::put('pengawas-bidang/kepaniteraan/{sub_menu}/{id}','SecretariatController@update');
	
	Route::delete('pengawas-bidang/kepaniteraan/{sub_menu}/delete_file/{id}','SecretariatController@destroy_file');

	Route::get('pengawas-bidang/kesektariatan/{sub_menu}','SecretariatController@index');
	Route::get('pengawas-bidang/kesektariatan/{sub_menu}/{id}/edit','SecretariatController@edit');
	Route::get('pengawas-bidang/kesektariatan/{sub_menu}/{id}','SecretariatController@show');
	Route::post('pengawas-bidang/kesektariatan/{sub_menu}/upload_evidence/{id}','SecretariatController@upload_evidence');
	Route::put('pengawas-bidang/kesektariatan/{sub_menu}/{id}','SecretariatController@update');
	Route::delete('pengawas-bidang/kesektariatan/{sub_menu}/delete_file/{id}','SecretariatController@destroy_file');

	

	Route::get('laporan/hawasbid','ReportHawasbid@index');
	Route::post('laporan/hawasbid','ReportHawasbid@print_laporan');
});

// KASUBAG & PANMUD
Route::group(['namespace' => 'Admin','prefix'=>'kapan','middleware' => ['auth','role:kapan']], function() {
  // Other routes under the Admin namespace here...
	Route::get('home', 'HomeController@index')->name('home');
	Route::resource('akun-saya','MyAccountController',['except' => ['store','destroy','create','show','edit']]);
	Route::post('akun-saya/update-profil','MyAccountController@update_profil');
	
	Route::get('tindak-lanjutan/kepaniteraan/{sub_menu}/dokumentasi_rapat','TLDokumentasiRapatController@index');
	Route::post('tindak-lanjutan/kepaniteraan/{sub_menu}/dokumentasi_rapat','TLDokumentasiRapatController@store');
	Route::delete('tindak-lanjutan/kepaniteraan/{sub_menu}/dokumentasi_rapat','TLDokumentasiRapatController@destroy');

	Route::get('tindak-lanjutan/kesektariatan/{sub_menu}/dokumentasi_rapat','TLDokumentasiRapatController@index');
	Route::post('tindak-lanjutan/kesektariatan/{sub_menu}/dokumentasi_rapat','TLDokumentasiRapatController@store');
	Route::delete('tindak-lanjutan/kesektariatan/{sub_menu}/dokumentasi_rapat','TLDokumentasiRapatController@destroy');


	Route::get('tindak-lanjutan/kepaniteraan/{sub_menu}','TindakLanjutanController@index');
	Route::get('tindak-lanjutan/kepaniteraan/{sub_menu}/{id}/edit','TindakLanjutanController@edit');
	Route::get('tindak-lanjutan/kepaniteraan/{sub_menu}/{id}','TindakLanjutanController@show');
	Route::post('tindak-lanjutan/kepaniteraan/{sub_menu}/upload_evidence/{id}','TindakLanjutanController@upload_evidence');
	Route::put('tindak-lanjutan/kepaniteraan/{sub_menu}/{id}','TindakLanjutanController@update');
	
	Route::delete('tindak-lanjutan/kepaniteraan/{sub_menu}/delete_file/{id}','TindakLanjutanController@destroy_file');

	Route::get('tindak-lanjutan/kesektariatan/{sub_menu}','TindakLanjutanController@index');
	Route::get('tindak-lanjutan/kesektariatan/{sub_menu}/{id}/edit','TindakLanjutanController@edit');
	Route::get('tindak-lanjutan/kesektariatan/{sub_menu}/{id}','TindakLanjutanController@show');
	Route::post('tindak-lanjutan/kesektariatan/{sub_menu}/upload_evidence/{id}','TindakLanjutanController@upload_evidence');
	Route::put('tindak-lanjutan/kesektariatan/{sub_menu}/{id}','TindakLanjutanController@update');
	Route::delete('tindak-lanjutan/kesektariatan/{sub_menu}/delete_file/{id}','TindakLanjutanController@destroy_file');


	Route::get('laporan/hawasbid','ReportHawasbid@index');
	Route::post('laporan/hawasbid','ReportHawasbid@print_laporan');

	Route::resource('sector_hawasbid','SectorHawasbid', ['except' => ['store','destroy','create','show']]);
	Route::resource('generate_indikator','GenerateIndikatorController', ['except' => ['update','create','show','edit','destroy']]);
	Route::delete('generate_indikator','GenerateIndikatorController@delete_periode');

});

Route::get('redev','RedirectLinkController@redev');// redirect evidence