<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Sector;
use DB;
use Excel;
use Illuminate\Support\Facades\Auth;
use App\User;
use PHPExcel_Worksheet_Drawing;
use PDF;
use App\SettingPeriodHawasbid;

class ReportHawasbid extends Controller
{
    //
    public function __construct()
    {
    	date_default_timezone_set('Asia/Jakarta');
        $this->sectors = Sector::select('id','nama','alias','category')->orderBy('id','ASC')->get();
        $this->bulan = [
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

    public function index(){
    	$user = Auth::user();

    	$op_sector = [];
    	// if($user->user_level_id == 1 ||  $user->user_level_id == 10){
		$op_sector = Sector::orderBy('sectors.category','ASC')
			->orderBy('sectors.id','ASC')
			->select(DB::RAW('CONCAT(category," - ",nama) as nama'),"sectors.id as id");
    	if($user->user_level_id == 10 || $user->user_level_id == 4 || $user->user_level_id == 5 || $user->user_level_id == 6 || $user->user_level_id == 7){
    		$op_sector = $op_sector->join('user_level_groups','sector_id','=','sectors.id')
    			->where('user_id',$user->id);
    	}
    	$op_sector = $op_sector->pluck('nama','id');
    	// }

    	$jenis_laporan = [
    		1 => "Laporan Bidang",
    	 	2 =>"Laporan Keseluruhan"
    	];

    	
    	$send = [
            'menu' => 'cetak_laporan',
            'title' => '-',
            'sub_menu'	=> 'hawasbid',
            'menu_sectors'   => $this->sectors,
            'sectors'	=> $op_sector,
            'periode_bulan'	=> $this->bulan,
            'jenis_laporan'	=> $jenis_laporan
        ];
        return view('admin.laporan.hawasbid.index',$send);
    }

    public function print_laporan(Request $request){
    	$this->validate($request,[
    		'nama_file'	=>'required',
    		'periode_bulan'	=> 'required',
    		'periode_tahun'	=> 'required',
    		'jenis_laporan'	=> 'required',
    		'jenis_file'	=> 'required'
    	]);

    	if($request->jenis_file == 1){
	    	if($request->jenis_laporan == 1){
	    		$this->validate($request,[
	    			'sector_id'	=> 'required',
	    		]);
	    		$this->laporan_bidang($request);
	    	}else if($request->jenis_laporan == 2){
	    		$this->laporan_keseluruhan($request);
	    	}
	    }else if($request->jenis_file == 2){
	    	if($request->jenis_laporan == 1){
	    		$this->validate($request,[
	    			'sector_id'	=> 'required',
	    		]);
	    		return $this->laporan_bidang_pdf($request);
	    	}else if ($request->jenis_laporan == 2){
	    		return $this->laporan_keseluruhan_pdf($request);	    		
	    	}
	    }
    }

    private function laporan_bidang_pdf($request){
    	$bidang = array();
    	$user = Auth::user();
    	foreach ($request->sector_id as $vsector) {
	    	$info_sector = Sector::where('sectors.id',$vsector);
	    	
	    	// if($user->id >= 10){
    		// 	$info_sector = 	$info_sector->where('user_id',$user->id)
    		// 					->join('user_level_groups','sector_id','=','sectors.id');
    		// }
    		
	    	$info_sector = $info_sector->first();

	    	$indikator = DB::table('indikator_sectors')
			        	->join('secretariats','secretariats.id','=','secretariat_id')
			        	->join('sectors','sectors.id','indikator_sectors.sector_id')
			        	->select('indikator_sectors.id','indikator','evidence','uraian','secretariats.sector_id'
			        		,'secretariat_id','sectors.nama','status_tindakan')
			        	->where('periode_bulan',$request->periode_bulan)
			        	->where('periode_tahun',$request->periode_tahun)
			        	// ->where('secretariats.sector_id',$vsector)
			        	->where(function($q) use($vsector){
			        		$q->where('secretariats.sector_id',$vsector)
			        			->orWhere(function($qq) use($vsector){
			        				$qq->where('indikator_sectors.sector_id',$vsector)
			        				->whereRaw('indikator_sectors.sector_id != secretariats.sector_id');
			        			});
			        	})

			        	->orderBY('indikator','ASC');
			
			$all_sector = DB::table('sectors')
							->select(DB::raw('CONCAT("pengawas-bidang/",LOWER(category),"/",LOWER(alias),"/dokumentasi_rapat") as path'),'id')
							->pluck('path','id');
			
			$indikator = $indikator->get();
			array_push($bidang, array('sector'	=> $info_sector, 'indikator'=>$indikator));
	    }


	    $periode = "Periode: ".\CostumHelper::getNameMonth($request->periode_bulan)." ".$request->periode_tahun;

	    $send = [
	    	'indikator_sectors'	=> 	$bidang,
	    	'periode'	=> $periode,
	    	'all_sector' => $all_sector,
	    	'periode_bulan'	=> $request->periode_bulan,
	    	'periode_tahun'	=> $request->periode_tahun,
	    	'request' => $request
	    ];

	    ini_set("memory_limit", "999M");
		ini_set("max_execution_time", 999);
    	$pdf = PDF::loadview('admin.laporan.hawasbid.laporan_bidang_pdf', $send);
    	// return $pdf->stream('xxx.pdf');
    	return $pdf->download($request->nama_file.'.pdf');
    }

    private function laporan_keseluruhan_pdf($request){

    	$send = [
	    	'lp_keseluruhan'	=> 	$this->sheet_laporan_keseluruhan_pdf($request),
	    	'lp_temuan'			=> 	$this->sheet_laporan_temuan_pdf($request),
	    	'lp_tindak_lanjut'	=> $this->sheet_laporan_tindak_lanjut_pdf($request),
	    	'kpn'	=> User::where('user_level_id',2)->first(),
	    	'wkpn'	=> User::where('user_level_id',3)->first(),
	    	'sektor'	=> DB::table('sectors')->pluck('nama','id')->toArray(),
	    	'request' => $request
	    ];

	    
	    // $html2pdf = new HTML2PDF('P','A4','en', false, 'ISO-8859-15',array(30, 0, 20, 0));

	    // $d = compact($send);
	    // dd($send);
    	$pdf = \PDF::loadView('admin.laporan.hawasbid.laporan_keseluruhan_pdf', $send);
    	// return view('admin.laporan.hawasbid.laporan_keseluruhan_pdf',$send);
		ini_set("memory_limit", "999M");
		ini_set("max_execution_time", 999);
		// dd($pdf);
		return $pdf->stream($request->nama_file.'.pdf');
    }

    private function sheet_laporan_temuan_pdf($request){
    	$year = date('Y');
    	$month = date('m');
    	$date = date('d');

    	$indikator = DB::table('indikator_sectors')
        	->join('secretariats','secretariats.id','=','secretariat_id')
        	->join('sectors','sectors.id','=','indikator_sectors.sector_id')
        	->select('secretariats.id','sectors.nama','indikator','evidence','uraian','secretariats.sector_id','status_tindakan','periode_bulan','periode_tahun')
        	->where('evidence',0)
        	->whereNotNull('secretariats.sector_id')
        	->orderBy('periode_tahun','DESC')
        	->orderBy('periode_bulan','DESC')
	        ->orderBy('sectors.id','ASC')
        	->orderBy('indikator','ASC');

        $m = $request->periode_bulan;
		$y = $request->periode_tahun;

		$treshold_d = $y."-".$m."-01";
		// $treshold_d =  date('Y-m-d',strtotime($treshold_date." -1 month"));
		$indikator = $indikator->whereDate(DB::raw('CONCAT(periode_tahun,"-",periode_bulan,"-01")'),"<",$treshold_d);
        
        $indikator = $indikator->get();
	    $send = [
	    	'indikator'	=> 	$indikator
	    ];


	    return $send;
    }


    private function sheet_laporan_tindak_lanjut_pdf($request){
    	$year = date('Y');
    	$month = date('m');
    	$date = date('d');

        $indikator = [];
    	$indikator = DB::table('indikator_sectors')
    	->join('secretariats','secretariats.id','=','secretariat_id')
    	->join('sectors','sectors.id','=','indikator_sectors.sector_id')
    	->select('secretariats.id','sectors.nama','indikator','evidence','uraian','secretariats.sector_id','status_tindakan','periode_bulan','periode_tahun')
    	->where('evidence',0)
    	->whereNotNull('secretariats.sector_id')
    	->orderBy('periode_tahun','DESC')
    	->orderBy('periode_bulan','DESC')
	    ->orderBy('sectors.id','ASC')
    	->orderBy('indikator','ASC');

    	$indikator = $indikator->where('periode_bulan',$request->periode_bulan)
    		->where('periode_tahun', $request->periode_tahun);

    	$indikator = $indikator->get();

    

	    $send = [
	    	'indikator'	=> 	$indikator
	    ];

	    return $send;

    }



    private function sheet_laporan_keseluruhan_pdf($request){
    	$indikator = DB::table('indikator_sectors')
	        	->join('secretariats','secretariats.id','=','secretariat_id')
	        	->join('sectors','sectors.id','=','indikator_sectors.sector_id')
	        	->select('secretariats.id','sectors.nama','indikator','evidence','uraian','secretariats.sector_id','status_tindakan')
	        	->where('periode_bulan',$request->periode_bulan)
	        	->where('periode_tahun',$request->periode_tahun)
	        	->whereNotNull('secretariats.sector_id')
	        	->orderBy('periode_tahun','DESC')
	        	->orderBy('periode_bulan','DESC')
	        	->orderBy('sectors.id','ASC')
	        	->orderBy('indikator','ASC')->get();

	    $periode = "Periode: ".$this->getNameMonth($request->periode_bulan)." ".$request->periode_tahun;

	   
	    $send = [
	    	'indikator'	=> 	$indikator,
	    	'periode'	=> $periode
	    ];

	    return $send;
    }


    private function laporan_keseluruhan($request){
    	ini_set("memory_limit", "999M");
		ini_set("max_execution_time", 999);

    	Excel::create($request->nama_file, function($excel) use($request) {
    		$this->sheet_laporan_keseluruhan($excel, $request);
    		$this->sheet_laporan_tindak_lanjut($excel, $request);
    		$this->sheet_laporan_temuan($excel, $request);
    		
		})
		// ->export('pdf');
		->export('xlsx');
    }

    private function sheet_laporan_temuan($excel, $request){
    	
    	$excel->sheet("Laporan Temuan", function($sheet) use($request){
	        // Sheet manipulation

	        
			$sheet->setWidth(array(
			    'A'     =>  5,
			    'B'     =>  15,
			    'C'     =>  15,
			    'D'     =>  40,
			    'E'     =>  6.05375,
			    'F'     =>  6.05375,
			    'G'     =>  6.05375,
			    'H'     =>  6.05375,
			    'I'     =>  6.05375,
			    'J'     =>  6.05375,
			    'K'     =>  6.05375,
			    'L'     =>  6.05375,
			    'M'		=> 10,
			    'N'		=> 10,
			));

			$start_row = 3 + $this->letter_head($sheet, "A", "N", 1);

			$sheet->mergeCells('A'.$start_row.':N'.$start_row);
			$sheet->cell('A'.$start_row, function($cell){
				$cell->setValue("LAPORAN HASIL TEMUAN PENGAWASAN BIDANG");
			    $cell->setFontSize(12);
			    $cell->setAlignment('center');
			    $cell->setValignment('center');
			    $cell->setFontWeight('bold');
			});

			$start_row  += 1;
			$sheet->mergeCells('A'.$start_row.':N'.$start_row);
			$sheet->cell('A'.$start_row, function($cell){
				$cell->setValue("PENGADILAN NEGERI /PHI /TIPIKOR KENDARI KELAS IA");
			    $cell->setFontSize(12);
			    $cell->setAlignment('center');
			    $cell->setValignment('center');
			    $cell->setFontWeight('bold');
			});

			

			$start_row += 3;
			$start_row_head_col = $start_row;
			$sheet->mergeCells('E'.$start_row.':L'.$start_row);
	        $sheet->row($start_row, array(
			     'No','Bidang','Periode','Indikator','uraian','','','','','','','','Tindak Lanjut','Evidence'
			));

			$sheet->cell('A'.$start_row.':N'.$start_row, function($cell) {
			    // manipulate the cell
			    $cell->setAlignment('center');
			    $cell->setValignment('center');
			    $cell->setFontWeight('bold');
			    $cell->setFontSize(12);
			});

			$m = $request->periode_bulan;
			$y = $request->periode_tahun;

			$treshold_d = $y."-".$m."-01";
			// $treshold_d =  date('Y-m-d',strtotime($treshold_date." -1 month"));

			$start_row +=1;
			$no = 1;
	        $indikator = DB::table('indikator_sectors')
	        	->join('secretariats','secretariats.id','=','secretariat_id')
	        	->join('sectors','sectors.id','=','indikator_sectors.sector_id')
	        	->select('secretariats.id','sectors.nama','indikator','evidence','uraian','secretariats.sector_id','secretariat_id','periode_tahun','periode_bulan','status_tindakan')
	        	->where('evidence',0)
	        	->whereDate(DB::raw('CONCAT(periode_tahun,"-",periode_bulan,"-01")'),"<",$treshold_d)
	        	->whereNotNull('secretariats.sector_id')
	        	->orderBy('periode_tahun','DESC')
	        	->orderBy('periode_bulan','DESC')
	        	->orderBy('sectors.id','ASC')
	        	->orderBy('indikator','ASC');

	        $indikator = $indikator->get();

	        $sectors = DB::table('sectors')->pluck('nama','id');
	        // dd($sectors[17]);
	        // dd($indikator[700]);

	        foreach ($indikator as $row_indikator) {
	        	# code...
	        	 

	        	$real_url = 'hawasbid_indikator/'.$row_indikator->id;

	        	$link = url('redev?url='.$real_url);

	        	$temuan = "ada";
	        	if($row_indikator->evidence == 0){
	        		$temuan = "-";
	        	}

	        	$status_tindakan = "-";
	        	if($row_indikator->status_tindakan == 1){
	        		$status_tindakan = "Tindak Lanjut";
	        	}
	        	
	        	$sheet->getCellByColumnAndRow(13,$start_row)->getHyperlink()->setUrl($link);

	        	
	        	$periode = $this->getNameMonth($row_indikator->periode_bulan)." ".$row_indikator->periode_tahun;

		        $sheet->row($start_row, array(
				     $no,"(".$sectors[$row_indikator->sector_id].")\n".$row_indikator->nama,$periode,$row_indikator->indikator,$row_indikator->uraian,"","","","","","","",$status_tindakan, $temuan,
				));

				$sheet->mergeCells('E'."$start_row".':L'.$start_row);
				// $sheet->mergeCells('L'."$start_row".':M'.$start_row);
				$start_row +=1;
				$no += 1;
	        }

	        $sheet->cells('M'.($start_row_head_col +1).':M'.$start_row, function($cells) {

			    // manipulate the cell
			    $cells->setAlignment('center');
			    $cells->setValignment('top');
			});
			$sheet->cells('A'.($start_row_head_col +1).':A'.$start_row, function($cells) {

			    // manipulate the cell
			    $cells->setAlignment('center');
			    $cells->setValignment('top');
			});
			$sheet->cells('B'.($start_row_head_col +1).':C'.$start_row, function($cells) {

			    // manipulate the cell
			    $cells->setAlignment('center');
			    $cells->setValignment('top');
			});
			$sheet->cells('N'.($start_row_head_col +1).':N'.$start_row, function($cells) {

			    // manipulate the cell
			    $cells->setAlignment('center');
			    $cells->setValignment('top');
			});
			$sheet->cells('D'.($start_row_head_col +1).':K'.$start_row, function($cells) {

			    // manipulate the cell
			    $cells->setAlignment('left');
			    $cells->setValignment('top');
			});

			$border_style= array('borders' => array('allborders' => array('style' =>'thin','color' => array('argb' => '766f6e'),)));

			$sheet->getStyle('A'.($start_row_head_col).':N'.($start_row-1))->applyFromArray($border_style);

	        $sheet->getStyle('A'.($start_row_head_col).':N'.$start_row)
	        	->getAlignment()->setWrapText(true);


	       $start_row += 1;
	       $sheet->cell('B'.$start_row, function($cell){
	       		$cell->setValue("Mengetahui");
	       		$cell->setFontSize(12);
	       });
	       $start_row += 1;
	       $sheet->cell('I'.$start_row, function($cell){
	       		$cell->setValue("Koordinator Pengawas Bidang");
	       		$cell->setFontSize(12);
	       });
	       $start_row += 2;
	       $sheet->cell('B'.$start_row, function($cell){
	       		$cell->setValue("Ketua Pengadilan Negeri /PHI /TIPIKOR Kendari Kelas IA");
	       		$cell->setFontSize(12);
	       });

	       $sheet->cell('I'.$start_row, function($cell){
	       		$cell->setValue("Wakil Ketua Pengadilan Negeri Kendari");
	       		$cell->setFontSize(12);
	       });

	       $ketua_nama = "";
	       $ketua_nip = "";

	       $wketua_nama = "";
	       $wketua_nip = "";

	       //Data ketua
	       $user_ketua = User::where('user_level_id', 2)->first();
	       if($user_ketua){
	       		$ketua_nama = $user_ketua->name;
	       		$ketua_nip = $user_ketua->nip;		       	
	       }
	       //Data ketua
	       $user_wketua = User::where('user_level_id', 3)->first();
	       	if($user_wketua){
	       		$wketua_nama = $user_wketua->name;
	       		$wketua_nip = $user_wketua->nip;
	       	}


	       $start_row += 4;
	       $sheet->cell('C'.$start_row, function($cell) use($ketua_nama){
	       		$cell->setValue($ketua_nama);
	       		$cell->setFontSize(12);
	       });
	       $sheet->getStyle('C'.$start_row)->getFont()->setUnderline(true);

	       $sheet->cell('I'.$start_row, function($cell) use($wketua_nama){
	       		$cell->setValue($wketua_nama);
	       		$cell->setFontSize(12);
	       });
	       $sheet->getStyle('I'.$start_row)->getFont()->setUnderline(true);

	       $start_row += 1;
	       $sheet->cell('C'.$start_row, function($cell) use($ketua_nip){
	       		$cell->setValue(" ".$ketua_nip);
	       		$cell->setFontSize(12);

	       		$cell->setAlignment('left');
			    $cell->setValignment('top');
	       });

	       $sheet->cell('I'.$start_row, function($cell) use($wketua_nip){
	       		$cell->setValue(" ".$wketua_nip);
	       		$cell->setFontSize(12);

	       		$cell->setAlignment('left');
			    $cell->setValignment('top');
	       });



	        $sheet->getPageSetup()->setOrientation('landscape'); 
	    });
    }

    private function sheet_laporan_tindak_lanjut($excel, $request){
    	$excel->sheet("Laporan Tindak Lanjut", function($sheet) use($request){
	        // Sheet manipulation

	        
			$sheet->setWidth(array(
			    'A'     =>  5,
			    'B'     =>  15,
			    'C'     =>  15,
			    'D'     =>  40,
			    'E'     =>  6.05375,
			    'F'     =>  6.05375,
			    'G'     =>  6.05375,
			    'H'     =>  6.05375,
			    'I'     =>  6.05375,
			    'J'     =>  6.05375,
			    'K'     =>  6.05375,
			    'L'     =>  6.05375,
			    'M'		=> 20,
			));

			$start_row = 3 + $this->letter_head($sheet, "A", "M", 1);
			$sheet->mergeCells('A'.$start_row.':N'.$start_row);
			$sheet->cell('A'.$start_row, function($cell){
				$cell->setValue("LAPORAN TINDAK LANJUT PENGAWASAN BIDANG");
			    $cell->setFontSize(12);
			    $cell->setAlignment('center');
			    $cell->setValignment('center');
			    $cell->setFontWeight('bold');
			});


			$start_row += 1;
			$sheet->mergeCells('A'.$start_row.':N'.$start_row);
			$sheet->cell('A'.$start_row, function($cell){
				$cell->setValue("PENGADILAN NEGERI /PHI /TIPIKOR KENDARI KELAS IA");
			    $cell->setFontSize(12);
			    $cell->setAlignment('center');
			    $cell->setValignment('center');
			    $cell->setFontWeight('bold');
			});


			$start_row += 3;
			$start_row_head_col = $start_row;
			$sheet->mergeCells('E'."$start_row".':L'.$start_row);
	        $sheet->row($start_row, array(
			     'No','Bidang','Periode','Indikator','uraian','','','','','','','','Evidence'
			));

			$sheet->cell('A'.$start_row.':N'.$start_row, function($cell) {
			    // manipulate the cell
			    $cell->setAlignment('center');
			    $cell->setValignment('center');
			    $cell->setFontWeight('bold');
			    $cell->setFontSize(12);
			});

			

			
			$start_row +=1;
			$no = 1;

	        $indikator = DB::table('indikator_sectors')
	        	->join('secretariats','secretariats.id','=','secretariat_id')
	        	->join('sectors','sectors.id','=','indikator_sectors.sector_id')
	        	->select('secretariats.id','sectors.nama','indikator','evidence','uraian','secretariats.sector_id','secretariat_id','periode_tahun','periode_bulan')
	        	->where('evidence',0)
	        	->where('periode_bulan',$request->periode_bulan)
	        	->where('periode_tahun',$request->periode_tahun)
	        	->orderBy('periode_tahun','DESC')
	        	->orderBy('periode_bulan','DESC')
	        	->orderBy('sectors.id','ASC')
	        	->orderBy('indikator','ASC');
	        $indikator = $indikator->get();

	        $sectors = DB::table('sectors')->pluck('nama','id');

	        foreach ($indikator as $row_indikator) {
	        	# code...
	        	 

	        	$real_url = 'hawasbid_indikator/'.$row_indikator->id;

	        	$link = url('redev?url='.$real_url);

	        	$temuan = "ada";
	        	if($row_indikator->evidence == 0){
	        		$temuan = "-";
	        	}
	        	
	        	$sheet->getCellByColumnAndRow(12,$start_row)->getHyperlink()->setUrl($link);

	        	$periode = $this->getNameMonth($row_indikator->periode_bulan)." ".$row_indikator->periode_tahun;
		        
		        $sheet->row($start_row, array(
				     $no,"(".$sectors[$row_indikator->sector_id].")\n".$row_indikator->nama,$periode,$row_indikator->indikator,$row_indikator->uraian,"","","","","","","","", $temuan,
				));

				$sheet->mergeCells('E'."$start_row".':L'.$start_row);
				// $sheet->mergeCells('L'."$start_row".':M'.$start_row);
				$start_row +=1;
				$no += 1;
	        }

	        $sheet->cells('M'.($start_row_head_col+1).':M'.$start_row, function($cells) {

			    // manipulate the cell
			    $cells->setAlignment('center');
			    $cells->setValignment('top');
			});
			$sheet->cells('A'.($start_row_head_col+1).':A'.$start_row, function($cells) {

			    // manipulate the cell
			    $cells->setAlignment('center');
			    $cells->setValignment('top');
			});
			$sheet->cells('B'.($start_row_head_col+1).':C'.$start_row, function($cells) {

			    // manipulate the cell
			    $cells->setAlignment('center');
			    $cells->setValignment('top');
			});
			$sheet->cells('N'.($start_row_head_col+1).':N'.$start_row, function($cells) {

			    // manipulate the cell
			    $cells->setAlignment('center');
			    $cells->setValignment('top');
			});
			$sheet->cells('D'.($start_row_head_col+1).':K'.$start_row, function($cells) {

			    // manipulate the cell
			    $cells->setAlignment('left');
			    $cells->setValignment('top');
			});

			$border_style= array('borders' => array('allborders' => array('style' =>'thin','color' => array('argb' => '766f6e'),)));

			$sheet->getStyle('A'.$start_row_head_col.':M'.($start_row-1))->applyFromArray($border_style);

	        $sheet->getStyle('A'.($start_row_head_col).':M'.$start_row)
	        	->getAlignment()->setWrapText(true);


	       $start_row += 1;
	       $sheet->cell('B'.$start_row, function($cell){
	       		$cell->setValue("Mengetahui");
	       		$cell->setFontSize(12);
	       });
	       $start_row += 1;
	       $sheet->cell('I'.$start_row, function($cell){
	       		$cell->setValue("Koordinator Pengawas Bidang");
	       		$cell->setFontSize(12);
	       });
	       $start_row += 2;
	       $sheet->cell('B'.$start_row, function($cell){
	       		$cell->setValue("Ketua Pengadilan Negeri /PHI /TIPIKOR Kendari Kelas IA");
	       		$cell->setFontSize(12);
	       });

	       $sheet->cell('I'.$start_row, function($cell){
	       		$cell->setValue("Wakil Ketua Pengadilan Negeri Kendari");
	       		$cell->setFontSize(12);
	       });

	       $ketua_nama = "";
	       $ketua_nip = "";

	       $wketua_nama = "";
	       $wketua_nip = "";

	       //Data ketua
	       $user_ketua = User::where('user_level_id', 2)->first();
	       if($user_ketua){
	       		$ketua_nama = $user_ketua->name;
	       		$ketua_nip = $user_ketua->nip;		       	
	       }
	       //Data ketua
	       $user_wketua = User::where('user_level_id', 3)->first();
	       	if($user_wketua){
	       		$wketua_nama = $user_wketua->name;
	       		$wketua_nip = $user_wketua->nip;
	       	}


	       $start_row += 4;
	       $sheet->cell('C'.$start_row, function($cell) use($ketua_nama){
	       		$cell->setValue($ketua_nama);
	       		$cell->setFontSize(12);
	       });
	       $sheet->getStyle('C'.$start_row)->getFont()->setUnderline(true);

	       $sheet->cell('I'.$start_row, function($cell) use($wketua_nama){
	       		$cell->setValue($wketua_nama);
	       		$cell->setFontSize(12);
	       });
	       $sheet->getStyle('I'.$start_row)->getFont()->setUnderline(true);

	       $start_row += 1;
	       $sheet->cell('C'.$start_row, function($cell) use($ketua_nip){
	       		$cell->setValue(" ".$ketua_nip);
	       		$cell->setFontSize(12);

	       		$cell->setAlignment('left');
			    $cell->setValignment('top');
	       });

	       $sheet->cell('I'.$start_row, function($cell) use($wketua_nip){
	       		$cell->setValue(" ".$wketua_nip);
	       		$cell->setFontSize(12);

	       		$cell->setAlignment('left');
			    $cell->setValignment('top');
	       });



	        $sheet->getPageSetup()->setOrientation('landscape'); 
	    });
    }

    private function sheet_laporan_keseluruhan($excel, $request){
    	$excel->sheet("Laporan Keseluruhan", function($sheet) use($request){
	        // Sheet manipulation

	        
			$sheet->setWidth(array(
			    'A'     =>  5,
			    'B'     =>  15,
			    'C'     =>  48.43,
			    'D'     =>  6.05375,
			    'E'     =>  6.05375,
			    'F'     =>  6.05375,
			    'G'     =>  6.05375,
			    'H'     =>  6.05375,
			    'I'     =>  6.05375,
			    'J'     =>  6.05375,
			    'K'     =>  6.05375,
			    'L'		=> 14.215,
			    'M'		=> 14.215,
			));

			$start_row = 3 + $this->letter_head($sheet, "A", "M", 1);

			$start_row_head = $start_row;

			$sheet->mergeCells('A'.$start_row.':M'.$start_row);
			$sheet->cell('A'.$start_row, function($cell){
				$cell->setValue("LAPORAN PENGAWASAN BIDANG");
			    $cell->setFontSize(12);
			    $cell->setAlignment('center');
			    $cell->setValignment('center');
			    $cell->setFontWeight('bold');
			});

			$start_row += 1;
			$sheet->mergeCells('A'.$start_row.':M'.$start_row);
			$sheet->cell('A'.$start_row, function($cell){
				$cell->setValue("PENGADILAN NEGERI /PHI /TIPIKOR KENDARI KELAS IA");
			    $cell->setFontSize(12);
			    $cell->setAlignment('center');
			    $cell->setValignment('center');
			    $cell->setFontWeight('bold');
			});

			
			$start_row += 2;
			$sheet->mergeCells('A'.$start_row.':L'.$start_row);
			$sheet->cell('A'.$start_row, function($cell) use($request) {

			    // manipulate the cell
			    $cell->setValue("Periode: ".$this->getNameMonth($request->periode_bulan)." ".$request->periode_tahun);
			    $cell->setFontSize(12);
			    $cell->setAlignment('left');
			    $cell->setValignment('top');
			});

			$start_row +=1;
			$start_row_head_col = $start_row;
			$sheet->mergeCells('D'.$start_row.':K'.$start_row);
	        $sheet->row($start_row, array(
			     'No','Bidang','Indikator','uraian','','','','','','','','Tindak Lanjut','Evidence'
			));
	        $sheet->cell('A'.$start_row.':M'.$start_row, function($cell) {
			    // manipulate the cell
			    $cell->setAlignment('center');
			    $cell->setValignment('center');
			    $cell->setFontWeight('bold');
			    $cell->setFontSize(12);
			});

	        $col_no = "A";
	        $col_bidang = "B";
	        $col_indikator = "C";
	        $col_uraian = "D";
	        $col_uraian_l = "K";
	        $col_tindak_lanjut = "L";
	        $col_evidence = "M";

			
			$start_row +=1;
			$no = 1;
	        $indikator = DB::table('indikator_sectors')
	        	->join('secretariats','secretariats.id','=','secretariat_id')
	        	->join('sectors','sectors.id','=','indikator_sectors.sector_id')
	        	->select('secretariats.id','sectors.nama','indikator','evidence','uraian','secretariats.sector_id','secretariat_id','status_tindakan')
	        	->whereNotNull('secretariats.sector_id')
	        	->where('periode_bulan',$request->periode_bulan)
	        	->where('periode_tahun',$request->periode_tahun)
	        	->orderBy('periode_tahun','DESC')
	        	->orderBy('periode_bulan','DESC')
	        	->orderBy('sectors.id','ASC')
	        	->orderBy('indikator','ASC');

	        $sectors = DB::table('sectors')->pluck('nama','id');	        
	        $indikator = $indikator->get();

	        foreach ($indikator as $row_indikator) {
	        	# code...
	        	$tindak_lanjut = "-";
	        	if($row_indikator->status_tindakan == 1){
	        		$tindak_lanjut = "ya";
	        	}
	        	$real_url = 'hawasbid_indikator/'.$row_indikator->id;

	        	$link = url('redev?url='.$real_url);

	        	$temuan = "ada";
	        	if($row_indikator->evidence == 0){
	        		$temuan = "-";
	        	}
	        	
	        	$sheet->getCellByColumnAndRow(12,$start_row)->getHyperlink()->setUrl($link);

		        $sheet->row($start_row, array(
				     $no,"(".$sectors[$row_indikator->sector_id].") \n".$row_indikator->nama,$row_indikator->indikator,$row_indikator->uraian,"","","","","","","",$tindak_lanjut,$temuan
				));

				$sheet->mergeCells($col_uraian.$start_row.':'.$col_uraian_l.$start_row);

				$start_row +=1;
				$no += 1;
	        }

	        $sheet->cells($col_tindak_lanjut.($start_row_head_col+1).':'.$col_evidence.$start_row, function($cells) {

			    // manipulate the cell
			    $cells->setAlignment('center');
			    $cells->setValignment('top');
			});
			$sheet->cells($col_no.($start_row_head_col+1).':'.$col_bidang.$start_row, function($cells) {

			    // manipulate the cell
			    $cells->setAlignment('center');
			    $cells->setValignment('top');
			});

			$sheet->cells($col_indikator.($start_row_head_col+1).':'.$col_uraian_l.$start_row, function($cells) {

			    // manipulate the cell
			    $cells->setAlignment('left');
			    $cells->setValignment('top');
			});

			$border_style= array('borders' => array('allborders' => array('style' =>'thin','color' => array('argb' => '766f6e'),)));

			$sheet->getStyle($col_no.$start_row_head_col.':'.$col_evidence.($start_row-1))->applyFromArray($border_style);

	        $sheet->getStyle($col_no.$start_row_head_col.':'.$col_evidence.($start_row-1))
	        	->getAlignment()->setWrapText(true);


	       $start_row += 1;
	       $sheet->cell('B'.$start_row, function($cell){
	       		$cell->setValue("Mengetahui");
	       		$cell->setFontSize(12);
	       });
	       $start_row += 1;
	       $sheet->cell('I'.$start_row, function($cell){
	       		$cell->setValue("Koordinator Pengawas Bidang");
	       		$cell->setFontSize(12);
	       });
	       $start_row += 2;
	       $sheet->cell('B'.$start_row, function($cell){
	       		$cell->setValue("Ketua Pengadilan Negeri /PHI /TIPIKOR Kendari Kelas IA");
	       		$cell->setFontSize(12);
	       });

	       $sheet->cell('I'.$start_row, function($cell){
	       		$cell->setValue("Wakil Ketua Pengadilan Negeri Kendari");
	       		$cell->setFontSize(12);
	       });

	       $ketua_nama = "";
	       $ketua_nip = "";

	       $wketua_nama = "";
	       $wketua_nip = "";

	       //Data ketua
	       $user_ketua = User::where('user_level_id', 2)->first();
	       if($user_ketua){
	       		$ketua_nama = $user_ketua->name;
	       		$ketua_nip = $user_ketua->nip;		       	
	       }
	       //Data ketua
	       $user_wketua = User::where('user_level_id', 3)->first();
	       	if($user_wketua){
	       		$wketua_nama = $user_wketua->name;
	       		$wketua_nip = $user_wketua->nip;
	       	}


	       $start_row += 4;
	       $sheet->cell('C'.$start_row, function($cell) use($ketua_nama){
	       		$cell->setValue($ketua_nama);
	       		$cell->setFontSize(12);
	       });
	       $sheet->getStyle('C'.$start_row)->getFont()->setUnderline(true);

	       $sheet->cell('I'.$start_row, function($cell) use($wketua_nama){
	       		$cell->setValue($wketua_nama);
	       		$cell->setFontSize(12);
	       });
	       $sheet->getStyle('I'.$start_row)->getFont()->setUnderline(true);

	       $start_row += 1;
	       $sheet->cell('C'.$start_row, function($cell) use($ketua_nip){
	       		$cell->setValue(" ".$ketua_nip);
	       		$cell->setFontSize(12);

	       		$cell->setAlignment('left');
			    $cell->setValignment('top');
	       });

	       $sheet->cell('I'.$start_row, function($cell) use($wketua_nip){
	       		$cell->setValue(" ".$wketua_nip);
	       		$cell->setFontSize(12);

	       		$cell->setAlignment('left');
			    $cell->setValignment('top');
	       });



	        $sheet->getPageSetup()->setOrientation('landscape'); 
	    });
    }

    private function letter_head($sheet, $col_start, $col_target, $start_row){
    	$sheet->setHeight($start_row, 35);
		$sheet->mergeCells($col_start.$start_row.':'.$col_target.$start_row);
		$sheet->cell($col_start.$start_row, function($cell){
			$cell->setValue("PENGADILAN NEGERI/PHI/TIPIKOR KENDARI KELAS IA");
		    $cell->setFontSize(11);
		    $cell->setAlignment('center');
		    $cell->setValignment('center');
		    $cell->setFontWeight('bold');
		    $cell->setFontFamily('Stencil');
		});

		$objDrawing = new PHPExcel_Worksheet_Drawing;
        $objDrawing->setPath(public_path('assets/img/logo_header.png')); //your image path
        $objDrawing->setCoordinates('C'.$start_row);
        $objDrawing->setWorksheet($sheet);


		$start_row += 1;
		$sheet->mergeCells($col_start.$start_row.':'.$col_target.$start_row);
		$sheet->cell($col_start.$start_row, function($cell){
			$cell->setValue("Jalan Mayjen Sutoyo No.37 Kendari Sulawesi Tenggara");
		    $cell->setFontSize(11);
		    $cell->setAlignment('center');
		    $cell->setValignment('center');
		});

		$start_row += 1;
		$sheet->mergeCells($col_start.$start_row.':'.$col_target.$start_row);
		$sheet->cell($col_start.$start_row, function($cell){
			$cell->setValue("Telp. 0401-3121714 Fax. 0401-3121714");
		    $cell->setFontSize(11);
		    $cell->setAlignment('center');
		    $cell->setValignment('center');
		});

		$start_row+=1;
		$sheet->mergeCells($col_start.$start_row.':'.$col_target.$start_row);
		$sheet->cell($col_start.$start_row, function($cell){
			$cell->setValue("Website : pn-kendari.go.id Email : peen.kendari@yahoo.com");
		    $cell->setFontSize(11);
		    $cell->setAlignment('center');
		    $cell->setValignment('center');
		});

		// $start_row += 1;
		$border_style= array('borders' => array('bottom' => array('style' =>'thick','color' => array('argb' => '28527a'),)));
		$sheet->getStyle($col_start.$start_row.':'.$col_target.$start_row)->applyFromArray($border_style);

		return $start_row;
    }

    

    private function laporan_bidang($request){
    	ini_set("memory_limit", "999M");
		ini_set("max_execution_time", 999);

    	Excel::create($request->nama_file, function($excel) use($request) {
    		$user = Auth::user();
    		foreach ($request->sector_id as $vsector) {
	    		$info_sector = Sector::where('sectors.id',$vsector);
	    		
	    		if($user->id == 10){
	    			$info_sector = 	$info_sector->where('user_id',$user->id)
	    							->join('user_level_groups','sector_id','=','sectors.id');
	    		}
	    			
	    		$info_sector = 	$info_sector->first();
	    		

	    		$sector_name = $info_sector->nama;
	    		$excel->sheet($info_sector->alias, function($sheet) use($vsector, $sector_name,$info_sector,$request){
			        // Sheet manipulation

			        $evidence = null;

			        if(isset($request->evidence)){
			        	$evidence = $request->evidence;
			        }

	    			$sheet->setWidth(array(
					    'A'     =>  5,
					    'B'     =>  15,
					    'C'     =>  48.43,
					    'D'     =>  6.05375,
					    'E'     =>  6.05375,
					    'F'     =>  6.05375,
					    'G'     =>  6.05375,
					    'H'     =>  6.05375,
					    'I'     =>  6.05375,
					    'J'     =>  6.05375,
					    'K'     =>  6.05375,
					    'L'		=> 14.215,
					    'M'		=> 14.215,
					));

					// set up letter head
					$start_row = 3 + $this->letter_head($sheet, "A", "M", 1);
					
					$sheet->mergeCells('A'.$start_row.':M'.$start_row);

					$sheet->cell('A'.$start_row, function($cell) use($info_sector){
						$cell->setValue("LAPORAN PENGAWASAN BIDANG");
					    $cell->setFontSize(12);
					    $cell->setAlignment('center');
					    $cell->setValignment('center');
					    $cell->setFontWeight('bold');
					});
					$start_row += 1;
					$sheet->mergeCells('A'.$start_row.':M'.$start_row);
					$sheet->cell('A'.$start_row, function($cell) use($info_sector){
						$cell->setValue($info_sector->nama_lengkap);
					    $cell->setFontSize(12);
					    $cell->setAlignment('center');
					    $cell->setValignment('center');
					    $cell->setFontWeight('bold');
					});

					$start_row += 1;
					$sheet->mergeCells('A'.$start_row.':M'.$start_row);
					$sheet->cell('A'.$start_row, function($cell){
						$cell->setValue("PENGADILAN NEGERI /PHI /TIPIKOR KENDARI KELAS IA");
					    $cell->setFontSize(12);
					    $cell->setAlignment('center');
					    $cell->setValignment('center');
					    $cell->setFontWeight('bold');
					});

					$start_row += 4;
					$sheet->mergeCells('A'.$start_row.':K'.$start_row);
	    			$sheet->cell('A'.$start_row, function($cell) use($request) {

					    // manipulate the cell
					    $cell->setValue("Periode: ".$this->getNameMonth($request->periode_bulan)." ".$request->periode_tahun);
					    $cell->setFontSize(12);
					    $cell->setAlignment('left');
					    $cell->setValignment('top');
					});


					$start_row += 2;
					$sheet->cell('A'.$start_row, function($cell){
						$cell->setValue("Dokumentasi Rapat: ");
						$cell->setFontSize(12);
					    $cell->setAlignment('left');
					    $cell->setValignment('top');
					});

					$real_url = strtolower('pengawas-bidang/'.$info_sector->category.'/'.$info_sector->alias.'/dokumentasi_rapat?periode_bulan='.$request->periode_bulan.'__periode_tahun='.$request->periode_tahun);
					// dd(html_entity_decode($real_url));

		        	$link = url('redev?url='.$real_url);
		        	$sheet->getCellByColumnAndRow(0,$start_row)->getHyperlink()->setUrl($link);
		        	

					$start_row += 1;
					$sheet->cell('B'.$start_row, function($cell){
						$cell->setValue("1. Notulen Rapat");
						$cell->setFontSize(12);
					    $cell->setAlignment('left');
					    $cell->setValignment('top');
					});
					$start_row += 1;
					$sheet->cell('B'.$start_row, function($cell){
						$cell->setValue("2. Absensi");
						$cell->setFontSize(12);
					    $cell->setAlignment('left');
					    $cell->setValignment('top');
					});

					$start_row += 1;
					$sheet->cell('B'.$start_row, function($cell){
						$cell->setValue("3. Foto");
						$cell->setFontSize(12);
					    $cell->setAlignment('left');
					    $cell->setValignment('top');
					});

					$start_row += 2;
			        $row_head_table  = $start_row;
			        $sheet->row($row_head_table, array(
					     'No','Bidang','Indikator','uraian','','','','','','','','Tindak Lanjut','Evidence'
					));
					$col_no = "A";
					$col_bidang = "B";
					$col_indikator = "C";
					$col_uraian = "D";
					$col_uraian_l = "K";
					$col_tindak_lanjut = "L";
					$col_evidence = "M";

			        // $sheet->mergeCells('C'.$row_head_table.':J'.$row_head_table);
			        $sheet->cell($col_no.$row_head_table.':'.$col_evidence.$row_head_table, function($cell) use($sector_name) {

					    // manipulate the cell
					    $cell->setAlignment('center');
					    $cell->setValignment('center');
					    $cell->setFontWeight('bold');
					    $cell->setFontSize(12);
					});

			        $sheet->mergeCells($col_uraian.$row_head_table.':'.$col_uraian_l.$row_head_table);					


					$start_row += 1;
					$no = 1;
			        $indikator = DB::table('indikator_sectors')
			        	->join('secretariats','secretariats.id','=','secretariat_id')
			        	->join('sectors','indikator_sectors.sector_id','=','sectors.id')
			        	->select('sectors.nama','secretariats.id as indikator_id','indikator_sectors.id','indikator','evidence','uraian','secretariat_id','status_tindakan')
			        	->where('periode_bulan',$request->periode_bulan)
			        	->where('periode_tahun',$request->periode_tahun)
			        	->where(function($q) use($vsector){
			        		$q->where('secretariats.sector_id',$vsector)
			        			->orWhere(function($qq) use($vsector){
			        				$qq->where('indikator_sectors.sector_id',$vsector)
			        				->whereRaw('indikator_sectors.sector_id != secretariats.sector_id');
			        			});
			        	})
			        	->orderBy('periode_tahun','DESC')
			        	->orderBy('periode_bulan','DESC')
			        	->orderBy('indikator','ASC');

			        $indikator = $indikator->get();
			        foreach ($indikator as $row_indikator) {
			        	# code...
			        	$sheet->mergeCells($col_uraian.$start_row.':'.$col_uraian_l.$start_row);

			        	$real_url = strtolower('hawasbid_indikator').'/'.$row_indikator->indikator_id;

			        	// $real_url = strtolower('pengawas-bidang/'.$info_sector->category)."/".$info_sector->alias.'/'.$row_indikator->id;
			        	$link = url('redev?url='.$real_url);
			        	$sheet->getCellByColumnAndRow(12,$start_row)->getHyperlink()->setUrl($link);

			        	$temuan = "ada";
			        	$tindak_lanjut = "-";
			        	if($row_indikator->evidence == 0){
			        		$temuan = "-";
			        	}
			        	if($row_indikator->status_tindakan == 1){
			        		$tindak_lanjut = "ya";
			        	}

			        	

			        	// dd($db_pic->toArray());

				        $sheet->row($start_row, array(
						     $no,$row_indikator->nama, $row_indikator->indikator,$row_indikator->uraian,"","","","","","","", $tindak_lanjut,$temuan
						));

						// $sheet->mergeCells('C'."$start_row".':J'.$start_row);
						// $sheet->mergeCells('L'."$start_row".':M'.$start_row);
						$start_row +=1;
						$no += 1;
			        }

			        $sheet->cells($col_tindak_lanjut.($row_head_table+1).':'.$col_evidence.$start_row, function($cells) {

					    // manipulate the cell
					    $cells->setAlignment('center');
					    $cells->setValignment('top');
					});
					$sheet->cells('A'.($row_head_table+1).':A'.$start_row, function($cells) {

					    // manipulate the cell
					    $cells->setAlignment('center');
					    $cells->setValignment('top');
					});
					$sheet->cells($col_bidang.($row_head_table+1).':'.$col_uraian_l.$start_row, function($cells) {

					    // manipulate the cell
					    $cells->setAlignment('left');
					    $cells->setValignment('top');
					});

					$border_style= array('borders' => array('allborders' => array('style' =>'thin','color' => array('argb' => '766f6e'),)));

					$sheet->getStyle('A'.$row_head_table.':'.$col_evidence.($start_row-1))->applyFromArray($border_style);

			        $sheet->getStyle('A'.$row_head_table.':'.$col_evidence.$start_row)
			        	->getAlignment()->setWrapText(true);


			        // assigment area
			        $start_row+= 2;
			        $sheet->mergeCells('H'.$start_row.':K'.$start_row);
			        $th = date('Y');
			        $bl = date('m');
			        $tg = date('d');
			        $sheet->cell('H'.$start_row, function($cell) use($th, $tg, $bl){
			        	$cell->setValue("Kendari/ ".$tg.' '.$this->getNameMonth($bl).' '.$th);
			        	$cell->setFontSize(12);
			        	$cell->setAlignment('left');
					    $cell->setValignment('top');
			        });
			        $start_row += 1;
			        $sheet->mergeCells('H'.$start_row.':K'.$start_row);
			        $sheet->cell('H'.$start_row, function($cell){
			        	$cell->setValue("Hakim Pengawas Bidang");
			        	$cell->setFontSize(12);
			        	
			        	$cell->setAlignment('left');
					    $cell->setValignment('top');
			        });

			        $start_row += 1;
			        // $sheet->mergeCells('H'.$start_row.':K'.$start_row);
			        $sheet->cell('H'.$start_row, function($cell) use($info_sector){
			        	$cell->setValue(ucfirst(strtolower($info_sector->nama_lengkap)));
			        	// $cell->setFontSize(12);$cell->setAlignment('center');
					    $cell->setValignment('top');

			        });

			        $start_row += 3;
			        
			        $sheet->cell('H'.$start_row, function($cell) use($info_sector){
			        	$cell->setValue($info_sector->penanggung_jawab);
			        	$cell->setFontSize(12);
			        });

			        $sheet->getStyle('H'.$start_row)->getFont()->setUnderline(true);

			        // $border_style= array('borders' => array('bottom' => array('style' =>'thin','color' => array('argb' => '766f6e'),)));
			        // $sheet->getStyle('H'.$start_row.':K'.$start_row)->applyFromArray($border_style);

			        $start_row += 1;
			        $sheet->cell('H'.$start_row, function($cell) use($info_sector){
			        	$cell->setValue(" ".$info_sector->nip);
			        	$cell->setFontSize(12);
			        });

			        $sheet->getPageSetup()->setOrientation('landscape'); 
			    });
    		}

		})
		// ->export('pdf');
		->export('xlsx');
    }
    private function getNameMonth($m){
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
