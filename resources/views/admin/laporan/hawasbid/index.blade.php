@extends('layouts.app_admin')
@extends('layouts.nav_admin')

@section('content')


<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">Cetak Laporan</h1>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Hawasbid</h6>
    </div>
    <div class="card-body">

    	@if ($errors->any())
	        <div class="row">
	            <div class="col-md-7">
	                <div class="alert alert-danger">
	                    <button type="button" class="close" data-dismiss="alert"
	                        aria-hidden="true">&times;</button>
	                    Gagal memperbaharui Data
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



	    {!! Form::open([
	    	  'id'	=> 'send',
	          'method' => 'POST',
	          'url' => session('role').'/laporan/hawasbid',
	          'class' => 'form-horizontal',
	          'id'	=> 'cetak',
	          'files' => false
	      ]) !!}

	    @include ('admin.laporan.hawasbid.form')

	    {!! Form::close() !!}


    </div>
</div>
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap-multiselect.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/daterangepicker.css')}}" />
@endsection


@section('js')
<script type="text/javascript" src="{{asset('js/moment.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/daterangepicker.min.js')}}"></script>

<script type="text/javascript" src="{{asset('js/bootstrap-multiselect.min.js')}}"></script>
<script type="text/javascript">
	$("#sector_form").multiselect()
	jenis_laporan = $("#jenis_laporan")
	sector_form = $("#sector_form")

	$("#cetak").submit(function(){
		var bidang = sector_form.val().length
		var jl = jenis_laporan.val()

		if(jl == 1 && bidang == 0){
			alert("form bidang belum terpilih")
			return false;
		}
		return true;
	})

	jenis_laporan.on('change',function(){
		if(jenis_laporan.val() == 1){
			sector_form.attr("required","required")
			$("#fsector_form").show()
		}else{
			$("#fsector_form").hide()
			sector_form.removeAttr("required","required")
		}
	});	



</script>
@endsection