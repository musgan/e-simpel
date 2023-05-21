<div class="card mb-3" id="card-dokumentasi-rapat">
    <div class="card-header">
        <h5>Dokumentasi rapat</h5>
    </div>
    <div class="card-body">
        <div class="col-md-12 mb-3">
            <label>Periode</label>
            <div class="row">
                <div class="col-md-4">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Bulan</span>
                        </div>
                        <select class="form-control field_periode" id="dt_periode_bulan" name="periode_bulan" required {{isset($form)?'disabled':''}}>
                            @foreach($dict_periode_of_month as $month_number => $month_name )
                                <option value="{{$month_number}}" {{($periode_bulan == $month_number)?'selected': ''}}>{{$month_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-4 field-form">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Tahun</span>
                        </div>
                        <input type="number" id="dt_periode_tahun" class="form-control field_periode dokumentasi_field" name="periode_tahun" value="{{$periode_tahun}}" required {{isset($form)?'disabled':''}}>
                    </div>
                </div>
                <div class="col-md-4 field-form">
                    <button type="button" class="btn btn-primary" id="tampilkan_dokumentasi_tapat">Tampilkan</button>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="table-dokumentasi">
                <thead>
                <tr>
                    <th>Kategori</th>
                    <th>File</th>
                    <th>@lang("form.label.created_at")</th>
                    <th>@lang("form.label.action")</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</div>