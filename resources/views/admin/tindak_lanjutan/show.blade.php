@extends('layouts.app_admin')
@extends('layouts.nav_admin')

@section('content')

<?php

$user  = \Auth::user();
$action = CostumHelper::checkActionTindakLanjut($user->user_level_id, 
	$secretariat->periode_bulan, 
	$secretariat->periode_tahun);

?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
<h1 class="h3 mb-0 text-gray-800">{{ucfirst($sector->category)}}</h1>
</div>

<div class="action-btn btn-back">
  	
  	<a href="{{url(session('role').'/tindak-lanjutan/'.strtolower($sector->category).'/'.$sub_menu)}}" class="btn btn-info btn-flat btn-sm"><i class="fa fa-chevron-left" aria-hidden="true"></i> Kembali</a>
  	@if($action == 1)
  	<a href="{{url(session('role').'/tindak-lanjutan/'.strtolower($sector->category).'/'.$sub_menu).'/'.$secretariat->id.'/edit'}}" class="btn btn-primary btn-flat btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Uraian</a>
	@endif

</div>

<div class="row">
	<div class="col-md-8">
		<div class="card shadow mb-4">
		    <div class="card-header py-3">
		      <h6 class="m-0 font-weight-bold text-primary">{{$sector->nama}} <i class="fas fa-fw fa-chevron-right"></i> Show</h6>
		    </div>
		    <div class="card-body">
		    		
    			<p>Penanggung Jawab Bidang <b>{{$sector->nama}} </b></p>
    			<p> Terkait Bidang <b>{{$secretariat->nama}}</b></p>
    			<p> Periode <b>{{CostumHelper::getNameMonth($secretariat->periode_bulan)}}  {{$secretariat->periode_tahun}}</b></p>

    			<h5>Indikator</h5>
		    	<p>{!! $secretariat->indikator !!}</p>

		    	<h5>Uraian</h5>
		    	@if($secretariat->uraian)
		    	<p>{!! str_replace("\n","</p><p>",$secretariat->uraian)  !!}</p>
		    	@else
		    	<p>TIDAK ADA</p>
		    	@endif

		    	<h5>Evidence</h5>
		    	<?php
		    		$directory = "public/evidence/".$sub_menu."/".$secretariat->id;
		    		$files = Storage::allFiles($directory);
		    	?>
		    	<p>{!! count($files) !!} file</p>
		    	<ol class="evidence">
		    		@foreach($files as $val)
		    		<li>
		    			<?php
		    			$val_ = str_replace("public/", "storage/", $val);
		    			?>
				    	<a class="" href="{{asset($val_)}}">{!! basename($val_) !!}</a>
				    	
				    	@if($action == 1)
				    	<form class="delete_file" action="{{url(session('role').'/tindak-lanjutan/'.strtolower($sector->category).'/'.$sub_menu.'/delete_file/'.$secretariat->id.'?file='.$val)}}" method="post">
				    		<input type="hidden" name="_method" value="delete" />
				    		<button class="btn btn-danger btn-sm">Hapus</button>
					        {{ csrf_field() }}
					    </form>
					    @endif

				    </li>
				    @endforeach
				</ol>
			</div>
		</div>
	</div>
	
	@if($action == 1)
	<div class="col-md-4">
		<div class="card shadow mb-4">
		    <div class="card-header py-3">
		      <h6 class="m-0 font-weight-bold text-primary">Upload Evidence</h6>
		    </div>
		    <div class="card-body">

				{!! Form::open(['url' => session('role').'/tindak-lanjutan/'.strtolower($sector->category).'/'.$sub_menu.'/upload_evidence/'.$secretariat->id, 'class' => 'form-horizontal', 'files' => true]) !!}

    			<div class="form-group {{ $errors->has('evidence') ? 'has-error' : ''}}">
				    {!! Form::label('evidence', 'Evidence (pilih beberapa file)', ['class' => 'col-md-12 control-label']) !!}
				    
				    <div class="col-md-12">
				        {!! Form::file('evidence[]',['multiple' => 'multiple']) !!}
				        {!! $errors->first('evidence', '<p class="help-block">:message</p>') !!}
				    </div>
				</div>

				<div class="form-group">
				    <div class="col-md-12">
				        <button type="submit" class="btn btn-primary btn-md btn-flat">Upload</button>
				    </div>
				</div>
			   
			    {!! Form::close() !!}
		    </div>
		</div>
	</div>

	@endif

</div>

@endsection

@section('css')
<style type="text/css">
	.evidence li{
		padding: 10px 20px;
	}
	.evidence li .delete_file{
		color: red;
		font-weight: bold;
	}
</style>
@endsection

@section('js')
<script type="text/javascript">
	$(".delete_file").submit(function(){
		
		var conf = confirm("yakin, anda menghapus file ini ?");
		
		if(conf)
			return true;

		return false;
	});

	$("#delete").submit(function(){
		var conf = confirm("yakin, anda menghapus file ini ?");
		
		if(conf)
			return true;

		return false;
	});
</script>
@endsection