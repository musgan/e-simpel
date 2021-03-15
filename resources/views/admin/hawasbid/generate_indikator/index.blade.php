@extends('layouts.app_admin')
@extends('layouts.nav_admin')

@section('content')

<?php
  function getNameMonth($m){
      $bulan = "";
      switch ($m) {
        case "01":
          $bulan = "Januari";
          # code...
          break;
        case "02":
          $bulan = "Februari";
          # code...
          break;
        case "03":
          $bulan = "Maret";
          # code...
          break;
        case "04":
          $bulan = "April";
          # code...
          break;
        case "05":
          $bulan = "Mei";
          # code...
          break;
        case "06":
          $bulan = "Juni";
          # code...
          break;
        case "07":
          $bulan = "Juli";
          # code...
          break;
        case "08":
          $bulan = "Agustus";
          # code...
          break;
        case "09":
          $bulan = "September";
          # code...
          break;
        case "10":
          $bulan = "Oktober";
          # code...
          break;
        case "11":
          $bulan = "November";
          # code...
          break;
        case "12":
          $bulan = "Desember";
          # code...
          break;
        
        default:
          # code...
          break;
      }

      return $bulan;
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
      <div class="alert alert-{{session('status')[0]}}">
          {{ session('status')[1] }}
      </div>
  @endif

<div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Indikator</h6>
    </div>
    <div class="card-body">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>No</th>
            <th>Periode</th>
            <th>Total Indikator</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php
            $start_num = ($indikator_periode->currentPage() - 1) * 12;
            $start_num += 1;
            // $start_num = 0;
          ?>
          @foreach($indikator_periode as $row)
          <tr>
            <td>{{$start_num++}}</td>
            <td>{!! getNameMonth($row->periode_bulan).' '.$row->periode_tahun !!}</td>
            <td>{{$row->total}}</td>
            <td>
              <form class="delete" action="{{url(session('role').'/generate_indikator')}}" method="post">

                  
              
                <a href="#" class="btn btn-primary btn-sm" onclick="generate_indikator({!! $row->periode_bulan !!}, {!! $row->periode_tahun !!})">Generate Indikator</a>


                  <input type="hidden" name="periode_tahun" value="{{$row->periode_tahun}}">
                  <input type="hidden" name="periode_bulan" value="{{$row->periode_bulan}}">
                  
                  {{ csrf_field() }}
                  <input type="hidden" name="_method" value="delete" />
                  <button class="btn btn-sm btn-danger"> <i class="fa fa-trash" aria-hidden="true"></i> Hapus</button>

              </form>


            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <div style="float: right; padding: 0px 20px">
      {{ $indikator_periode->render("pagination::bootstrap-4") }}
      </div>

    </div>
</div>

@endsection

@section('js')
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog">
  
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        {!! Form::open(['url' => session('role').'/generate_indikator', 'class' => 'form', 'id' => 'form-generate']) !!}
        <input type="hidden" id="hide_periode_bulan" name="g_periode_bulan" value="">
        <input type="hidden" id="hide_periode_tahun" name="g_periode_tahun" value="">
        <h5 id="notif_generate"></h5>

        <div class="form-group {{ $errors->has('tahun') ? 'has-error' : ''}}">
    
          {!! Form::label('Periode', 'Periode', ['class' => 'col-md-2 control-label']) !!}
          
          <div class="col-md-12 row">
            
            <div class="col-md-6">
                {!! Form::select('periode_bulan', $bulan,null, ['class' => 'form-control','required' => 'required']) !!}
                {!! $errors->first('periode_bulan', '<p class="help-block">:message</p>') !!}
            </div>

            <div class="col-md-6">
                {!! Form::input('number','periode_tahun', null, ['class' => 'form-control','required' => 'required','placeholder'   => 'Tahun']) !!}
                {!! $errors->first('periode_tahun', '<p class="help-block">:message</p>') !!}
            </div>

          </div>
        </div>
        <div class="form-group col-md-12">
          <button type="submit" class="btn btn-primary btn-md btn-flat" id="btn_generate">Generate</button>
        </div>
        {!! Form::close() !!}

      </div>
      
    
  </div>
</div>

<script type="text/javascript">
  
  $(".delete").submit(function(){
    var conf = confirm("yakin, anda menghapus indikator periode terpilih  ?");
    
    if(conf)
      return true;

    return false;
  });

  function getNameMonth(m){
      bulan = "";
      switch (m) {
        case "01":
          bulan = "Januari"
          break
        case "02":
          bulan = "Februari"
          break
        case "03":
          bulan = "Maret"
          break;
        case "04":
          bulan = "April"
          break;
        case "05":
          bulan = "Mei"
          break;
        case "06":
          bulan = "Juni"
          break;
        case "07":
          bulan = "Juli"
          break;
        case "08":
          bulan = "Agustus"
          break;
        case "09":
          bulan = "September"
          break;
        case "10":
          bulan = "Oktober"
          break;
        case "11":
          bulan = "November"
          break;
        case "12":
          bulan = "Desember"
          break;
        
        default:
          break;
      }

      return bulan;
    }

  function generate_indikator(periode_bulan, periode_tahun){
    if(periode_bulan < 10)
      periode_bulan = "0"+periode_bulan
    $("#notif_generate").html('Generate Indikator Periode <b>'+getNameMonth(periode_bulan)+' '+periode_tahun+'</b> Ke Periode Yang akan ditentukan')
    $("#hide_periode_bulan").val(periode_bulan)
    $("#hide_periode_tahun").val(periode_tahun)

    $('#myModal').modal()

    $("#form-generate").submit(function(){
      $("#btn_generate").prop('disabled',true)
    })
  }
</script>
@endsection