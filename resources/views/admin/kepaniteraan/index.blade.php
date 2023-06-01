@extends('layouts.app_admin')
@extends('layouts.nav_admin')

@section('content')

  <?php
    $user = \Auth::user();
  ?>

  <div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">{{$sector->nama}}</h1>
  </div>

  <div class="card  mb-3" >
    <div class="card-body" >

      <form class="form" action="{{ url(session('role').'/pengawas-bidang/'.strtolower($sector->category).'/'.$sub_menu) }}" method="">
        <div class="row">
          <div class="form-group col-sm-4 mb-3">
            {{Form::select('evidence',[0 => 'Tidak Ada Evidence',1 => 'Ada Evidence'],null,['id' => 'f_evidence','class'  => 'form-control', 'placeholder'  => '- Pilih Evidence -'])}}
          </div>

          <div class="form-group col-sm-4 mb-3">
            {{Form::select('periode_bulan',$periode_bulan,$bulan,['id'=> 'f_periode_bulan' ,'class'  => 'form-control', 'placeholder'  => '- Periode Bulan -'])}}
          </div>

          <div class="form-group col-sm-4 mb-3">
            {{Form::input('number','periode_tahun',$tahun,['id'=>'f_periode_tahun','class'  => 'form-control', 'placeholder'  => 'Periode Tahun','min'  => 2018])}}
          </div>
        </div>

        <button type="submit" class="btn btn-success mb-3">Filter</button>
      </form>
    </div>
  </div>
  @if (session('status'))
    <div class="alert alert-success mb-3">
      {{ session('status') }}
    </div>
  @endif

  <div class="form-group text-right mb-3">
    <button id="btn-form-dokumentasi-rapat" type="button" class="btn btn-info btn-flat mr-2 mb-1">@lang("form.button.add.show") Dokumentasi Rapat</button>
  </div>

  <div class="card mb-3">
    <div class="card-body">
      <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No</th>
                <th>Indikator</th>
                <th>Uraian</th>
                <th>Evidence</th>
                <th>Tanggal dibuat</th>
                <th></th>
              </tr>
          </thead>
          <tbody></tbody>
      </table>
    </div>
  </div>
  <div class="card mb-3">
    <div class="card-header">
      <h5>Dokumentasi Rapat</h5>
    </div>
    <div class="card-body">
      <table class="table table-hover table-striped" id="tableDokumentasiRapat">
        <thead>
        <tr>
          <th>Nama Dokumen</th>
          <th>Jenis Dokumen</th>
          <th>Tanggal Dibuat</th>
          <th></th>
        </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>

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
  @include("admin.dokumentasi-rapat.modal-form",[
      'dict_periode_of_month'   => $periode_bulan
])
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

    $(document).on('submit', ".delete", function (e){
      if(confirm("apakah anda ingin menghapus data ini ?"))
        return true;
      return false;
    })

    const table = $("#dataTable").DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: "{{url($path_url."/gettable")}}",
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
        {name: "indikator", data:"indikator",targets: 1, width: 350},
        {name: "uraian", data: "uraian", className:"text-wrap" ,searchable: false, orderable: false,targets: 2},
        {name: "evidence", data: "evidence",width: 50, className:"text-wrap" ,searchable: false, orderable: false,targets: 3},
        {name: "id", data: "created_at",width: 100, searchable: false, orderable: false,targets: 4},
        {data:"action",width: 80,orderable:false, searchable:false, className:"text-center", targets: 5},
      ],
      order : [[4,'asc']]
    });

    const tableDokumentasiRapat = $("#tableDokumentasiRapat").DataTable({
      processing: true,
      // serverSide: true,
      ajax: {
        url: "{{url($path_dokumentasi_rapat_url."/gettable")}}",
        method: "post",
        data: {
          "periode_bulan": $("#f_periode_bulan").val(),
          "periode_tahun": $("#f_periode_tahun").val(),
          "kategori_dokumentasi": "hawasbid"
        }
      },
      ordering : false,
      autoWidth: false,
      columnDefs: [
        {data:"file",  targets:0},
        {data:"category",  targets:1},
        {data:"created_at",  targets:2},
        {data:"action",width: 80, className:"text-center", targets:3},
      ]
    });
    $("#btn-form-dokumentasi-rapat").on('click', function(){
      const modal_dokumentasi_rapat = $("#modal-form-dokumentasi-rapat")
      const  form_dokumentasi_rapat = $("#form-dokumentasi-rapat")
      modal_dokumentasi_rapat.modal()
      const action_dokumentasi_rapat = "{{url($path_dokumentasi_rapat_url)}}"
      form_dokumentasi_rapat.attr('action',action_dokumentasi_rapat)
      $("#notulensi",modal_dokumentasi_rapat).val(null)
      $("#absensi",modal_dokumentasi_rapat).val(null)
      $("#foto",modal_dokumentasi_rapat).val(null)
      $("#kategori_dokumentasi",modal_dokumentasi_rapat).val("hawasbid")
    })

  </script>

@endsection