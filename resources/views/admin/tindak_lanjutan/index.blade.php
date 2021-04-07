@extends('layouts.app_admin')
@extends('layouts.nav_admin')

@section('content')

<?php
$user  = \Auth::user();

?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
<h1 class="h3 mb-0 text-gray-800">{{ucfirst($sector->category)}}</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3"  style="background-color: #{{$sector->base_color}}">
      <h6 class="m-0 font-weight-bold"  style="color: {{CostumHelper::getContrastColor('#'.$sector->base_color)}}">Filter Data</h6>
    </div>
    <div class="card-body">
      <div class="col-md-12" style="margin-bottom: 20px;">
          <form class="form" action="{{ url(session('role').'/tindak-lanjutan/'.strtolower($sector->category).'/'.$sub_menu) }}" method="">
            <div class="row">
             

              <div class="form-group mx-sm-3 mb-3">
                {{Form::select('periode_bulan',$periode_bulan,null,['class'  => 'form-control', 'placeholder'  => '- Periode Bulan -'])}}  
              </div>

              <div class="form-group mx-sm-3 mb-3">
                {{Form::input('number','periode_tahun',null,['class'  => 'form-control', 'placeholder'  => 'Periode Tahun','min'  => 2018])}}  
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

@include('admin.tindak_lanjutan.tabs_option',['tab_select' => 1])

<div class="card shadow mb-4">
  <div class="card-header py-3" style="background-color: #{{$sector->base_color}}">
    <h6 class="m-0 font-weight-bold"  style="color: {{CostumHelper::getContrastColor('#'.$sector->base_color)}}">{{($sector->nama)}}</h6>
  </div>
  <div class="card-body">

    <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <!-- <th></th> -->
              <!-- <th>No</th> -->
              <th>No</th>
              <th>Periode</th>
              <th>Bidang</th>
              <th width="300px">Indikator</th>
              <th width="300px">Uraian</th>
              <th>Evidence</th>    
              <th width="120px;"></th>          
            </tr> 
        </thead>
        <tbody>
          @if($secretariats->total() == 0) 
          <tr>
            <!-- <th></th> -->
            <!-- <th>No</th> -->
            <th colspan="6"><center>DATA TIDAK ADA</center></th>          
          </tr> 
          @endif            
          <?php
          $start_num = ($secretariats->currentPage() - 1) * 15;
          $start_num += 1;
          // $start_num = 0;
          ?>
          @foreach($secretariats as $row)

          
          <tr>
            <td>{{$start_num++}}</td>
            <td>{{CostumHelper::getNameMonth($row->periode_bulan).' '.$row->periode_tahun}}</td>
            <td>{{$row->nama}}</td>
            <td>{!! $row->indikator !!}</td>
            <td>{!! $row->uraian !!}</td>
            <td>@if($row->evidence == 1) ada @else tidak ada @endif</td>
            <td>
              <p>
                {{date_format(date_create($row->created_at),"d M Y")}}
              </p>

              <a href="{{url(session('role').'/tindak-lanjutan/'.strtolower($sector->category).'/'.$sub_menu.'/'.$row->id)}}" class="btn btn-info btn-flat btn-sm"><i class="fa fa-folder-open" aria-hidden="true"></i> open</a>
              @if(CostumHelper::checkActionTindakLanjut($user->user_level_id, $row->periode_bulan, $row->periode_tahun) == 1)
              <a href="{{url(session('role').'/tindak-lanjutan/'.strtolower($sector->category).'/'.$sub_menu).'/'.$row->id.'/edit'}}" class="btn btn-primary btn-flat btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> uraian</a>
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

<!-- <div class="div-add">
	<form action="{{url(session('role').'/'.strtolower($sector->category).'/'.$sub_menu.'/create')}}">
		<button class="btn floatbtn btn-primary"><i class="fa fa fa-plus" aria-hidden="true"></i></button>
	</form>
</div> -->


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