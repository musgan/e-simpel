<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <?php

    function clean($string) {
       // $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

       return preg_replace('/[^A-Za-z0-9\-]/', ' ', $string); // Removes special chars.
    }

    $title = clean($menu);
  ?>

  <title>{{ucWords($title)}}</title>

  <link rel='icon' href='{{asset("assets/img/small_icon.png")}}'>

  <!-- Custom fonts for this template-->
  <link href="{{asset('template')}}/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">


  <link href="{{asset('template')}}/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="{{asset('library/font-awesome-4.7.0/css/font-awesome.min.css')}}">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="{{asset('template')}}/css/sb-admin-2.min.css" rel="stylesheet">

  <style type="text/css">
    .summernote p{
      margin-bottom: 5px;
    }
    .div-add{
      position: fixed;
      bottom: 30px;
      right: 30px;
    }
    table th{
      text-align: center !important;
    }
    .floatbtn, .floatbtn:hover{
      border-radius: 50%;
      color: white;
      width: 60px;
      height: 60px;
    }
    .btn-back{
      margin-bottom: 30px;
    }
    body, .table{
      color: #333333;
    }

    .nav-item ul{
      text-decoration: none;
      list-style-type: none;
      padding: 0px 0px;
      /*display: none;*/
    }
    
    .nav-item ul.active{
      display: block;
    }
    .text-gray-800{
      color: #02020A !important;
    }
    .btn-flat{
      border-radius: 0 !important;
    }
    .field-form .error{
      color: darkred;
      font-size: 12pt;
    }
    /*.nav-item:active ul {
      display: block;
    }*/
  </style>

  @yield('css','')

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    @yield('sidebar')
    
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content" style="padding-top: 20px">

        <!-- Begin Page Content -->
        <div class="container-fluid">
          @yield('content')
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.html">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="{{asset('template')}}/vendor/jquery/jquery.min.js"></script>
  <script src="{{asset('template')}}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{asset('template')}}/vendor/jquery-easing/jquery.easing.min.js"></script>

  <script src="{{asset('template')}}/vendor/datatables/jquery.dataTables.js"></script>
  <script src="{{asset('template')}}/vendor/datatables/dataTables.bootstrap4.js"></script>



  <!-- Page level plugins -->
  <script src="{{asset('template')}}/vendor/chart.js/Chart.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{asset('template')}}/js/sb-admin-2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
  @yield('js','')

</body>

</html>
