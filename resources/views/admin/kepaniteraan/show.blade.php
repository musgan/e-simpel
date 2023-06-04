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

<div class="card mb-4">
	<div class="card-body">
		<div class="row">
			<div class="form-group col-md-4">
				<label>Periode</label>
				<div class="form-control h-auto" readonly >{{CostumHelper::getNameMonth($secretariat->periode_bulan)}}  {{$secretariat->periode_tahun}}</div>
			</div>
			<div class="form-group col-md-4">
				<label>Penanggung Jawab Bidang</label>
				<div class="form-control h-auto" readonly >{{$secretariat->sector->nama}}</div>
			</div>
			<div class="form-group col-md-4">
				<label>Terkait Bidang</label>
				<div class="form-control h-auto" readonly >{{$indikator_sector->sector->nama}}</div>
			</div>
		</div>
		<div class="form-group">
			<label>Indikator</label>
			<div class="form-control h-auto" readonly="" style="min-height: 100px" >{!! ($secretariat->indikator)?str_replace("\n","<br />",$secretariat->indikator):'' !!}</div>
		</div>
		<div class="form-group">
			<label>Uraian Hawasbid</label>
			<div class="form-control h-auto" readonly="" style="min-height: 100px">
				{!! ($indikator_sector->uraian_hawasbid)?str_replace("\n","<br />",$indikator_sector->uraian_hawasbid):'' !!}
			</div>
		</div>
		<div class="form-group">
			<label>Uraian</label>
			<div class="form-control h-auto" readonly="" style="min-height: 100px" >{!! ($indikator_sector->uraian)?str_replace("\n","<br />",$indikator_sector->uraian):''  !!}</div>
		</div>
		<div class="form-group">
			<label>Evidence</label>
			<?php
			$files = Storage::allFiles($dir_evidence);
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

@endsection