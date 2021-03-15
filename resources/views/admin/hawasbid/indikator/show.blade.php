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

<div class="d-sm-flex align-items-center justify-content-between mb-4">
<h1 class="h3 mb-0 text-gray-800">Hawasbid</h1>
</div>

@if($user->user_level_id == 1)
<div class="action-btn btn-back">
  	<a href="{{url(session('role').'/hawasbid_indikator')}}" class="btn btn-info btn-flat btn-sm"><i class="fa fa-chevron-left" aria-hidden="true"></i> Kembali</a>
</div>
@endif

<div class="card shadow mb-4">
    <div class="card-header py-3">
      <h4 class="m-0 font-weight-bold text-primary">Indikator</h4>
    </div>
    <div class="card-body">
    	<div class="row">
    		<div class="col-md-12">
          <h5>Penanggung Jawab Bidang Adalah {{ (isset($secretariat->nama)) ? $secretariat->nama : 'Belum Ditentukan'}} </h5>
    			<h5>Periode {{CostumHelper::getNameMonth($secretariat->periode_bulan)." ".$secretariat->periode_tahun}}</h5>
    			<p>{!! $secretariat->indikator !!}</p>
    		</div>
    	</div>

    </div>
</div>

@foreach($ev_sector as $ev_val)
<div class="card shadow mb-4">
    <div class="card-header py-3">
      <div class="row">
      		<div class="col-md-10">
      			<h4 class="m-0 font-weight-bold text-primary">{{$ev_val->nama}}</h4>		
      		</div>
      		
          @if($action == 1)
          <div class="col-md-2"><a class="float-right btn btn-flat btn-info" href="{{url(session('role').'/pengawas-bidang'.strtolower('/'.$ev_val->category.'/'.$ev_val->nama.'/'.$ev_val->id.'/edit'))}}" target="_blank"><i class="fa fa-pencil" aria-hidden="true"></i></a>
          </div>
          @endif

      </div>
    </div>
    <div class="card-body">
    	<div class="row">
    		<div class="col-md-8">	
		    	<h5>Uraian</h5>
		    	@if($ev_val->uraian)
		    	<p>{!! str_replace("\n","<p>",$ev_val->uraian)  !!}</p>
		    	@else
		    	<p>TIDAK ADA</p>
		    	@endif
		    	
    		</div>

    		<div class="col-md-4">
    			<h5>Evidence</h5>
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
				    	
              @if($action == 1)
              <form class="delete_file" action="{{url(session('role').'/hawasbid_indikator'.'/delete_file/'.$secretariat->id.'?file='.$val)}}" method="post">
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
</div>
@endforeach

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