@extends('layouts.app_admin')
@extends('layouts.nav_admin')

@section('content')

<section class="justify-content-between mb-4">
	<div class="row">
		<div class="col-sm-6">
			<h1 class="h3 mb-0 text-gray-800"><a href="{{url('setting_time_hawasbid')}}" class="text-decoration-none"><i class="mr-2 fa fa-chevron-left" aria-hidden="true"></i>Setting Periode</a></h1>
		</div>
		<div class="col-sm-6">
			<ol class="breadcrumb float-sm-right">
				<li class="breadcrumb-item"><a href="#">Setting Periode</a></li>
				<li class="breadcrumb-item active">@lang("form.button.edit.text")</li>
			</ol>
		</div>
	</div>
</section>


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

{!! Form::model($data, [
	  'method' =>'PUT',
	  'url' => [session('role').'/setting_time_hawasbid', $data->id]
  ]) !!}
	@include('admin.hawasbid.setting_time.form',['submitButtonText' => 'Update'])
	<div class="form-group">
		<a class="btn btn-secondary btn-flat mr-2" href="{{url('setting_time_hawasbid')}}">@lang("form.button.back.show")</a>
		<button class="btn btn-primary btn-flat">@lang("form.button.save.show")</button>
	</div>
{!! Form::close() !!}
@endsection
