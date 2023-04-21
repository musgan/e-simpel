@extends('layouts.app_admin')
@extends('layouts.nav_admin')

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Lingkup Pengawasan</h1>
    </div>
    <div class="form-group text-right">
        <a class="btn btn-primary btn-flat" href="{{url($path_url."/create")}}" >@lang("form.button.add.show")</a>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped" id="datatable" >
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Lingkup Pengawasan</th>
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
                {data:"no",width: 50, orderable: false, filterable:false, className:"text-center", targets:0},
                {name: "nama", data:"nama",targets: 1},
                {name: "created_at", data:"created_at",targets: 2},
                {name: "action", data:"action",className:"text-center", targets: 3},
            ],
            order : [[1,'asc']]
        })

        $(document).on('click','.btn-link-delete', function (e){
            e.preventDefault()
            const url = $(this).attr('href')
            if(confirm("Apakah anda ingin menghapus data ini ?")){
                requestDelete(url);
            }
        })

        function requestDelete(url){
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