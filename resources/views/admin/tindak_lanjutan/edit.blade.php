@extends('layouts.app_admin')
@extends('layouts.nav_admin')

@section('content')
<section class="justify-content-between mb-4">
	<div class="row">
		<div class="col-sm-6">
			<h1 class="h3 mb-0 text-gray-800"><a href="{{url($path_url)}}" class="text-decoration-none"><i class="mr-2 fa fa-chevron-left" aria-hidden="true"></i>{{$sector->nama}}</a></h1>
		</div>
		<div class="col-sm-6">
			<ol class="breadcrumb float-sm-right">
				<li class="breadcrumb-item"><a href="#">{{$sector->nama}}</a></li>
				<li class="breadcrumb-item active">@lang('form.button.view.text')</li>
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
				Gagal memperbaharui Data.
				<br>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</div>
		</div>
	</div>
@endif
@include("message")
{!! Form::model(null, [
	  'method' =>'PUT',
	  'url' => [$path_url, $indikator_sector->id],
	  'class' => 'form-horizontal',
	  'files' => true
  ]) !!}

@include ('admin.tindak_lanjutan.form',['submitButtonText' => 'Update'])

<div class="form-group">
	<a class="btn btn-secondary btn-flat mr-2" href="{{url($path_url)}}">@lang("form.button.back.show")</a>
	<button class="btn btn-primary btn-flat">@lang("form.button.save.show")</button>
</div>

{!! Form::close() !!}

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