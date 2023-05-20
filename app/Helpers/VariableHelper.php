<?php

namespace App\Helpers;

use DOMDocument;

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

    public static function getNodeOfHtml($html){
        $html = html_entity_decode(strip_tags($html,"<p><ol><ul><li>"));
        $content = [];
        $dom = new DOMDocument();
        $dom->preserveWhiteSpace = false;
        $dom->loadHTML($html);
        foreach ($dom->getElementsByTagName('*') as $node){
            if(in_array($node->nodeName, VariableHelper::getTagToWordAllowed())){
                $item = [];
                $parentNode = $node->parentNode;
                $childNodes = $node->childNodes;
                if($parentNode->tagName == "body" && in_array($node->tagName,["ol","ul"]) === false) {
                    $item = [
                        "nodeName" => $node->nodeName,
                        "content" => $node->nodeValue
                    ];
                }else {
                    if($parentNode->tagName == "body" && in_array($node->tagName,["ol","ul"])) {
                        $item = [
                            "nodeName" => $node->nodeName,
                            "content" => self::getChildNode($childNodes)
                        ];
                    }
                }
                if (count($item) > 0)
                    array_push($content, $item);
            }
        }
        return $content;
    }
    public static function getChildNode($nodes){
        $content = [];
        foreach ($nodes as $node){
            $item = [
                "nodeName" => $node->nodeName,
                "content" => $node->nodeValue
            ];
            array_push($content,$item);
        }
        return $content;
    }

    public static function getPlainTextOfHtml($content){
        $text = "";
        $no = 1;
        foreach ($content as $row){
            $rowNodeName = $row['nodeName'];
            $rowContent = $row['content'];
            if($text !== "")
                $text .="\n";
            if(in_array($rowNodeName, ["ol","ul"])){
                $text .= self::getPlainTextOfHtml($rowContent);
            }else if($rowNodeName == "li"){
                $text .=$no.". ".$rowContent;
                $no += 1;
            }else if($rowNodeName == "p"){
                $text .= $rowContent;
            }
        }
        return $text;
    }
    public static function isNullOrEmptyString($str){
        return ($str === null || trim($str) === '');
    }
}