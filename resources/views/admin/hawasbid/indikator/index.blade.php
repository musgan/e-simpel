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

 @if ($errors->any())
      <div class="row">
          <div class="col-md-7">
              <div class="alert alert-danger">
                  <button type="button" class="close" data-dismiss="alert"
                      aria-hidden="true">&times;</button>
                  Gagal Menambah Data.
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

<div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">FILTER DATA</h6>
    </div>
    <div class="card-body">
      
      <div class="row col-md-12" style="margin-bottom: 20px;">
        <form class="form" action="{{ url(session('role').'/hawasbid_indikator') }}" method="">
          <div class="row">
            <div class="form-group mx-sm-3 mb-3">
              {{Form::select('evidence',[0 => 'Tidak Ada Evidence',1 => 'Ada Evidence'],null,['class'  => 'form-control', 'placeholder'  => '- Pilih Evidence -'])}}  
            </div>
            <div class="form-group mx-sm-3 mb-3">
              {{Form::select('periode_bulan',$periode_bulan,$bulan,['class'=>'form-control','placeholder'  => '- Periode Bulan -'])}}
            </div>
            
            <div class="form-group mx-sm-3 mb-3">
              {{Form::input('number','periode_tahun',$tahun,['class'=>'form-control','placeholder'  => 'Periode Tahun'])}}
            </div>
            
            <div class="form-group mx-sm-3 mb-3">
              {{Form::text('search',null,['class'  => 'form-control', 'placeholder'  => 'search'])}}
            </div>
          </div>
          <button type="submit" class="btn btn-primary mb-3">Tampilkan</button>

        </form>
      </div>

    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">INDIKATOR</h6>
    </div>
    <div class="card-body">

    	<table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
          	<thead>
	            <tr>
	              <!-- <th></th> -->
	              <!-- <th>No</th> -->
	              <th>No</th> 
                <th>Periode (PJ)</th>     
	              <th>Indikator</th>
                <th width="150px">Bidang Terkait</th>
                <th width="120px;"></th>          
              </tr> 
          </thead>
          <tbody>
            @if($secretariats->total() == 0) 
            <tr>
              <!-- <th></th> -->
              <!-- <th>No</th> -->
              <th colspan="4"><center>DATA TIDAK ADA</center></th>          
            </tr> 
            @endif            
          	<?php
          	$start_num = ($secretariats->currentPage() - 1) * 15;
            $start_num += 1;
          	?>
          	@foreach($secretariats as $row)
          	<tr>
              <td>{{$start_num++}}</td>
              <td>{!! CostumHelper::getNameMonth($row->periode_bulan).' '.$row->periode_tahun !!} <br>
                <strong>{!! $row->nama !!}</strong></td>
              
              <td>{!! $row->indikator !!}</td>
              <td>{{array_key_exists($row->id,$bidang_terkait) ? implode(", ",$bidang_terkait[$row->id]) : '' }}</td>

              <td>
                {{date_format(date_create($row->created_at),"d M Y")}}
                
                @if($action == 1)
                <form class="delete" action="{{url(session('role').'/hawasbid_indikator'.'/'.$row->id)}}" method="post">

                  <a href="{{url(session('role').'/hawasbid_indikator'.'/'.$row->id)}}" class="btn btn-info btn-flat btn-sm"><i class="fa fa-folder-open" aria-hidden="true"></i> open</a>

                  <a href="{{url(session('role').'/hawasbid_indikator/'.$row->id.'/edit/')}}" class="btn btn-primary btn-flat btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a>
                  {{ csrf_field() }}
                  <input type="hidden" name="_method" value="delete" />
                  <button class="btn btn-sm btn-danger"> <i class="fa fa-trash" aria-hidden="true"></i> Hapus</button>

                </form>

                @else

                <a href="{{url(session('role').'/hawasbid_indikator'.'/'.$row->id)}}" class="btn btn-info btn-flat btn-sm"><i class="fa fa-folder-open" aria-hidden="true"></i> open</a>

                @endif
              </td>

            </tr>
            @endforeach
          </tbody>
      </table>
      <div style="float: right; padding: 0px 20px">
      {{ $secretariats->render("pagination::bootstrap-4") }}
      </div>
    </div>
</div>

<div class="card shadow mb-4">

    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">SUMMARY</h6>
    </div>
    <div class="card-body">
      <div class="row">
        <?php
          $no = 1;
          $total_indikator = 0;
        ?>
        @foreach($summary->chunk(5) as $row_chunk)  
          <div class="col-md-6">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Sektor</th>
                  <th>Jumlah Indikator</th>
                </tr>
              </thead>
              <tbody>
                
                @foreach($row_chunk as $row)
                <tr>
                  <td>{{$no++}}</td>
                  <td>{!! $row->nama !!}</td>
                  <td>{!! $row->total_indikator !!}</td>
                </tr>
                <?php $total_indikator += $row->total_indikator ?>
                @endforeach
              </tbody>
            </table>
          </div>
        @endforeach
        <h5 class="col-md-12 font-weight-bold">TOTAL INDIKATOR : {!! $total_indikator !!}</h5>
      </div>
    </div>
</div>

@if($action == 1)
<div class="div-add">
	<form action="{{url(session('role').'/hawasbid_indikator'.'/create')}}">
		<button class="btn floatbtn btn-primary"><i class="fa fa fa-plus" aria-hidden="true"></i></button>
	</form>
</div>

@endif


@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/daterangepicker.css')}}" />
<style type="text/css">
  a.btn{
    margin-bottom: 10px;
  }
</style>
@endsection

@section('js')
<script type="text/javascript" src="{{asset('js/moment.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/daterangepicker.min.js')}}"></script>

<script type="text/javascript">

  $('#date').daterangepicker({
      autoUpdateInput: false,
      locale: {
          cancelLabel: 'Clear'
      }
  });

  $('#date').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
      $('input[name="date_start"]').val(picker.startDate.format('YYYY-MM-DD'))
      $('input[name="date_end"]').val(picker.endDate.format('YYYY-MM-DD'))
  });

  $(".delete").submit(function(){
    var conf = confirm("yakin, anda menghapus file ini ?");
    
    if(conf)
      return true;

    return false;
  });

</script>

@endsection