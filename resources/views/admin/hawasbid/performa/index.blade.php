@extends('layouts.app_admin')
@extends('layouts.nav_admin')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">Performa Hawasbid</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
    	{{Form::open(['url'	=> url(session('role').'/performa-hawasbid'),
    		'class'	=> '',
    		'method'	=> 'POST'
    	])}}
    	<div class="row">
    		<div class="form-group col-md-3">
    			{{Form::label('bulan','Perioden Bulan',['class'	=> 'control-label'])}}
    			{{Form::select('periode_bulan',$bulan,null,['class'=> 'form-control', 'required'	=> 'required', 'id'	=> 'periode_bulan'])}}
    		</div>

    		<div class="form-group col-md-3">
    			{{Form::label('','Periode Tahun',['class'	=> 'control-label'])}}
    			{{Form::input('number','periode_tahun',null,['class'	=> 'form-control', 'min'	=> 2018, 'required'	=> 'required', 'id'	=> 'periode_tahun'])}}
    		</div>
    		<div class="form-group col-md-12">
    			<a href="#" id="tampilkan" class="btn btn-success">Filter</a>
    			<button type="submit" class="btn btn-primary">Generate</button>
    			
    		</div>
    	</div>
    	{{Form::close()}}
    </div>
</div>


<div class="card shadow mb-4">
    <div class="card-body">
    	<h4 class="mb-5">Periode {{(isset($indikator_periode)) ? $indikator_periode : ' Belum Ditentukan'}}</h4>
    	<table class="table table-hover table-striped  text-center" id="dataTable" width="100%" cellspacing="0">
          	<thead>
	            <tr>
	            	
	            	<th rowspan="2" style="vertical-align: middle;">Bidang</th>
	            	<th colspan="4" class="text-center">Total</th>
	            	
	            </tr>
	            <tr>
	              <th>Indikator</th>
	              <th>Evidence (ada)</th>
	              <th>Tindak Lanjut</th>
	              <th>Tindak Lanjut (selesai)</th>
	            </tr>
          </thead>
          <tbody>
          	@foreach($data as $row)
          		<tr>
          			<td class="text-left">{{$row->category.'-'.$row->nama}}</td>
          			<td>{{$row->total_bidang}}</td>
	              	<td>{{$row->total_bidang_success}}</td>
	              	<td>{{$row->total_tindak_lanjut}}</td>
	              	<td>{{$row->total_tindak_lanjut_success}}</td>
          		</tr>
          	@endforeach
          </tbody>
      </table>

    </div>
</div>

@endsection

@section('js')
<script type="text/javascript">
	$("#tampilkan").on('click',function(e){
		// e.PreventDefault()

		def_link = '{{ url(session("role")."/performa-hawasbid") }}'
		periode_bulan = $("#periode_bulan").val();
		periode_tahun = $("#periode_tahun").val();

		def_link += "?periode_bulan="+periode_bulan+"&periode_tahun="+periode_tahun

		window.location.href = def_link;
	});

	$("#dataTable").DataTable({
		ordering: false
	})
</script>
@endsection