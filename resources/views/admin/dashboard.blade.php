@extends('layouts.app_admin')
@extends('layouts.nav_admin')

@section('content')
<?php
  function decode_arr($data) {
      return unserialize(base64_decode($data));
  }


  $url_image = "";

  if($user->foto){
    if(Storage::exists("public/profil_user/".$user->foto)){
      $url_image = asset(Storage::url("public/profil_user/".$user->foto));
    }
  }

          
?>
<!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
  </div>

  <!-- Content Row -->
  <div class="row">
    <div class="col-xl-12 col-md-12 mb-12">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row">
            @if($url_image != "")
            <div class="col-md-2">
              <img src="{{$url_image}}" class="img-thumbnail">
            </div>
            @endif
            
            <div class="col-md-8">
              <h3>SELAMAT DATANG ({!! strtoupper($user_level->nama) !!})</h3>
              <h5>{{$user->name}}</h5>
              <h5>{{$user->nip}}</h5>
              @if($user->user_level_id >= 10)
                <h5>Domain wilayah saya</h5>
                <p>{!! implode(', ',$domain_sector) !!}</p>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  
  <div class="row">
    <div class="col-xl-6 col-md-6 mb-4 ">
      <div class="card border-left-danger shadow h-100 py-2" style="width: 100%;">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-md font-weight-bold text-danger text-uppercase mb-1">Performa Bidang
              </div>
            </div>
          </div>

          <canvas id="myChart3"></canvas>

        </div>
      </div>
    </div>

    <div class="col-xl-6 col-md-6 mb-4 ">
      <div class="card border-left-danger shadow h-100 py-2" style="width: 100%;">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-md font-weight-bold text-danger text-uppercase mb-1">Performa Tindak Lanjut
              </div>
            </div>
          </div>

          <canvas id="myChart2"></canvas>

        </div>
      </div>
    </div>

  </div>

  <div class="row">
    
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="card border-left-danger shadow h-100 py-2" style="width: 100%;">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-md font-weight-bold text-danger text-uppercase mb-1">Chart Evidence
              </div>
            </div>
          </div>

          <canvas id="myChart"></canvas>

        </div>
      </div>
    </div>

  </div>

  

  
@endsection

@section('css')
<style type="text/css">
  .mb-12, .mb-6{
    margin-bottom: 1.5rem!important;
  }
</style>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script type="text/javascript">
  var opt = {
    events: false,
    tooltips: {
        enabled: false
    },
    hover: {
        animationDuration: 0
    },
    animation: {
        duration: 1,
        onComplete: function () {
            var chartInstance = this.chart,
                ctx = chartInstance.ctx;
            ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
            ctx.textAlign = 'center';
            ctx.textBaseline = 'bottom';

            this.data.datasets.forEach(function (dataset, i) {
                var meta = chartInstance.controller.getDatasetMeta(i);
                meta.data.forEach(function (bar, index) {
                    var data = dataset.data[index];                            
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                });
            });
        }
    },
    legend: {
        display: true,
        align : 'left',
        position : 'bottom'
    },
    scales: {
       yAxes: [{
           ticks: {
               beginAtZero: true,
               userCallback: function(label, index, labels) {
                   // when the floored value is the same as the value we have a whole number
                   if (Math.floor(label) === label) {
                       return label;
                   }

               },
           }
       }],
   },

  };

  var ctx = document.getElementById('myChart').getContext('2d');
  var chart = new Chart(ctx, {
      // The type of chart we want to create
      type: 'bar',
      data: {!! $data_chart !!},
      
      options: {

        legend: {
            display: true,
            align : 'left',
            position : 'bottom'
        },

      },
  });

  var ctx2 = document.getElementById('myChart2').getContext('2d');
  var chart = new Chart(ctx2, {
      // The type of chart we want to create
      type: 'bar',
      data: {!! $tl_chart !!},
      
      options: {

        legend: {
            display: true,
            align : 'left',
            position : 'bottom'
        },

      },
  });

  var ctx3 = document.getElementById('myChart3').getContext('2d');
  var chart = new Chart(ctx3, {
      // The type of chart we want to create
      type: 'bar',
      data: {!! $bidang_chart !!},
      
      options: {

        legend: {
            display: true,
            align : 'left',
            position : 'bottom'
        },

      },
  });
</script>
@endsection