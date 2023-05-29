@extends('layouts.app_admin')
@extends('layouts.nav_admin')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pengawasan Reguler</h1>
    </div>
    <div class="form-group text-right">
        <a class="btn btn-primary btn-flat" href="{{url($path_url."/create")}}" >@lang("form.button.add.show")</a>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Lingkup Pengawasan Bidang</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped" id="datatable" >
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Bidang</th>
                        <th>Lingkup Pengawasan</th>
                        <th>Item Pengawasan</th>
                        <th>@lang("form.label.created_at")</th>
                        <th>@lang("form.label.action")</th>
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
                {data:"no",width: 50, orderable: false, searchable:false, className:"text-center", targets:0},
                {name: "sectors.nama", data:"sector_nama", targets: 1},
                {name: "lingkup_pengawasan.nama", data:"lingkup_pengawasan_nama", targets: 2},
                {name: "item_lingkup_pengawasan.nama", data:"item_lingkup_pengawasan_nama", targets: 3},
                {name: "id", data:"created_at",searchable: false, targets: 4},
                {name: "action",orderable:false, searchable:false, data:"action",className:"text-center", targets: 5},
            ],
            order : [[1,'asc']]
        })
    </script>
@endsection