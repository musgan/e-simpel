@extends('layouts.app_admin')
@extends('layouts.nav_admin')

@section('content')

<?php
$user = \Auth::user();
$action = CostumHelper::checkActionHawasbid($user->user_level_id, $secretariat->periode_bulan, $secretariat->periode_tahun);

?>
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
<div class="text-right form-group mb-3">
	@if($action == 1)
		<a href="{{url('/pengawas-bidang/'.strtolower($sector->category).'/'.$sub_menu).'/'.$secretariat->id.'/edit'}}" class="btn btn-warning btn-flat btn-md"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Uraian</a>
	@endif
</div>

<div class="card mb-4">
	<div class="card-body">
		<div class="row">
			<div class="form-group col-md-6">
				<label>Periode</label>
				<div class="form-control h-auto" readonly >{{CostumHelper::getNameMonth($secretariat->periode_bulan)}}  {{$secretariat->periode_tahun}}</div>
			</div>
			<div class="form-group col-md-6">
				<label>Penanggung Jawab Bidang</label>
				<div class="form-control h-auto" readonly >{{$sector->nama}}</div>
			</div>
		</div>

		<div class="form-group">
			<label>Terkait Bidang</label>
			<div class="form-control h-auto" readonly >{{$secretariat->nama}}</div>
		</div>

		<div class="form-group">
			<label>Indikator</label>
			<div class="form-control h-auto" readonly >{!! $secretariat->indikator !!}</div>
		</div>
		<div class="form-group">
			<label>Uraian</label>
			<div class="form-control h-auto" readonly >{!! ($secretariat->uraian)?str_replace("\n","<br />",$secretariat->uraian):'Tidak ada'  !!}</div>
		</div>
		<div class="form-group">
			<label>Evidence</label>
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
							<form class="delete_file" action="{{url(session('role').'/pengawas-bidang/'.strtolower($sector->category).'/'.$sub_menu.'/delete_file/'.$secretariat->id.'?file='.$val)}}" method="post">
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
	<div class="card mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Upload Evidence</h6>
		</div>
		<div class="card-body">
			<h4>Upload Evidence FIles</h4>
			{!! Form::open(['url' => session('role').'/pengawas-bidang/'.strtolower($sector->category).'/'.$sub_menu.'/upload_evidence/'.$secretariat->id, 'class' => 'form-horizontal', 'files' => true]) !!}

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
@endif


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