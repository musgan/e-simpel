<?php

namespace App\Report;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
class ExportExcelTindakLanjutPengawasanRegularReport
{
    private $path_save_name = "tindaklanjut_pr";
    public $path_save_location = "storage/report/export";

    private $periode = "";
    private $data;
    private $no = 0;
    public function setPathSaveName($path_save_name){
        $this->path_save_name = $path_save_name;
    }

    public function getPathSaveLocation(){
        return $this->path_save_location;
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

                $this->setWidthColumn($sheet);
                $this->setStyleTable($sheet, $rowColumnHeader, $last_row_table);
            });

        })->save('xlsx', $this->path_save_location);
    }
    public function setWidthColumn($sheet){
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
    function setHeader($sheet){
        $sheet->cell('A1', function($cell) {
            $cell->setValue('TINDAK LANJUT HASIL PENGAWASAN');
        });
        $sheet->cell('A2', function($cell) {
            $cell->setValue('HAKIM PENGAWAS BIDANG PENGADILAN NEGERI KENDARI');
        });
        $sheet->cell('A3', function($cell) {
            $cell->setValue('BULAN '.$this->periode);
        });
        $sheet->mergeCells('A1:I1');
        $sheet->mergeCells('A2:I2');
        $sheet->mergeCells('A3:I3');
        $sheet->cell('A1:I3', function ($cells){
            $cells->setAlignment('center');
            $cells->setFontWeight('bold');
        });
    }
    function setColumnHeader($sheet){
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

    function setLingkupPengawasan($sheet, $row){
        foreach ($this->data as $row_lingkup_pengawasan){
            $row += 1;
            $sheet->cell('B'.$row, function ($cell) use($row_lingkup_pengawasan){
                $cell->setValue($row_lingkup_pengawasan->nama);
            });
            $row = $this->setItemLingkupPengawasan($sheet, $row, $row_lingkup_pengawasan->items);
        }
        return $row;
    }
    function setItemLingkupPengawasan($sheet, $row, $data_list_lingkup_pengawasan){
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
    function setTemuan($sheet, $row, $data_list_temuan){
        $is_add = false;
        foreach($data_list_temuan as $row_item){
            $this->no += 1;
            $sheet->cell('A'.$row, function ($cell){
                $cell->setValue($this->no);
            });
            $sheet->cell('C'.$row, function ($cell) use($row_item){
                $cell->setValue(strip_tags($row_item->temuan));
            });
            $sheet->cell('D'.$row, function ($cell) use($row_item){
                $cell->setValue(strip_tags($row_item->rekomendasi));
            });
            $sheet->cell('I'.$row, function ($cell) use($row_item){
                $cell->setValue(strip_tags($row_item->uraian));
            });
            if($row_item->status_pengawasan_regular_id == "APPROVED")
                $sheet->cell('E'.$row, function ($cell){
                    $cell->setValue("√");
                });
            else if($row_item->status_pengawasan_regular_id == "WAITINGAPPROVALFROMADMIN")
                $sheet->cell('F'.$row, function ($cell){
                    $cell->setValue("√");
                });
            else if($row_item->status_pengawasan_regular_id == "SUBMITEDBYHAWASBID")
                $sheet->cell('G'.$row, function ($cell){
                    $cell->setValue("√");
                });
            else if($row_item->status_pengawasan_regular_id == "NOTRESOLVED")
                $sheet->cell('H'.$row, function ($cell){
                    $cell->setValue("√");
                });

            $row += 1;
            $is_add = true;
        }
        if ($is_add) $row-=1;
        return $row;
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
    }
}