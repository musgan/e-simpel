<?php

namespace App\Report;

use App\Helpers\CostumHelpers;
use App\Helpers\ErpHtml;
use App\Helpers\VariableHelper;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\TemplateProcessor;

class ExportReportPengawasanRegulerHawasbid
{
    private $filename;
    private $templateName;
    private $sectorName;
    public static  $template_path = "public/report/template";
    private $pth_to_save = "public/report/export";
    private $kesesuaian ;
    private $temuan ;

    private $periode;
    private $tanggal_rapat = "";

    public function setFilename($filename){
        $this->filename = $filename;
    }
    public function setTemplateName($templateName){
        $this->templateName = $templateName;
    }

    public function setKesesuaian($kesesuaian){
        $this->kesesuaian = $kesesuaian;
    }
    public function setTemuan($temuan){
        $this->temuan = $temuan;
    }

    public function setSectorName($sectorName){
        $this->sectorName = $sectorName;
    }

    public function setPeriode($periode_bulan, $periode_tahun){
        $this->periode = VariableHelper::getMonthName($periode_bulan)." ".$periode_tahun;
    }

    function getFileTemplate(){
        return self::$template_path."/".$this->templateName;
    }

    public function setTanggalRapat($tanggal_rapat){
        $this->tanggal_rapat = $tanggal_rapat;
    }

    public function exportWord(){
        if(!Storage::exists($this->getFileTemplate()))
            throw new \Exception("Template report pengawasan reguler ".$this->sectorName." Tidak ada. Harap hubungi admin", 400);

        $templateProcessor = new TemplateProcessor(public_path(Storage::url($this->getFileTemplate())));
        $phpword = new PhpWord();
        $this->setBlockKesesuaian($phpword->addSection(), $templateProcessor);
        $this->setBlockTemuan($templateProcessor);

        $this->setOtherBlockProperty($templateProcessor);
        $pth_file_export = $this->pth_to_save."/"."pr_hawasbid_".$this->sectorName."_".time().'.docx';
        $pathToSave = public_path(Storage::url($pth_file_export));
        $templateProcessor->saveAs($pathToSave);
        return $pth_file_export;
    }
    function setBlockTemuan($templateProcessor){
        $templateProcessor->cloneBlock("temuan",$this->temuan->count(), true, true);
        $index_temuan = 1;
        foreach ($this->temuan as $item_temuan){
            $lingkup_temuan_pr = "lingkup_temuan_pengawasan_regular#".$index_temuan;
            $templateProcessor->setValue("lingkup_temuan#".$index_temuan,$item_temuan->nama);
            $templateProcessor->cloneBlock($lingkup_temuan_pr,$item_temuan->pengawasan_regular->count(), true, true);
            $no_pr = 0;
            foreach ($item_temuan->pengawasan_regular as $row_pr){
                $no_pr += 1;
                $templateProcessor->setValue("temuan_item#".$index_temuan."#".$no_pr,strip_tags($row_pr->temuan));
                $this->setTanggalRapat($row_pr->tanggal_rapat_hawasbid);
            }
            $index_temuan += 1;
        }
    }
    function setOtherBlockProperty($templateProcessor){
//        set other property
        $tgl_rapat = CostumHelpers::getDateDMY($this->tanggal_rapat);
        $hari_tanggal_rapat = CostumHelpers::getDateDMY($this->tanggal_rapat, true);
        $templateProcessor->setValue("periode",$this->periode);
        $templateProcessor->setValue("tanggal_rapat",$tgl_rapat);
        $templateProcessor->setValue("hari_tanggal_rapat",$hari_tanggal_rapat);
    }

    function setBlockKesesuaian($section_kesesuaian,$templateProcessor){
        $view_kesesuaian = $this->clearNonHtmlTag(view("template-word.lr-kesesuaian",[
            'kesesuaian'    => $this->kesesuaian
        ])->render());
        ErpHtml::addHtml($section_kesesuaian, $view_kesesuaian, true, false);
        $templateProcessor->cloneBlock("kesesuaian", count($section_kesesuaian->getElements()), true, true);
        foreach ($section_kesesuaian->getElements() as $index=>$el){
            $search_block = "kesesuaian_item#".($index+1);
            if ($el == null)
                $templateProcessor->deleteBlock($search_block);
            else $templateProcessor->setComplexBlock($search_block, $el);
        }
    }

    function clearNonHtmlTag($htmlCode){
        $clear = preg_replace("/[\n\r\t]/","",$htmlCode);

        return preg_replace("[\s+]"," ",$clear);
    }
}