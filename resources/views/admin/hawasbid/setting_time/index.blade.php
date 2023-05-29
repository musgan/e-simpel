@extends('layouts.app_admin')
@extends('layouts.nav_admin')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
<h1 class="h3 mb-0 text-gray-800">Setting Periode</h1>
</div>

<div class="row">
	
	<div class="col-md-5">

		@if ($errors->any())
	        <div class="row">
	            <div class="col-md-7">
	                <div class="alert alert-danger">
	                    <button type="button" class="close" data-dismiss="alert"
	                        aria-hidden="true">&times;</button>
	                    Gagal Menambah Data.
	                    <br>
	                    @foreach ($errors->all() as $error)
	                        <li>{{ $error }}</li>
	                    @endforeach
	                </div>
	            </div>
	        </div>
	    @endif
	    @if (session('status'))
	        <div class="alert alert-success">
	            {{ session('status') }}
	        </div>
	    @endif

	    @if (session('failed'))
	        <div class="alert alert-warning">
	            {{ session('failed') }}
	        </div>
	    @endif
		
		<div class="card shadow mb-4">
		    <div class="card-header py-3">
		      <h6 class="m-0 font-weight-bold text-primary">FORM</h6>
		    </div>
		    <div class="card-body">
		    	{!! Form::open(['url' => session('role').'/setting_time_hawasbid', 'class' => 'form-horizontal']) !!}
		    		@include('admin.hawasbid.setting_time.form')
		    	{!! Form::close() !!}
		    </div>
		</div>
	</div>

	<div class="col-md-7">


		
		<div class="card shadow mb-4">
		    <div class="card-body">
		    	<table class="table table-hover" id="dataTable">
		    		<thead>
		    			<th>Nama Periode</th>
		    			<th>Periode <br> Input Dokumen</th>
		    			<th>Periode <br> Tindak Lanjut</th>
		    			<th></th>
		    		</thead>
		    		<tbody>
		    			@foreach($data as $row)
		    	
				    	<tr>
				    		<td>
				    			{!! $row->periode_bulan."/ ".$row->periode_tahun !!}
				    		</td>
				    		<td> 
				    			{!! date('d M',strtotime($row->start_input_session))."/ ".date('d M',strtotime($row->stop_input_session)) !!}
				    		</td>
				    		<td>
				    			{!! date('d M', strtotime($row->start_periode_tindak_lanjut))."/ ".date('d M', strtotime($row->stop_periode_tindak_lanjut)) !!}
				    		</td>
				    		<td>
				    			<form class="delete" action="{{url(session('role').'/setting_time_hawasbid'.'/'.$row->id)}}" method="post">

				                  <a href="{{url('/setting_time_hawasbid/'.$row->id.'/edit/')}}" class="btn btn-warning btn-flat btn-sm mb-3"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
				                  {{ csrf_field() }}
				                  <br>
				                  
				                  <input type="hidden" name="_method" value="delete" />
				                  <button class="btn btn-flat btn-sm btn-danger"> <i class="fa fa-times" aria-hidden="true"></i></button>

				                </form>
				    		</td>
				    	</tr>
				    	@endforeach

		    		</tbody>
		    	</table>
		    </div>
		</div>

	</div>

	

</div>

@endsection


@section('js')

<script type="text/javascript">

$(".delete").submit(function(){
    var conf = confirm("yakin, anda menghapus file ini ?");
    
    if(conf)
      return true;

    return false;
});

$("#dataTable").DataTable()

</script>

@endsection