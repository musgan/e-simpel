@extends('layouts.app_admin')
@extends('layouts.nav_admin')

@section('content')

<?php
$user = \Auth::user();
$action = 0;

if($user->user_level_id == 1){
  $action = 1;
}

?>
@if($user->user_level->alias == "admin")
<section class="justify-content-between mb-4">
	<div class="row">
		<div class="col-sm-6">
			<h1 class="h3 mb-0 text-gray-800"><a href="{{url('hawasbid_indikator')}}" class="text-decoration-none"><i class="mr-2 fa fa-chevron-left" aria-hidden="true"></i>Indikator</a></h1>
		</div>
		<div class="col-sm-6">
			<ol class="breadcrumb float-sm-right">
				<li class="breadcrumb-item"><a href="#">Indikator</a></li>
				<li class="breadcrumb-item active">@lang("form.button.edit.text")</li>
			</ol>
		</div>
	</div>
</section>
@else
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h4 class="h3 mb-0 text-gray-800">Indikator</h4>
	</div>
@endif

<div class="card shadow mb-4">
    <div class="card-header py-3">
      <h5 class="">Indikator</h5>
    </div>
    <div class="card-body">
    	<div class="row">
			<div class="form-group col-md-6">
				<label>Periode</label>
				<div class="form-control h-auto" readonly="">{{CostumHelper::getNameMonth($secretariat->periode_bulan)." ".$secretariat->periode_tahun}}</div>
			</div>
			<div class="form-group col-md-6">
				<label>Penanggung jawab bidang</label>
				<div class="form-control h-auto" readonly="">{{$secretariat->nama}}</div>
			</div>
		</div>
		<div class="form-group">
			<label>Indikator</label>
			<div class="form-control h-auto" style="min-height: 100px" readonly="">
				{!! ($secretariat->indikator)?str_replace("\n","<br />",$secretariat->indikator):'' !!}
			</div>
		</div>
    </div>
</div>

@foreach($ev_sector as $ev_val)
<div class="card shadow mb-4">
    <div class="card-header">
		<h5 class="">{{$ev_val->nama}}</h5>
	</div>
    <div class="card-body">
		<div class="form-group">
			<label>Uraian Hawasbid</label>
			<div class="form-control h-auto" readonly="" style="min-height: 100px">
				{!! ($ev_val->uraian_hawasbid)?str_replace("\n","<br />",$ev_val->uraian_hawasbid):'' !!}
			</div>
		</div>
		<div class="form-group">
			<label>Uraian tidak lanjut</label>
			<div class="form-control h-auto" readonly="" style="min-height: 100px">
				{!! ($ev_val->uraian)?str_replace("\n","<br />",$ev_val->uraian):'' !!}
			</div>
		</div>
		<div class="form-group">
			<label>Evidence</label>
				<?php
				$directory = "public/evidence/".$ev_val->alias."/".$ev_val->id;
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
					</li>
				@endforeach
			</ol>
		</div>
    </div>
</div>
@endforeach

@endsection