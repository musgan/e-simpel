@extends('layouts.app_admin')
@extends('layouts.nav_admin')

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Variabel</h1>
    </div>
    <div class="card">
        <div class="card-header">
            <h5>Variabel</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped" id="datatable" >
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Key</th>
                        <th>Nilai</th>
                        <th>Keterangan</th>
                        <th></th>
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
                {data:  "no",width: 50, orderable: false, searchable:false, className:"text-center", targets:0},
                {name:  "key", data:"key",targets: 1},
                {name:  "value", data:"value",targets: 2},
                {name:  "keterangan", data:"keterangan",targets: 3},
                {data:  "action",orderable:false, searchable:false, className:"text-center", targets: 4},
            ],
            order : [[1,'asc']]
        })
    </script>
@endsection