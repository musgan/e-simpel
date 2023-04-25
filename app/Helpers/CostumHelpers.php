<?php
namespace App\Helpers;
use App\SettingPeriodHawasbid;
use Illuminate\Support\Facades\Storage;

class CostumHelpers{

	public static function getContrastColor($hexColor) 
  {

    // hexColor RGB
    $R1 = hexdec(substr($hexColor, 1, 2));
    $G1 = hexdec(substr($hexColor, 3, 2));
    $B1 = hexdec(substr($hexColor, 5, 2));

    // Black RGB
    $blackColor = "#000000";
    $R2BlackColor = hexdec(substr($blackColor, 1, 2));
    $G2BlackColor = hexdec(substr($blackColor, 3, 2));
    $B2BlackColor = hexdec(substr($blackColor, 5, 2));

     // Calc contrast ratio
     $L1 = 0.2126 * pow($R1 / 255, 2.2) +
           0.7152 * pow($G1 / 255, 2.2) +
           0.0722 * pow($B1 / 255, 2.2);

    $L2 = 0.2126 * pow($R2BlackColor / 255, 2.2) +
          0.7152 * pow($G2BlackColor / 255, 2.2) +
          0.0722 * pow($B2BlackColor / 255, 2.2);

    $contrastRatio = 0;
    if ($L1 > $L2) {
        $contrastRatio = (int)(($L1 + 0.05) / ($L2 + 0.05));
    } else {
        $contrastRatio = (int)(($L2 + 0.05) / ($L1 + 0.05));
    }

    // If contrast is more than 5, return black color
    if ($contrastRatio > 5) {
        return '#000000';
    } else { 
        // if not, return white color.
        return '#FFFFFF';
    }
  }

public static function checkActionTindakLanjut($user_level_id, $periode_bulan, $periode_tahun){
	$current_time = strtotime(date('Y-m-d'));
	
	$checkPeriode = SettingPeriodHawasbid::where('periode_bulan', $periode_bulan)
		->where('periode_tahun',$periode_tahun)
		->first();
	if ($checkPeriode) {
		# code...
		$action = 0;
		if($user_level_id == 1){
			$action = 1;
		}else if($user_level_id == 4 || $user_level_id == 5){
			$startp = strtotime($checkPeriode->start_periode_tindak_lanjut);
			$stopp = strtotime($checkPeriode->stop_periode_tindak_lanjut);
			
			if ($startp <= $current_time && $stopp >= $current_time) {
				# code...
				$action = 1;		
			}
		}
		return $action;
	}else{
		return 0;
	}
}

public static function checkActionHawasbid($user_level_id, $periode_bulan, $periode_tahun){
	
	$current_time = strtotime(date('Y-m-d'));
	$checkPeriode = SettingPeriodHawasbid::where('periode_bulan', $periode_bulan)
		->where('periode_tahun',$periode_tahun)
		->first();
	if ($checkPeriode) {
		# code...
		$action = 0;
		if($user_level_id == 1){
			$action = 1;
		}else if($user_level_id == 10){
			$startp = strtotime($checkPeriode->start_input_session);
			$stopp = strtotime($checkPeriode->stop_input_session);
			
			if ($startp <= $current_time && $stopp >= $current_time) {
				# code...
				$action = 1;		
			}
		}
		return $action;
	}else{
		return 0;
	}
}


	public static function getNameMonth($m){
		$bulan = "";
	    switch ($m) {
	        case "01":
	          $bulan = "Januari";
	          # code...
	          break;
	        case "02":
	          $bulan = "Februari";
	          # code...
	          break;
	        case "03":
	          $bulan = "Maret";
	          # code...
	          break;
	        case "04":
	          $bulan = "April";
	          # code...
	          break;
	        case "05":
	          $bulan = "Mei";
	          # code...
	          break;
	        case "06":
	          $bulan = "Juni";
	          # code...
	          break;
	        case "07":
	          $bulan = "Juli";
	          # code...
	          break;
	        case "08":
	          $bulan = "Agustus";
	          # code...
	          break;
	        case "09":
	          $bulan = "September";
	          # code...
	          break;
	        case "10":
	          $bulan = "Oktober";
	          # code...
	          break;
	        case "11":
	          $bulan = "November";
	          # code...
	          break;
	        case "12":
	          $bulan = "Desember";
	          # code...
	          break;
	        
	        default:
	          # code...
	          break;
	      }

	    return $bulan;
	}

    public function uploadToStorage($dir, $files){
        if ($files !== null) {
            foreach ($files as $file) {
                $fname = $file->getClientOriginalName();
                $pth = $dir . "/";
                $fname = $this->checkfileName($fname, $pth);

                $file->storeAs($pth, $fname);
            }
        }
    }

    public function checkfileName($file_name, $pth){
        if(Storage::exists($pth.$file_name)) {
            $path_parts = pathinfo($pth.$file_name);

            $file_name = $this->checkfileName($path_parts['filename']."_copy.".$path_parts['extension'], $pth);
        }
        return $file_name;
    }

}