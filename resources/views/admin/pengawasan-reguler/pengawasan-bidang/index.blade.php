@extends('layouts.app_admin')
@extends('layouts.nav_admin')

@section('content')
    <section class="justify-content-between mb-4">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="h3 mb-0 text-gray-800">Pengawasan Reguler</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">{{$sector_selected->category}}</a></li>
                    <li class="breadcrumb-item active">{{$sector_selected->nama}}</li>
                </ol>
            </div>
        </div>
    </section>
    <div class="card mb-3">
        <div class="card-body">
            <ol>
            @foreach($status_pengawasan_regular as $row)
                <li>
                    <h5><span class="badge" style="background-color: {{$row->background_color}};color:{{$row->text_color}}"> {!! $row->icon !!}</span> {{$row->nama}}</h5>
                </li>
            @endforeach
            </ol>
        </div>
    </div>

    <div class="form-group text-right">
        <a class="btn btn-info btn-flat mr-2" href="{{url($path_url_kesesuaian."/create")}}" >@lang("form.button.add.show") Kesesuaian</a>
        <a class="btn btn-primary btn-flat" href="{{url($path_url."/create")}}" >@lang("form.button.add.show") Temuan</a>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            <h4>Temuan {{$sector_selected->nama}}</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped" id="datatable" >
                    <thead>
                    <tr>
                        <th rowspan="2">No</th>
                        <th colspan="2">Periode</th>
                        <th rowspan="2">Lingkup pengawasan</th>
                        <th rowspan="2">Temuan</th>
                        <th rowspan="2">Status</th>
                        <th rowspan="2">@lang("form.label.created_at")</th>
                        <th rowspan="2">@lang("form.label.action")</th>
                    </tr>
                    <tr>
                        <th>Bulan</th>
                        <th>Tahun</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            <h4>Kesesuaian</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped" id="datatable-kesesuaian" >
                    <thead>
                    <tr>
                        <th rowspan="2">No</th>
                        <th colspan="2">Periode</th>
                        <th rowspan="2">Uraian</th>
                        <th rowspan="2">@lang("form.label.created_at")</th>
                        <th rowspan="2">@lang("form.label.action")</th>
                    </tr>
                    <tr>
                        <th>Bulan</th>
                        <th>Tahun</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section("js")
    <script type="text/javascript">
        const table = $("#datatable").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{url($path_url."/gettable")}}",
                method: "post"
            },
            "autoWidth": false,
            columnDefs: [
                {data:"no",width: 50, orderable: false, filterable:false, className:"text-center", targets:0},
                {data:"periode_bulan",name:"periode_bulan",width: 50, orderable: true, filterable:false, targets:1},
                {data:"periode_tahun",name:"periode_tahun",width: 50, orderable: true, filterable:false, targets:2},
                {data:"item_lingkup_pengawasan_nama",name:"item_lingkup_pengawasan_nama",width: 200, orderable: true, filterable:true, targets:3},
                {data:"temuan",name:"temuan", orderable: true, filterable:true, targets:4},
                {data:"status", className:"text-center",name:"status",width: 120, orderable: false, filterable:false, targets:5},
                {data:"created_at",name:"created_at",width: 120, orderable: true, filterable:false, targets:6},
                {data:"action",width: 120, orderable: false, filterable:false, className:"text-center", targets:7},
            ],
            order : [[6,'desc']]
        })

        const table_kesesuaian = $("#datatable-kesesuaian").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{url($path_url_kesesuaian."/gettable")}}",
                method: "post"
            },
            "autoWidth": false,
            columnDefs: [
                {data:"no",width: 50, orderable: false, filterable:false, className:"text-center", targets:0},
                {data:"periode_bulan",name:"periode_bulan",width: 50, orderable: true, filterable:false, targets:1},
                {data:"periode_tahun",name:"periode_tahun",width: 50, orderable: true, filterable:false, targets:2},
                {data:"uraian",name:"uraian", orderable: true, filterable:true, targets:3},
                {data:"created_at",name:"created_at",width: 120, orderable: true, filterable:false, targets:4},
                {data:"action",width: 120, orderable: false, filterable:false, className:"text-center", targets:5},
            ],
            order : [[4,'desc']]
        })

        $(document).on('click','.btn-link-delete', function (e){
            e.preventDefault()
            const table_id = $(this).parents("table").attr("id");
            let table_selected = table;
            if(table_id == "datatable-kesesuaian")
                table_selected = table_kesesuaian;

            const url = $(this).attr('href')
            if(confirm("Apakah anda ingin menghapus data ini ?")){
                requestDelete(table_selected, url);
            }
        })

        function requestDelete(table,url){
            const data = {
                "_token": "{{ csrf_token() }}"
            }
            $.ajax({
                url: url,
                data: data,
                type: 'DELETE',
                success: function(result) {
                    table.ajax.reload( null, false )
                }
            }).fail(function (xhr){
                alert('gagal menghapus data')
            });
        }
    </script>
@endsection