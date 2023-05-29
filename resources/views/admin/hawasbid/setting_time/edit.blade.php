@extends('layouts.app_admin')
@extends('layouts.nav_admin')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
<h1 class="h3 mb-0 text-gray-800">
	<a href="{{url(session('role').'/setting_time_hawasbid')}}" 
	class="btn btn-info btn-flat btn-sm"><i class="fa fa-chevron-left" aria-hidden="true"></i> Kembali</a>

	Setting Periode</h1>
</div>

<div class="row">
	
	<div class="col-md-7">

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
		      <h6 class="m-0 font-weight-bold text-primary">EDIT FORM</h6>
		    </div>
		    <div class="card-body">
		    	{!! Form::model($data, [
			          'method' =>'PUT',
			          'url' => [session('role').'/setting_time_hawasbid', $data->id]
			      ]) !!}
		    		@include('admin.hawasbid.setting_time.form',['submitButtonText' => 'Update'])
		    	{!! Form::close() !!}
		    </div>
		</div>
	</div>	

</div>

@endsection
