<?php
namespace App\Helpers;

class CostumHelpers{

	public static function checkActionTindakLanjut($user_level_id, $periode_bulan, $periode_tahun){
		
		$current_time = time();
		$treshold_time_up = strtotime(date('Y-m').'-16');
		$treshold_time_down = strtotime(date('Y-m').'-05');
		$access_periode = date('Y-m',strtotime(date('Y-m').'-01'.' -1 month'));

		$action = 0;

		if($user_level_id == 1){
			$action = 1;
		}else if($user_level_id == 4 || $user_level_id == 5){
			if($treshold_time_up > $current_time && $treshold_time_down <= $current_time){        
				if($access_periode == $periode_tahun.'-'.$periode_bulan){
				  $action = 1;
				}
			}
		}
		return $action;
	}

	public static function checkActionHawasbid($user_level_id, $periode_bulan, $periode_tahun){
		
		$selected_periode = strtotime($periode_tahun.'-'.$periode_bulan.'-05');

		$action = 0;

		if($user_level_id == 1){
			$action = 1;
		}else if($user_level_id == 10){
			$treshold = strtotime(date('Y-m-01').' -1 month');			
			if(date('d') > 4){
				$treshold = strtotime(date('Y-m-01'));
			}

			if($treshold <= $selected_periode)
				$action = 1;
		}

		return $action;
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

}