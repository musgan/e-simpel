@include('admin.laporan.style_pdf')

<!-- <h1>Page 1</h1>
<div class="page-break"></div>
<h1>Page 2</h1>
 -->

@foreach($indikator_sectors as $row_data_indikator_sector)
<?php
	$indikator = $row_data_indikator_sector['indikator'];
	$sektor = $row_data_indikator_sector['sector'];
	$no = 1;
?>


@include('admin.laporan.header_pdf')


<h4 class="text-center header_title"> <b>LAPORAN PENGAWASAN BIDANG </b></h4>
<h4 class="text-center header_title"> <b>{{$sektor->nama_lengkap}}</b></h4>
<h4 class="text-center header_title"> <b>PENGADILAN NEGERI /PHI /TIPIKOR KENDARI KELAS IA</b> </h4>

<br>
<br>
<?php
	$real_url = $all_sector[$sektor->id].'?periode_bulan='.$periode_bulan.'__periode_tahun='.$periode_tahun;
	$link = url('redev?url='.$real_url);
?>
<p class="normal_font">{{$periode}}</p>
<p><a href="{{$link}}" target="_blank">Dokumentasi Rapat</a></p>
<ol>
	<li>Notulen Rapat</li>
	<li>Absensi</li>
	<li>Foto</li>
</ol>
<table class="table table-striped table-bordered" border="1px">
	<thead>
		<tr>
			<th  class="text-center">No</th>
			<th>Bidang</th>
			<th  class="text-center">Indikator</th>
			<th  class="text-center">Uraian</th>
			<th  class="text-center">Tindak Lanjut</th>
			<th  class="text-center">Evidence</th>
			
		</tr>
	</thead>

	<tbody>
		@foreach($indikator as $row)
		<?php		
			$ev = "ada";
			if($row->evidence == 0)
				$ev = "-";

			$real_url = 'hawasbid_indikator/'.$row->secretariat_id;
			$link = url('redev?url='.$real_url);
		?>
		<tr>
			<td class="text-center">{{$no++}}</td>
			<td>{{$row->nama}}</td>
			<td class="text-left">{!!  str_replace("\n","<br>",$row->indikator) !!}</td>
			<td class="text-left">{!! $row->uraian !!}</td>
			<td class="text-center"> {{($row->status_tindakan == 1)? 'Ya' : '-'}} </td>
			<td class="text-center"><a target="_blank" href="{{$link}}">{{$ev}} </a></td>
			
		</tr>
		@endforeach
	</tbody>
</table>

@if($request->get('signature_break_'.$sektor->id) == "y")
<div class="page-break"></div>
@endif

<div class="col-md-6 col-md-offset-6 col-sm-offset-6 col-xs-offset-6">
	<p  class="normal_font p_ttd">Kendari/  {{date('d').' '.\CostumHelper::getNameMonth(date('m')).' '.date('Y') }} </p>
	<p  class="normal_font p_ttd">Hakim Pengawas Bidang</p>
	<p  class="normal_font p_ttd">{!! ucwords(strtolower($sektor->nama_lengkap)) !!}</p>
	<br>
	<br>
	<br>
	<p  class="normal_font p_ttd"><u>{{$sektor->penanggung_jawab}}</u></p>
	<p  class="normal_font p_ttd">{{$sektor->nip}}</p>
	

</div>

<div class="page-break"></div>

@endforeach