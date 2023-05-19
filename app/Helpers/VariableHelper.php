<?php

namespace App\Helpers;

class VariableHelper
{
    public static  $day = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu"];
    public static function getDictOfMonth(){
        return [
            "01"    => "Januari",
            "02"    => "Februari",
            "03"    => "Maret",
            "04"    => "April",
            "05"    => "Mei",
            "06"    => "Juni",
            "07"    => "Juli",
            "08"    => "Agustus",
            "09"    => "September",
            "10"    => "Oktober",
            "11"    => "November",
            "12"    => "Desember",
        ];
    }


    public static function getMonthName($monthNumber){
        if($monthNumber == null)
            return "";
        if(array_key_exists($monthNumber, self::getDictOfMonth())){
            return self::getDictOfMonth()[$monthNumber];
        }
        return "";
    }
    public static function getDayName($dayNumber){
        if($dayNumber == null)
            return "";
        if ($dayNumber <7 & $dayNumber >= 0){
            return self::$day[$dayNumber];
        }
        return "";
    }
    public static function getStatusPengawasanRegular(){
        return [
            "SUBMITEDBYHAWASBID",
            "WAITINGAPPROVALFROMADMIN",
            "APPROVED",
            "NOTRESOLVED"
        ];
    }

    public static function getTagToWordAllowed(){
        return ["p","li","ol","li"];
    }
}