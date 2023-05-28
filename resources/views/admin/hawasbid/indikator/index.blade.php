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
      
      <div class="col-md-12" style="margin-bottom: 20px;">
        <form class="form" action="{{ url('/hawasbid_indikator') }}" method="">
          <div class="row">
            <div class="form-group col-sm-4 mb-3">
              {{Form::select('evidence',[0 => 'Tidak Ada Evidence',1 => 'Ada Evidence'],null,['class'  => 'form-control', 'placeholder'  => '- Pilih Evidence -','id'  => 'f_evidence'])}}
            </div>
            <div class="form-group col-sm-4 mb-3">
              {{Form::select('periode_bulan',$periode_bulan,$bulan,['class'=>'form-control','placeholder'  => '- Periode Bulan -','id'  => 'f_periode_bulan'])}}
            </div>
            
            <div class="form-group col-sm-4 mb-3">
              {{Form::input('number','periode_tahun',$tahun,['class'=>'form-control','placeholder'  => 'Periode Tahun','id'  => 'f_periode_tahun'])}}
            </div>
          </div>
          <button type="submit" class="btn btn-primary mb-3">Tampilkan</button>

        </form>
      </div>

    </div>
</div>

<div class="card mb-4">
    <div class="card-body">

    	<table class="table table-hover" id="dataTable">
          	<thead>
	            <tr>
                    <th>No</th>
                    <th>Periode (PJ)</th>
	                <th>Indikator</th>
                    <th >Bidang Terkait</th>
                    <th></th>
                </tr>
          </thead>
          <tbody>
          </tbody>
      </table>
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

  const table = $("#dataTable").DataTable({
      processing: true,
      serverSide: true,
      ajax: {
          url: "{{url("hawasbid_indikator/gettable")}}",
          method: "post",
          data: {
              "periode_bulan"   : $("#f_periode_bulan").val(),
              "periode_tahun"   : $("#f_periode_tahun").val(),
              "evidence"        : $("#f_evidence").val()
          }
      },
      "autoWidth": false,
      columnDefs: [
          {data:"no",width: 50, orderable: false, searchable:false, className:"text-center", targets:0},
          {data:"periode", searchable: false,width: 100, orderable:false,targets: 1},
          {name: "indikator", data:"indikator",targets: 2},
          {name: "sector", data: "sector",width: 100, className:"text-wrap" ,data:"sector",searchable: true, orderable: false,targets: 3},
          {data:"action",width: 150,orderable:false, searchable:false, className:"text-center", targets: 4},
      ],
      order : [[2,'asc']]
  });
</script>

@endsection