@extends('layouts.app_admin')
@extends('layouts.nav_admin')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">{{ucfirst($sector->category)}}</h1>
</div>

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
@if (session('status'))
	<div class="alert alert-success">
		{{ session('status') }}
	</div>
@endif
{!! Form::model($send, [
	  'method' =>'PUT',
	  'url' => ['tindak-lanjutan/'.strtolower($sector->category).'/'.$sub_menu, $send->id],
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