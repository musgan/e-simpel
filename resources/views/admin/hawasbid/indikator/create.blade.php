@extends('layouts.app_admin')
@extends('layouts.nav_admin')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
<h1 class="h3 mb-0 text-gray-800">Hawasbid</h1>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Indikator <i class="fas fa-fw fa-chevron-right"></i> Create</h6>
    </div>

    <div class="card-body">
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

	    <div class="action-btn btn-back">
	      	<a href="{{

	      	((session('backlink_indikator_hawasbid'))) ? session('backlink_indikator_hawasbid') : url(session('role').'/hawasbid_indikator')

	      }}" class="btn btn-danger btn-flat btn-sm"><i class="fa fa-chevron-left" aria-hidden="true"></i> Kembali</a>
	    </div>

	    {!! Form::open(['url' => session('role').'/hawasbid_indikator', 'class' => 'form-horizontal', 'files' => true]) !!}

	    @include ('admin.hawasbid.indikator.form');

	    {!! Form::close() !!}

    </div>
</div>
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap-multiselect.min.css')}}">
@endsection

@section('js')
<script type="text/javascript" src="{{asset('js/bootstrap-multiselect.min.js')}}"></script>
<script type="text/javascript">
	$("#sector_form").multiselect();
</script>
@endsection