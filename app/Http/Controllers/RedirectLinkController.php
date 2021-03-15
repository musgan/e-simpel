<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class RedirectLinkController extends Controller
{
    //
    public function redev(Request $request){

        // $full_url = url()->full();
        // $this_url = url()->current();

    	$url = $request->get('url');
    	$url = str_replace("__", "&", $url);
        echo '<link rel="stylesheet" type="text/css" href="'.asset('css/bootstrap.css').'">';
    	echo '<div class="col-md-12">';
    	echo "<h2>HARAP SEBELUMNYA ANDA TELAH LOGIN DI WEBSITE E-SIMPEL</h2>";
    	echo "<h2>Jika Belum Login, Silahkan Anda Login lalu muat ulang halaman ini</h2>";
    	echo "<h3><a href='".url(session('role').'/'.$url)."' style='text-decoration: none'>Lanjutkan</a></h3>";
    	echo '</div>';

    	// return redirect("");
    }
}
