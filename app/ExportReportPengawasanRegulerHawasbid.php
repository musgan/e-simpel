<?php

namespace App;

use App\Helpers\ErpHtml;
use Illuminate\Support\Facades\Storage;
use \PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Html;
use PhpOffice\PhpWord\Shared\XMLWriter;
use \PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\Element\AbstractContainer;

class ExportReportPengawasanRegulerHawasbid
{
    private $filename;
    private $templateName;
    private $sectorName;
    private $template_path = "public/report/template";
    private $pth_to_save = "public/report/export";
    private $kesesuaian ;
    private $temuan ;

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

    function getFileTemplate(){
        return $this->template_path."/".$this->templateName;
    }

    public function exportWord(){
        if(!Storage::exists($this->getFileTemplate()))
            throw new \Exception("Template report pengawasan reguler ".$this->sectorName." Tidak ada. Harap hubungi admin", 400);

        $templateProcessor = new TemplateProcessor(public_path(Storage::url($this->getFileTemplate())));

        $phpword = new PhpWord();

        $section_kesesuaian = $phpword->addSection();
        $section_temuan = $phpword->addSection();
        $view_kesesuaian = $this->clearNonHtmlTag(view("template-word.lr-kesesuaian",[
            'kesesuaian'    => $this->kesesuaian
        ])->render());
        $view_temuan = $this->clearNonHtmlTag(view("template-word.lr-temuan",[
            'temuan'    => $this->temuan])->render());



//        dd($view_temuan);
        ErpHtml::addHtml($section_kesesuaian, $view_kesesuaian, true, false);
        ErpHtml::addHtml($section_temuan, $view_temuan, true, false);

        $templateProcessor->cloneBlock("kesesuaian", count($section_kesesuaian->getElements()), true, true);

        foreach ($section_kesesuaian->getElements() as $index=>$el){
            $search_block = "kesesuaian_item#".($index+1);
            if ($el == null)
                $templateProcessor->deleteBlock($search_block);
            else $templateProcessor->setComplexBlock($search_block, $el);
        }

        $templateProcessor->cloneBlock("temuan", count($section_temuan->getElements()), true, true);
//        dd($section_temuan->getElement(0)->getDocPart());
        foreach ($section_temuan->getElements() as $index=>$el){
            $search_block = "temuan_item#".($index+1);
            if ($el == null)
                $templateProcessor->deleteBlock($search_block);
            else $templateProcessor->setComplexBlock($search_block, $el);
        }

        $pth_file_export = $this->pth_to_save."/"."pr_hawasbid_".$this->sectorName."_".time().'.docx';
        $pathToSave = public_path(Storage::url($pth_file_export));
        $templateProcessor->saveAs($pathToSave);
        return $pth_file_export;
    }

    function clearNonHtmlTag($htmlCode){
        $clear = preg_replace("/[\n\r\t]/","",$htmlCode);

        return preg_replace("[\s+]"," ",$clear);
    }
}