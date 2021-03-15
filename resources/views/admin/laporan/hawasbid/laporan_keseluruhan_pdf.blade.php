
@include('admin.laporan.style_pdf')
@include('admin.laporan.header_pdf')

<?php
	$indikator = $lp_keseluruhan['indikator'];
	$no = 1;
?>

<h4 class="text-center header_title"> <b>LAPORAN PENGAWASAN BIDANG </b></h4>
<h4 class="text-center header_title"> <b>PENGADILAN NEGERI /PHI /TIPIKOR KENDARI KELAS IA</b> </h4>

<br>
<br>
<p class="normal_font">{{$lp_keseluruhan['periode']}}</p>
<table class="table table-striped table-bordered" border="1px">
	<thead>
		<tr>
			<th   class="text-center">No</th> 
			<th class="text-center" >Bidang</th>
			<th width="30%" class="text-center">Indikator</th>
			<th  width="30%" class="text-center">Urairan</th>
			<th class="text-center">Tindak Lanjut</th> 
			<th class="text-center">Evidence</th>
		</tr>
	</thead>

	<tbody>
		@foreach($indikator as $row)
		<?php		
			$ev = "ada";
			if($row->evidence == 0)
				$ev = "-";

			$tindakan = "-";

			if($row->status_tindakan == 1)
				$tindakan = "Ya";

			$real_url = strtolower('hawasbid_indikator/'.$row->id);
			$link = url('redev?url='.$real_url);
		
		?>
		<tr>
			<td class="text-center">{{$no++}}</td>
			<td class="text-center">{{str_replace('"','',$row->nama)}}</td>
			<td class="text-left">{!!  str_replace("\n","<br>",$row->indikator) !!}</td>
			<td class="text-left">{!! $row->uraian !!}</td>
			<td class="text-center">{!! $tindakan !!}</td>
			<td class="text-center"><a target="_blank" href="{{$link}}">{{$ev}} </a></td>
		</tr>
		@endforeach
	</tbody>
</table>

@include('admin.laporan.ttd_laporan_keseluruhan_pdf')

<div class="page-break"></div>



<!-- laporan temuan -->

@include('admin.laporan.header_pdf')

<?php
	$indikator = $lp_temuan['indikator'];
	$no = 1;
?>

<h4 class="text-center header_title"> <b>LAPORAN HASIL TEMUAN PENGAWASAN BIDANG</b></h4>
<h4 class="text-center header_title"> <b>PENGADILAN NEGERI /PHI /TIPIKOR KENDARI KELAS IA</b> </h4>

<br>
<br>
<table class="table table-striped table-bordered" border="1px">
	<thead>
		<tr>
			<th width="5%"   class="text-center">No</th> 
			<th width="15%">Periode</th>
			<th width="15%" class="text-center" >Bidang</th>
			<th  class="text-center">Indikator</th>
			<!-- <th  width="30%" class="text-center">Urairan</th>
			<th class="text-center">Tindak Lanjut</th> 
			<th class="text-center">Evidence</th> -->
		</tr>
	</thead>

	<tbody>
		@foreach($indikator as $row)
		<?php		
			$ev = "ada";
			if($row->evidence == 0)
				$ev = "-";

			$tindakan = "-";

			if($row->status_tindakan == 1)
				$tindakan = "Ya";

			$real_url = strtolower('hawasbid_indikator/'.$row->id);
			$link = url('redev?url='.$real_url);
		
		?>
		<tr>
			<td class="text-center">{{$no++}}</td>
			<td class="text-center">{{\CostumHelper::getNameMonth($row->periode_bulan).' '.$row->periode_tahun}}</td>
			<td class="text-center">{!! '<p class="no_margin">('.$sektor[$row->sector_id].')</p>'.str_replace('"','',$row->nama) !!}</td>
			<td class="text-left">{!!  str_replace("\n","<br>",$row->indikator) !!}</td>
			<!-- <td class="text-left">{!! $row->uraian !!}</td>
			<td class="text-center">{!! $tindakan !!}</td>
			<td class="text-center"><a target="_blank" href="{{$link}}">{{$ev}} </a></td> -->
		</tr>
		@endforeach
	</tbody>
</table>

@include('admin.laporan.ttd_laporan_keseluruhan_pdf')

<div class="page-break"></div>


@include('admin.laporan.header_pdf')

<?php
	$indikator = $lp_tindak_lanjut['indikator'];
	$no = 1;
?>

<h4 class="text-center header_title"> <b>LAPORAN TINDAK LANJUT PENGAWASAN BIDANG</b></h4>
<h4 class="text-center header_title"> <b>PENGADILAN NEGERI /PHI /TIPIKOR KENDARI KELAS IA</b> </h4>

<br>
<br>
<table class="table table-striped table-bordered" border="1px">
	<thead>
		<tr>
			<th width="5%"   class="text-center">No</th> 
			<th width="15%">Periode</th>
			<th width="15%" class="text-center" >Bidang</th>
			<th  class="text-center">Indikator</th>
			<!-- <th  width="30%" class="text-center">Urairan</th>
			<th class="text-center">Tindak Lanjut</th> 
			<th class="text-center">Evidence</th> -->
		</tr>
	</thead>

	<tbody>
		@foreach($indikator as $row)
		<?php		
			$ev = "ada";
			if($row->evidence == 0)
				$ev = "-";

			$tindakan = "-";

			if($row->status_tindakan == 1)
				$tindakan = "Ya";

			$real_url = strtolower('hawasbid_indikator/'.$row->id);
			$link = url('redev?url='.$real_url);
		
		?>
		<tr>
			<td class="text-center">{{$no++}}</td>
			<td class="text-center">{{\CostumHelper::getNameMonth($row->periode_bulan).' '.$row->periode_tahun}}</td>
			<td class="text-center">{!! '<p class="no_margin">('.$sektor[$row->sector_id].')</p>'.str_replace('"','',$row->nama) !!}</td>
			<td class="text-left">{!!  str_replace("\n","<br>",$row->indikator) !!}</td>
			<!-- <td class="text-left">{!! $row->uraian !!}</td>
			<td class="text-center">{!! $tindakan !!}</td>
			<td class="text-center"><a target="_blank" href="{{$link}}">{{$ev}} </a></td> -->
		</tr>
		@endforeach
	</tbody>
</table>

@include('admin.laporan.ttd_laporan_keseluruhan_pdf')

