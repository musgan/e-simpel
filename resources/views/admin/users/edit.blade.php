@extends('layouts.app_admin')
@extends('layouts.nav_admin')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">Pengguna</h1>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Update</h6>
    </div>
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

	    <div class="action-btn btn-back">
	      	<a href="{{url(session('role').'/users')}}" class="btn btn-danger btn-flat btn-sm"><i class="fa fa-chevron-left" aria-hidden="true"></i> Kembali</a>
	    </div>

	    {!! Form::model($send, [
	          'method' => 'PATCH',
	          'url' => [session('role').'/users', $send->id],
	          'class' => 'form-horizontal',
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
		if(user_id == 10  || user_id == 4 || user_id == 5){
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