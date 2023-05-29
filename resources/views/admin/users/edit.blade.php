@extends('layouts.app_admin')
@extends('layouts.nav_admin')

@section('content')
	<section class="justify-content-between mb-4">
		<div class="row">
			<div class="col-sm-6">
				<h1 class="h3 mb-0 text-gray-800"><a href="{{url('/users')}}" class="mr-2  text-decoration-none"><i class="fa fa-chevron-left" aria-hidden="true"></i> Pengguna</a></h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Pengguna</a></li>
					<li class="breadcrumb-item active">@lang("form.button.edit.text")</li>
				</ol>
			</div>
		</div>
	</section>

<div class="card shadow mb-4">
    <div class="card-body">
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
	          'method' => 'PATCH',
	          'url' => [session('role').'/users', $send->id],
	          'class' => '',
	          'files' => true
	      ]) !!}

	    @include ('admin.users.form',['submitButtonText' => 'Update'])

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


	user_id = $("#user_id")
	function check_lvl_user(user_id){
		if(user_id == 10  || user_id == 4 || user_id == 5 || user_id == 6 || user_id == 7){
			$("#fsector_form").show();
			$("#sector_form").attr("required","required").show();
		}else{
			$("#fsector_form").hide();
			$("#sector_form").removeAttr("required");
		}
	}

	user_id.on('change',function(){
		check_lvl_user(user_id.val())		
	});

	check_lvl_user(user_id.val())
</script>
@endsection