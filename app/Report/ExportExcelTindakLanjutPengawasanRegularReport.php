<?php

namespace App\Report;
use App\Helpers\CostumHelpers;
use App\Helpers\VariableHelper;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Writers\CellWriter;

class ExportExcelTindakLanjutPengawasanRegularReport
{
    private $path_save_name = "tindaklanjut_pr";
    public $path_save_location = "storage/report/export";

    private $periode = "";
    private $data;
    private $tgl_tindak_lanjut;
    private $nama_penanggung_jawab;
    private $nip_penanggung_jawab;
    private $jabatan_penanggung_jawab;

    private $no = 0;
    private $listIdTindakLanjut = [];

    public function setTglTindakLanjut($tgl_tindak_lanjut){
        if($tgl_tindak_lanjut)
            $this->tgl_tindak_lanjut = $tgl_tindak_lanjut;
        else  $this->tgl_tindak_lanjut(date('Y-m-d'));
    }
    public function setNamaPenganggungJawab($nama_penanggung_jawab){
        $this->nama_penanggung_jawab = $nama_penanggung_jawab;
    }
    public function setNipPenganggungJawab($nip_penanggung_jawab){
        $this->nip_penanggung_jawab = $nip_penanggung_jawab;
    }

    public function setJabatanPenganggungJawab($jabatan_penanggung_jawab){
        $this->jabatan_penanggung_jawab = $jabatan_penanggung_jawab;
    }

    public function setPathSaveName($path_save_name){
        $this->path_save_name = $path_save_name;
    }

    public function getPathSaveLocation(){
        return $this->path_save_location;
    }

    public function  getListIdTindakLanjut(){
        return $this->listIdTindakLanjut;
    }

    public function setPeriode($periode){
        $this->periode = $periode;
    }

    public function setData($data){
        $this->data = $data;
    }

    public function run(){

        Excel::create($this->path_save_name, function($excel) {
            $excel->sheet('tindak lanjut', function($sheet) {
                $this->setHeader($sheet);
                $rowColumnHeader = $this->setColumnHeader($sheet);
                $last_row_table = $this->setLingkupPengawasan($sheet, $rowColumnHeader);
                $this->setFooter($sheet, $last_row_table);
                $this->setWidthColumn($sheet);
                $this->setStyleTable($sheet, $rowColumnHeader, $last_row_table);
            });
        })->save('xlsx', $this->path_save_location);
    }
    public function setWidthColumn(LaravelExcelWorksheet $sheet){
        $sheet->setWidth(array(
            'A' =>  7,
            'B' =>  33,
            'C' => 35,
            'D' => 35,
            'E' => 13,
            'F' => 13,
            'G' => 13,
            'H' => 13,
            'I' => 23,
        ));
    }
    function setHeader(LaravelExcelWorksheet $sheet){
        $sheet->cell('A1', function($cell) {
            $cell->setValue('TINDAK LANJUT HASIL PENGAWASAN');
        });
        $sheet->cell('A2', function($cell) {
            $cell->setValue('HAKIM PENGAWAS BIDANG PENGADILAN NEGERI KENDARI');
        });
        $sheet->cell('A3', function($cell) {
            $cell->setValue('BULAN '.strtoupper($this->periode));
        });
        $sheet->mergeCells('A1:I1');
        $sheet->mergeCells('A2:I2');
        $sheet->mergeCells('A3:I3');
        $sheet->cell('A1:I3', function ($cells){
            $cells->setAlignment('center');
            $cells->setFontWeight('bold');
        });
    }
    function setColumnHeader(LaravelExcelWorksheet $sheet){
        $row = 6;
        $add_row1 = $row+1;
        $sheet->cell('A'.$row, function ($cell){
            $cell->setValue('NO');
        });
        $sheet->cell('B'.$row, function ($cell){
            $cell->setValue('BIDANG TUGAS');
        });
        $sheet->cell('C'.$row, function ($cell){
            $cell->setValue('TEMUAN');
        });
        $sheet->cell('D'.$row, function ($cell){
            $cell->setValue('REKOMENDASI');
        });
        $sheet->cell('E'.$row, function ($cell){
            $cell->setValue('TINDAK LANJUT');
        });
        $sheet->cell('E'.$add_row1, function ($cell){
            $cell->setValue('Telah Ditindaklanjuti');
            $cell->setFontSize(9);
        });
        $sheet->cell('F'.$add_row1, function ($cell){
            $cell->setValue('Dalam Proses');
            $cell->setFontSize(9);
        });
        $sheet->cell('G'.$add_row1, function ($cell){
            $cell->setValue('Belum');
            $cell->setFontSize(9);
        });
        $sheet->cell('H'.$add_row1, function ($cell){
            $cell->setValue('Tidak dapat ditindaklanjuti');
            $cell->setFontSize(9);
        });
        $sheet->cell('I'.$row, function ($cell){
            $cell->setValue('Keterangan');
        });
        $sheet->mergeCells('A'.$row.':A'.$add_row1);
        $sheet->mergeCells('B'.$row.':B'.$add_row1);
        $sheet->mergeCells('C'.$row.':C'.$add_row1);
        $sheet->mergeCells('D'.$row.':D'.$add_row1);
        $sheet->mergeCells('E'.$row.':H'.$row);
        $sheet->mergeCells('I'.$row.':I'.$add_row1);
        $sheet->cell('A'.$row.':I'.$add_row1, function ($cells){
            $cells->setAlignment('center');
            $cells->setValignment('center');
            $cells->setFontWeight('bold');
        });
        $sheet->getStyle('A'.$row.':I'.$add_row1)->getAlignment()->setWrapText(true);

        return $add_row1;
    }

    function setLingkupPengawasan(LaravelExcelWorksheet $sheet, $row){
        foreach ($this->data as $row_lingkup_pengawasan){
            $row += 1;
            $sheet->mergeCells('B'.$row.':I'.$row);
            $sheet->cell('B'.$row, function ($cell) use($row_lingkup_pengawasan){
                $cell->setValue(strtoupper($row_lingkup_pengawasan->nama));
                $cell->setFontWeight('bold');
            });
            $row = $this->setItemLingkupPengawasan($sheet, $row, $row_lingkup_pengawasan->items);
        }
        return $row;
    }
    function setItemLingkupPengawasan(LaravelExcelWorksheet $sheet, $row, $data_list_lingkup_pengawasan){
        foreach ($data_list_lingkup_pengawasan as $row_item){
            $row += 1;
            $barisTemuanAwal = $row;
            $row = $this->setTemuan($sheet, $row, $row_item->pengawasan_regular);
            $sheet->cell('B'.$barisTemuanAwal, function ($cell) use($row_item){
                $cell->setValue($row_item->nama);
            });
        }
        return $row;
    }
    function setTemuan(LaravelExcelWorksheet $sheet, $row, $data_list_temuan){
        $is_add = false;
        foreach($data_list_temuan as $row_item){
            array_push($this->listIdTindakLanjut, $row_item->id);
            $this->no += 1;
            $sheet->cell('A'.$row, function ($cell){
                $cell->setValue($this->no);
            });
            $sheet->cell('C'.$row, function ($cell) use($row_item){
                if(!VariableHelper::isNullOrEmptyString($row_item->temuan)) {
                    $content = VariableHelper::getNodeOfHtml($row_item->temuan);
                    $cell->setValue(VariableHelper::getPlainTextOfHtml($content));
                }
            });
            $sheet->cell('D'.$row, function ($cell) use($row_item){
                if(!VariableHelper::isNullOrEmptyString($row_item->rekomendasi)) {
                    $content = VariableHelper::getNodeOfHtml($row_item->rekomendasi);
                    $cell->setValue(VariableHelper::getPlainTextOfHtml($content));
                }
            });
            $sheet->cell('I'.$row, function ($cell) use($row_item){
                if(!VariableHelper::isNullOrEmptyString($row_item->uraian)) {
                    $content = VariableHelper::getNodeOfHtml($row_item->uraian);
                    $cell->setValue(VariableHelper::getPlainTextOfHtml($content));
                }
            });
            if($row_item->status_pengawasan_regular_id == "APPROVED")
                $sheet->cell('E'.$row, function ($cell){
                    $cell->setValue("√");
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                });
            else if($row_item->status_pengawasan_regular_id == "WAITINGAPPROVALFROMADMIN")
                $sheet->cell('F'.$row, function ($cell){
                    $cell->setValue("√");
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                });
            else if(in_array($row_item->status_pengawasan_regular_id, ["SUBMITEDBYHAWASBID","NOTRESOLVED"]))
                $sheet->cell('G'.$row, function ($cell){
                    $cell->setValue("√");
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                });
            else if($row_item->status_pengawasan_regular_id == "NOTACTIONABLE")
                $sheet->cell('H'.$row, function ($cell){
                    $cell->setValue("√");
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                });

            $row += 1;
            $is_add = true;
        }
        if ($is_add) $row-=1;
        return $row;
    }
    function setFooter(LaravelExcelWorksheet $sheet, $row){
        $row+= 2;
        $sheet->cell("H".$row, function (CellWriter $cell){
            $cell->setValue("Kendari, ".CostumHelpers::getDateDMY($this->tgl_tindak_lanjut));
        });
        $row+= 2;
        $sheet->mergeCells("F".$row.":G".$row);
        $sheet->cell("F".$row, function (CellWriter $cell){
            $cell->setValue("Mengetahui,");
            $cell->setAlignment("center");
        });
        $row+= 2;
        $sheet->mergeCells("E".$row.":I".$row);
        $sheet->cell("E".$row, function (CellWriter $cell){
            $cell->setValue($this->jabatan_penanggung_jawab);
            $cell->setFontWeight(true);
            $cell->setAlignment("center");
        });
        $row+= 5;
        $sheet->mergeCells("E".$row.":I".$row);
        $sheet->cell("E".$row, function (CellWriter $cell){
            $cell->setValue($this->nama_penanggung_jawab);
            $cell->setFontWeight(true);
            $cell->setAlignment("center");
        });

    }
    function setStyleTable($sheet, $start_row, $end_row){
        $allColumnsTable = 'A'.($start_row-1).':I'.$end_row;
        $sheet->getStyle($allColumnsTable)->applyFromArray(
            array(
                'borders' => array(
                    'allborders' => array(
                        'style' => \PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            )
        );
        $sheet->getStyle('A'.$start_row.':I'.$end_row)->getAlignment()->setWrapText(true);
        $sheet->cell('A'.$start_row.':D'.$end_row, function ($cell){
            $cell->setAlignment('left');
            $cell->setValignment('top');
        });
        $sheet->cell('I'.$start_row.':I'.$end_row, function ($cell){
            $cell->setAlignment('left');
            $cell->setValignment('top');
        });
        $sheet->cell('A'.$start_row.':A'.$end_row, function ($cell){
            $cell->setAlignment('center');
            $cell->setValignment('top');
        });
    }
}