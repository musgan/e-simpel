@extends('layouts.app_admin')
@extends('layouts.nav_admin')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">Akun Saya</h1>
</div>

<div class="row">
	<div class="col-md-6">
		<div  class="card shadow mb-4">
		    <div class="card-header py-3">
		      <h6 class="m-0 font-weight-bold text-primary">Edit Data</h6>
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

			    <div class="row">
			    	<div class="col-md-12">
					    {!! Form::model($send, [
					    	  'id'	=> 'send',
					          'method' => 'PATCH',
					          'url' => [session('role').'/akun-saya', $send->id],
					          'class' => 'form-horizontal',
					          'files' => false
					      ]) !!}

					    @include ('admin.my_account.form',['submitButtonText' => 'Update'])

					    {!! Form::close() !!}
				   	</div>

				    

			    </div>

		    </div>
		</div>
	</div>
	<div class="col-md-6">
		<div  class=" card shadow mb-4">
		    <div class="card-header py-3">
		      <h6 class="m-0 font-weight-bold text-primary">Atur Foto</h6>
		    </div>
		    <div class="card-body">
		    	<?php
		    	$url_image = asset('assets/croppie/demo/cat.jpg');
		    	if($send->foto){
			    	if(Storage::exists("public/profil_user/".$send->foto)){
			    		$url_image = asset(Storage::url("public/profil_user/".$send->foto));
			    	}
			    }
			    ?>
			    <div class="form-group col-md-12 row">
			        <input id="foto" type="file" name="foto"  accept="image/jpeg" class="form-control" style="margin-bottom: 10px; " />

			        <div style="height: 250px; width: 100%">
			            <img id="crop_foto" class="crop_foto" src="{{$url_image}}" style="height: 300px;">
			        </div>
			    </div>
			    <div class="clearfix"></div>

			    <button style="margin-top: 30px" class="btn btn-primary btn-md" id="setProfil"><i class="fa fa-user-circle" aria-hidden="true"></i> Atur Sebagai Foto</button>
			</div>
		</div>
	</div>
</div>
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/croppie/croppie.css')}}">
@endsection

@section('js')
<script src="{{asset('assets/croppie/croppie.min.js')}}" ></script>
<script type="text/javascript">

	var croppie = $('.crop_foto').croppie({
		viewport: {
	        width: 200,
	        height: 200
	    }
	})
	console.log(croppie)

	show_password = $(".password-hide")
	show_password.hide()
	$(".pass").val('')

	psw_opt = $(".psw-opt")
	$('input[name=optradio]').change(function(e){
		val = $( 'input[name=optradio]:checked' ).val()
		if(val == 1){
			show_password.show(100)
		}else{
			show_password.hide(100)
			$(".pass").val('')
		}
	});

	$("#foto").on('change',function(event){
		var image = event.target.files[0]
		url_image = URL.createObjectURL(image)
		croppie.croppie('bind', {
		    url: url_image
		});

		// console.log(image)
		// $("#crop_foto").attr('src',url_image)
	});

	$("#setProfil").on('click', function(){
		croppie.croppie('result','blob').then(function(blob){
			console.log(blob)
			upload(blob)
		})
	})

	function upload(blob_image){
		var fd = new FormData();
		fd.append('name', 'profil.jpg');
		fd.append('data', blob_image);
		fd.append('_token',"{{csrf_token()}}")
		$.ajax({
		    type: 'POST',
		    url: "{{url(session('role').'/akun-saya/update-profil')}}",
		    data: fd,
		    processData: false,
		    contentType: false
		}).done(function(data) {
		       alert(data['message'])
		});
	}

	$("#send").submit(function(e){

		val = $( 'input[name=optradio]:checked' ).val()
		psw = $('input[name = password]').val()
		psw_conf = $('input[name = password_confirmation]').val()

		if(val == 1){
			if(psw.length == 0){
				alert("isi kolom password")
				return false
			}else{
				if(psw.length <6){
					
					alert("password minimal 6 karakter")
					return false
				}else{
					if(psw != psw_conf){
						alert("password tidak sama dengan kolom ketik ulang password")	
						return false
					}else{
						return true
					}
				}
			}
		}else{
			return true
		}

	})

</script>
@endsection
