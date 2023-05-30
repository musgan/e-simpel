@extends('layouts.app_admin')
@extends('layouts.nav_admin')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
<h1 class="h3 mb-0 text-gray-800">{{ucfirst($sector->category)}}</h1>
</div>
<div class="card shadow mb-4">
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
	      	<a href="{{url(session('role').'/tindak-lanjutan/'.strtolower($sector->category).'/'.$sub_menu)}}" class="btn btn-danger btn-flat btn-sm"><i class="fa fa-chevron-left" aria-hidden="true"></i> Kembali</a>
	    </div>

	    {!! Form::open(['url' => session('role').'/tindak-lanjutan/'.strtolower($sector->category).'/'.$sub_menu, 'class' => 'form-horizontal', 'files' => true]) !!}

	    @include ('admin.kepaniteraan.form');

	    {!! Form::close() !!}

    </div>
</div>
@endsection