<?php

namespace App\Report;
use DOMAttr;
use DOMDocument;
use DOMNode;
use DOMXPath;
use App\Helpers\CostumHelpers;
use App\Helpers\ErpHtml;
use App\Helpers\VariableHelper;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Types\Boolean;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Html;
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
    private $numId = 26;

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
        $this->setBlockKesesuaian($templateProcessor);
        $this->setBlockTemuan($phpword,$templateProcessor);

        $this->setOtherBlockProperty($templateProcessor);
        $pth_file_export = $this->pth_to_save."/"."pr_hawasbid_".$this->sectorName."_".time().'.docx';
        $pathToSave = public_path(Storage::url($pth_file_export));
        $templateProcessor->saveAs($pathToSave);
        return $pth_file_export;
    }
    function setOtherBlockProperty($templateProcessor){
//        set other property
        $tgl_rapat = CostumHelpers::getDateDMY($this->tanggal_rapat);
        $hari_tanggal_rapat = CostumHelpers::getDateDMY($this->tanggal_rapat, true);
        $templateProcessor->setValue("periode",$this->periode);
        $templateProcessor->setValue("tanggal_rapat",$tgl_rapat);
        $templateProcessor->setValue("hari_tanggal_rapat",$hari_tanggal_rapat);
    }

    function setBlockTemuan(PhpWord $phpword,TemplateProcessor $templateProcessor){
        $templateProcessor->cloneBlock("temuan",$this->temuan->count(), true, true);
        $index_temuan = 1;
        $kesimpulan = array();
        $saran = array();
        foreach ($this->temuan as $item_temuan){
            $lingkup_temuan_pr = "lingkup_temuan_pengawasan_regular#".$index_temuan;
            $templateProcessor->setValue("lingkup_temuan#".$index_temuan,$item_temuan->nama);
            $templateProcessor->cloneBlock($lingkup_temuan_pr,$item_temuan->pengawasan_regular->count(), true, true);
            $no_pr = 0;
            foreach ($item_temuan->pengawasan_regular as $row_pr){
                $no_pr += 1;
                $tag_block = "#".$index_temuan."#".$no_pr;

                $templateProcessor->setValue("title_temuan".$tag_block,strip_tags($row_pr->title));
                $this->writeNodeToBlock($templateProcessor, VariableHelper::getNodeOfHtml($row_pr->temuan),
                    "temuan_kondisi".$tag_block);
                $this->writeNodeToBlock($templateProcessor, VariableHelper::getNodeOfHtml($row_pr->kriteria),
                    "temuan_kriteria".$tag_block);
                $this->writeNodeToBlock($templateProcessor, VariableHelper::getNodeOfHtml($row_pr->sebab),
                    "temuan_sebab".$tag_block);
                $this->writeNodeToBlock($templateProcessor, VariableHelper::getNodeOfHtml($row_pr->akibat),
                    "temuan_akibat".$tag_block);
                $this->writeNodeToBlock($templateProcessor, VariableHelper::getNodeOfHtml($row_pr->rekomendasi),
                    "temuan_rekomendasi".$tag_block);

                $this->setTanggalRapat($row_pr->tanggal_rapat_hawasbid);

                array_push($kesimpulan, $row_pr->temuan);
                array_push($saran, $row_pr->rekomendasi);
            }
            $index_temuan += 1;
        }
        $templateProcessor->cloneBlock("kesimpulan_block",count($kesimpulan), true,true);
        $templateProcessor->cloneBlock("saran_block",count($saran), true,true);

        for($index = 1; $index <= count($kesimpulan); $index++){
            $this->writeNodeToBlock($templateProcessor, VariableHelper::getNodeOfHtml($kesimpulan[($index - 1)]),
                "kesimpulan#".$index, true);
        }
        for($index = 1; $index <= count($saran); $index++){
            $this->writeNodeToBlock($templateProcessor, VariableHelper::getNodeOfHtml($saran[($index - 1)]),
                "saran#".$index, true);
        }
    }

    function writeNodeToBlock(TemplateProcessor $templateProcessor, array $content, $node, $startFromList = false){
        $contentXml = $this->getContentXml($content, $startFromList);
        $templateProcessor->replaceXmlBlock($node, $contentXml);
    }
    function getContentXml(array $content, $startFromList = false){
        $contentXml = "";
        $numId = $this->numId;
        foreach ($content as $row){
            $rowNodeName = $row['nodeName'];
            $rowContent = $row['content'];
            if(in_array($rowNodeName, ["ol","ul"]))
                $contentXml .= $this->getContentXml($rowContent);
            else if($rowNodeName == 'li')
                $contentXml.= $this->addListXml($rowContent, $numId);
            else if($rowNodeName == "p"){
                if($startFromList){
                    $contentXml.= $this->addListXml($rowContent,$numId,1);
                }else{
                    $contentXml .= $this->addParagraph($rowContent);
                }
            }
        }
        return $contentXml;
    }


    function addListXml(String $text,$numId = 25,$lvl = 3){
        return '<w:p>
                    <w:pPr>
                        <w:pStyle w:val="ListParagraph"/>
                        <w:widowControl w:val="0"/>
                        <w:numPr>
                            <w:start w:val="1"/>
                            <w:ilvl w:val="'.$lvl.'"/>
                            <w:numId w:val="'.$numId.'"/>
                        </w:numPr>
                        <w:autoSpaceDE w:val="0"/>
                        <w:autoSpaceDN w:val="0"/>
                        <w:adjustRightInd w:val="0"/>
                        <w:spacing w:after="0" w:line="360" />
                        <w:jc w:val="both"/>
                        <w:rPr>
                            <w:rFonts w:ascii="Arial" w:hAnsi="Arial" w:cs="Arial"/>
                            <w:bCs/>
                            <w:color w:val="000000"/>
                            <w:sz w:val="24"/>
                            <w:szCs w:val="24"/>
                        </w:rPr>
                    </w:pPr>
                    <w:r>
                        <w:rPr>
                            <w:rFonts w:ascii="Arial" w:hAnsi="Arial" w:cs="Arial"/>
                            <w:bCs/>
                            <w:color w:val="000000"/>
                            <w:sz w:val="24"/>
                            <w:szCs w:val="24"/>
                            <w:lang w:val="id-ID"/>
                        </w:rPr>
                        <w:t>'.$text.'</w:t>
                    </w:r>
                </w:p>';
    }

    function addParagraph(String $text){
        return '<w:p>
                    <w:pPr>
                        <w:pStyle w:val="ListParagraph"/>
                        <w:widowControl w:val="0"/>
                        <w:autoSpaceDE w:val="0"/>
                        <w:autoSpaceDN w:val="0"/>
                        <w:adjustRightInd w:val="0"/>
                        <w:spacing w:after="0" />
                        <w:jc w:val="both"/>
                        <w:rPr>
                            <w:rFonts w:ascii="Arial" w:hAnsi="Arial" w:cs="Arial"/>
                            <w:bCs/>
                            <w:color w:val="000000"/>
                            <w:sz w:val="24"/>
                            <w:szCs w:val="24"/>
                        </w:rPr>
                    </w:pPr>
                    <w:r>
                        <w:rPr>
                            <w:rFonts w:ascii="Arial" w:hAnsi="Arial" w:cs="Arial"/>
                            <w:color w:val="000000"/>
                            <w:sz w:val="24"/>
                            <w:szCs w:val="24"/>
                            <w:lang w:val="id-ID"/>
                        </w:rPr>
                        <w:t>'.$text.'</w:t>
                    </w:r>
                </w:p>';
    }
    function writeChildNodeToBlock(TemplateProcessor $templateProcessor, $content, $node_l){
        $index_node = 1;
        foreach ($content as $item){
            $node_l_child = $node_l."#".$index_node;
            $templateProcessor->setValue($node_l_child, $item["content"]);
            $index_node += 1;
        }
    }


    function setBlockKesesuaian($templateProcessor){
        $templateProcessor->cloneBlock("kesesuaian",$this->kesesuaian->count(), true, true);
        $index_kesesuaian = 1;
        foreach ($this->kesesuaian as $lingkup_bidang){
            $lingkup_temuan_pr = "lingkup_ kesesuaian_pengawasan_regular#".$index_kesesuaian;
            $templateProcessor->setValue("lingkup_kesesuaian#".$index_kesesuaian,$lingkup_bidang->nama);
            $templateProcessor->cloneBlock($lingkup_temuan_pr,$lingkup_bidang->kesesuaian_pengawasan_regular->count(), true, true);
            $no_pr = 0;
            foreach ($lingkup_bidang->kesesuaian_pengawasan_regular as $row_kesesuaian){
                $no_pr += 1;
                $templateProcessor->setValue("kesesuaian_item#".$index_kesesuaian."#".$no_pr,strip_tags($row_kesesuaian->uraian));
            }
            $index_kesesuaian += 1;
        }
    }

    function clearNonHtmlTag($htmlCode){
        $clear = preg_replace("/[\n\r\t]/","",$htmlCode);

        return preg_replace("[\s+]"," ",$clear);
    }
}