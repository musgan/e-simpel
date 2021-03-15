@extends('layouts.app_admin')
@extends('layouts.nav_admin')

@section('content')

<?php
  $user = \Auth::user();
  $action = CostumHelper::checkActionTindakLanjut($user->user_level_id, $bulan, $tahun);
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
<h1 class="h3 mb-0 text-gray-800">{{ucfirst($sector->category)}}</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Filter Data</h6>
    </div>
    <div class="card-body">
      <div class="col-md-12" style="margin-bottom: 20px;">
          <form class="form" action="{{ url(session('role').'/tindak-lanjutan/'.strtolower($sector->category).'/'.$sub_menu.'/dokumentasi_rapat') }}" method="">
            <label class="control-label">Periode</label>
            <div class="row">
              <div class="form-group mx-sm-3 mb-3">
                {{Form::select('periode_bulan',$periode_bulan,null,['class'  => 'form-control', 'placeholder'  => '- Periode Bulan -'])}}  
              </div>

              <div class="form-group mx-sm-3 mb-3">
                {{Form::input('number','periode_tahun',null,['class'  => 'form-control', 'placeholder'  => 'Periode Tahun','min'  => 2018])}}  
              </div>

            </div>

            <button type="submit" class="btn btn-primary mb-3">Tampilkan</button>
          </form>
        </div> 
    </div>
  </div>

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

<div class="row col-md-8">
  
@include('admin.tindak_lanjutan.tabs_option',['tab_select' => 2])

</div>
<div class="row">
<div class="col-md-7">
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">{{($sector->nama)}}</h6>
    </div>
    <div class="card-body">
      
      @if($tahun == "" || $bulan == "")
      <div class="alert alert-warning" role="alert">
        <h6>Silahkan Anda Melakukan Filter Periode Tahun dan Bulan Terlebih Dahulu </h6>
      </div>
      @else
        @if($total_indikator > 0)
        
        <div class="alert alert-success" role="alert">
          <h4>Periode {{CostumHelper::getNameMonth($bulan).' '.$tahun}}</h4>
        </div>

        <?php
            $directory = "public/evidence/".$sub_menu."/dokumentasi_rapat/".$tahun.'-'.$bulan.'/';
            $pth_files = Storage::allfiles($directory);
            $files = array();
            
            foreach ($pth_files as $val) {
              # code...
              $explod_pth = explode("_", basename($val));
              $year_ar = str_split($explod_pth[0], 4);
              $dm = str_split($year_ar[1],2);
              $dt = $year_ar[0].'-'.$dm[0].'-'.$dm[1];
              $dt = date('d M Y',strtotime($dt));

              // dd($dt);
              // dd($explod_pth);
              $add_link = $val;
              $add_link = (str_replace("public/", "storage/", $add_link));
              if(array_key_exists($dt, $files)) {
                // dd($files);

                array_push($files[$dt] [$explod_pth[1]], $add_link);

              }else{
                // dd($files);
                $files[$dt]['notulen'] = array();
                $files[$dt]['absensi'] = array();
                $files[$dt]['foto'] = array();

                array_push($files[$dt][$explod_pth[1]], $add_link);
              }
            }

            // dd($files);            
          ?>
        <ul id="myUL">
          @foreach($files as $key => $val)
          <li><span class="caret caret-down">{{$key}}</span>
            <ul class="nested active">
              
              @foreach($val as $key_dok => $val_dok)

              @if(count($val_dok) > 0)
              <li>
                <span class="caret caret-down">{{ucfirst($key_dok)}}</span>
                <ul class="nested active">
                  @foreach($val_dok as $v)
                    <?php

                      $nama = explode("_",basename($v)); 
                      unset($nama[0]);
                      $nama = implode($nama);
                    ?>
                    <li>
                      @if($action == 1)
                      <form class="delete" action="{{url()->current()}}" method="post">
                        <input type="hidden" name="bulan" value="{{$bulan}}" />
                        <input type="hidden" name="tahun" value="{{$tahun}}" />
                        <input type="hidden" name="path" value="{{$v}}" />
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="delete" />
                        <button class="btn btn-sm btn-danger"> <i class="fa fa-trash" aria-hidden="true"></i></button> <a href="{{asset($v)}}" target="_blank">{{ $nama  }} </a></li>
                      </form>
                      @else
                      <a href="{{asset($v)}}" target="_blank">{{$nama }} </a></li>
                      @endif
                    
                  @endforeach
                </ul>
              </li>
              @endif              

              @endforeach

              
            </ul>
          </li>
          @endforeach  
        </ul>

        @else
          <div class="alert alert-warning" role="alert">
            <h6>Indikator untuk periode terpilih belum tersedia</h6>
          </div>
        @endif

      @endif      

    </div>
  </div>

</div>

<div class="col-md-5">
  
  @if($action == 1 && $total_indikator > 0)
  <div class="card shadow mb-5">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Upload Dokumentasi</h6>
    </div>
    <div class="card-body">

      <h5>Tanggal {{date('d').' '. CostumHelper::getNameMonth(date('m')).' '.date('Y')}}</h5>

      <div class="action-btn btn-back">
          <a href="{{url(session('role').'/tindak-lanjutan/'.strtolower($sector->category).'/'.$sub_menu)}}" class="btn btn-danger btn-flat btn-sm"><i class="fa fa-chevron-left" aria-hidden="true"></i> Kembali</a>
      </div>

      {!! Form::open(['url' => url()->current(), 'class' => 'form-horizontal', 'files' => true]) !!}

      @include ('admin.kepaniteraan.dokumentasi_rapat.form');

      {!! Form::close() !!}

    </div>
  </div>
  @endif  

</div>

</div>

@endsection

@section('css')

<style type="text/css">
  .delete{
    margin-bottom: 5px;
  }
ul, #myUL {
  list-style-type: none;
}

#myUL {
  margin: 0;
  padding: 0;
}

.caret {
  cursor: pointer;
  -webkit-user-select: none; /* Safari 3.1+ */
  -moz-user-select: none; /* Firefox 2+ */
  -ms-user-select: none; /* IE 10+ */
  user-select: none;
}

.caret::before {
  content: "\25B6";
  color: black;
  display: inline-block;
  margin-right: 6px;
}

.caret-down::before {
  -ms-transform: rotate(90deg); /* IE 9 */
  -webkit-transform: rotate(90deg); /* Safari */'
  transform: rotate(90deg);  
}

.nested {
  display: none;
}

.active {
  display: block;
}

</style>

@endsection

@section('js')

<script type="text/javascript">


  $(".delete").submit(function(){
    var conf = confirm("yakin, anda menghapus file ini ?");
    
    if(conf)
      return true;

    return false;
  });


  var toggler = document.getElementsByClassName("caret");
  var i;

  for (i = 0; i < toggler.length; i++) {
    toggler[i].addEventListener("click", function() {
      this.parentElement.querySelector(".nested").classList.toggle("active");
      this.classList.toggle("caret-down");
    });
  }

  $('#notulen').change(function(event){
    // console.log('ccc')
    files = event.target.files
    catatan = "";
    for (i=0; i< files.length;i++){
      if(files[i].name.length >150){
        catatan += "\n"+files[i].name+'('+files[i].name.length+')'
      }
    }
    if(catatan.length != ""){
      catatan = "Periksa kembali nama file anda. Maksimal 150 Karakter"+catatan
      $('#notulen').val(null)
      alert(catatan)
    }
  });

  $('#absensi').change(function(event){
    // console.log('ccc')
    files = event.target.files
    catatan = "";
    for (i=0; i< files.length;i++){
      if(files[i].name.length >150){
        catatan += "\n"+files[i].name+'('+files[i].name.length+')'
      }
    }
    if(catatan.length != ""){
      catatan = "Periksa kembali nama file anda. Maksimal 150 Karakter"+catatan
      $('#absensi').val(null)
      alert(catatan)
    }
  });

  $('#foto').change(function(event){
    // console.log('ccc')
    files = event.target.files
    catatan = "";
    for (i=0; i< files.length;i++){
      if(files[i].name.length >150){
        catatan += "\n"+files[i].name+'('+files[i].name.length+')'
      }
    }
    if(catatan.length != ""){
      catatan = "Periksa kembali nama file anda. Maksimal 150 Karakter"+catatan
      $('#foto').val(null)
      alert(catatan)
    }
  });
</script>
@endsection