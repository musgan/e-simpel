<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use \PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Html;
use \PhpOffice\PhpWord\TemplateProcessor;

class ExportLaporanPengawasanRegular extends Controller
{
    //
    public function export()
    {
        $phpWord = new PhpWord();

        $section = $phpWord->addSection();


        $description = "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";


//        $section->addImage("http://itsolutionstuff.com/frontTheme/images/logo.png");
        $section->addText($description);

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        try {
            $objWriter->save(storage_path('helloWorld.docx'));
        } catch (Exception $e) {
        }


        return response()->download(storage_path('helloWorld.docx'));
    }

    public function export2(){
        $base_path = "public/report/word";
        $template_path = $base_path."/template-laporan-pengawasan-regular.docx";

        $phpword = new PhpWord();
        $section = $phpword->addSection();
        Html::addHtml($section, "<ol><li>MUSGAN</li></ol>");
        $templateProcessor = new TemplateProcessor(public_path(Storage::url($template_path)));
        $templateProcessor->setComplexBlock('firstname', $section->getElement(0));
        $templateProcessor->setValue('lastname', 'Usgan');
        $pathToSave = public_path(Storage::url($base_path."/".date('dmyHis').'.docx'));
        $templateProcessor->saveAs($pathToSave);



        return "x";
    }
}
