@extends('layouts.app_admin')
@extends('layouts.nav_admin')

@section('content')


<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">Bidang & Penanggung Jawab</h1>
</div>
<div class="card shadow mb-4">
    <div class="card-body">
    	<table class="table table-hover" id="dataTable">
    		<thead>
	    		<tr>
	    			<th>No</th>
                    <th>Warna</th>
	    			<th>Bidang</th>
	    			<th>Pengawas</th>
	    			<th>NIP</th>
	    			<th></th>
	    		</tr>
    		</thead>
    		<tbody>
    			<?php
    				$no = 1
    			?>
    			@foreach($send as $row)
    			<tr>
    				<td>{{($no++)}}</td>
                    <td>{{$row->base_color}}<br>
                        <div style="height: 30px;width: 30px; background-color:#{{$row->base_color}}; border: 1px black solid; ">
                            
                        </div>
                    </td>
    				<td >{{$row->nama}}</td>
    				<td>{!! $row->penanggung_jawab !!}</td>
    				<td>{{ $row->nip}}</td>
    				<td>
    					<a href="{{url(session('role').'/sector_hawasbid/'.$row->id.'/edit')}}" class="btn btn-warning btn-flat btn-sm">
    						<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
    					</a>
    				</td>
    			</tr>
    			@endforeach
    		</tbody>
    	</table>
    </div>
</div>

@endsection