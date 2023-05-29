@extends('layouts.app_admin')
@extends('layouts.nav_admin')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">Pengguna</h1>
</div>
<div class="form-group text-right">
	<a class="btn btn-primary btn-flat mr-2 mb-1" href="{{url("users/create")}}" >@lang("form.button.add.show")</a>
</div>
<div class="card shadow mb-4">
    <div class="card-body">
    	<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          	<thead>
	            <tr>
	              	<!-- <th></th> -->
	              	<th>No</th>
	              	<th>Nama</th>
	              	<th>Email</th>
	              	<th>Level</th>
					<th></th>
	            </tr>
          </thead>
      </table>

    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
	$(function() {
	    const table = $('#dataTable').DataTable({
	        processing: true,
	        serverSide: true,
	        ajax: '{{url("/users/data")}}',
	        columns: [
				{ data: 'no', orderable: false, searchable: false },
	            { data: 'name', name: 'name', searchable: true, orderable: true },
	            { data: 'email', name: 'email', searchable: true, orderable: true },
	            { data: 'nama_level', name: 'user_levels.nama' , searchable: true, orderable: true},
				{ data: 'action', orderable: false, searchable: false}
	        ],
			order: [[1, 'asc']]
	        {{--drawCallback: function( settings ) {--}}
	    });

		$(document).on('click',".btn-link-delete",function(e){
			  e.preventDefault();
			  if(confirm("Apakah anda ingin menghapus data ini ?")){
				 var link = $(this).attr('href');
				  var _token = '{{ csrf_token() }}';
				  fdata  = {
					'_method' : 'delete',
					'_token'  : _token
				  };
				  $.post(link,fdata,function(result){
						alert(result['msg']);
						if(result['status'] == 'success'){
						  	table.ajax.reload();
						}
				  });
			  }
		});

	});
</script>
@endsection