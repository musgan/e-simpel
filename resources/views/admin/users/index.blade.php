@extends('layouts.app_admin')
@extends('layouts.nav_admin')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">Pengguna</h1>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Pengguna</h6>
    </div>
    <div class="card-body">
    	<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          	<thead>
	            <tr>
	              <!-- <th></th> -->
	              <!-- <th>No</th> -->
	              <th></th>
	              <th>Nama</th>
	              <th>Email</th>
	              <th>Level</th>
	            </tr>
          </thead>
      </table>

    </div>
</div>

<div class="div-add">
	<form action="{{url(session('role').'/users/create')}}">
		<button class="btn floatbtn btn-primary"><i class="fa fa fa-plus" aria-hidden="true"></i></button>
	</form>
</div>
@endsection

@section('css')
<!-- Custom styles for this page -->
<link href="{{asset('template')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection
@section('js')
<!-- Page level plugins -->
<script src="{{asset('template')}}/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="{{asset('template')}}/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript">
	$(function() {
	    table = $('#dataTable').DataTable({
	        processing: true,
	        serverSide: true,
	        ajax: '{{url(session('role')."/users/data")}}',
	        columns: [
	            {
	                "orderable":      false,
	                "searchable":     false,
	                "data":           null,
	                "defaultContent": '',
	                "render" : function(data,type,row,meta) {
	                    	return '<a class="delete btn btn-xs btn-danger" href="{{url(session('role').'/users/')}}/'+row.id+'">'+' <i class="fa fa-trash-o" aria-hidden="true"></i> '+'</a>' +
	                    	' <a href="{{url(session('role').'/users/')}}/'+row.id+'/edit"class="edit btn btn-xs btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i> </a>';
	                	}
	            },
	            { data: 'name', name: 'name' },
	            { data: 'email', name: 'email' },
	            { data: 'nama_level', name: 'user_levels.nama' }
	        ],
	        drawCallback: function( settings ) {

	            $(".delete").on('click',function(e){
	                  e.preventDefault();
	                  x = confirm("Yakin anda akan menghapus data ini");
	                  if(x == true){
	                     var link = $(this).attr('href');
	                      var _token = '{{ csrf_token() }}';
	                      fdata  = {
	                        '_method' : 'delete',
	                        '_token'  : _token
	                      };
	                      $.post(link,fdata,function(result){
	                        alert(result['msg']);
	                        if(result['status'] == 'success'){
	                          table.ajax.url('{{url(session('role').'/users/data')}}').load();
	                        }
	                      });
	                  }
	            });
	        }
	    });
	});
</script>
@endsection