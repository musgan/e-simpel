<div class="card mb-3">

    <div class="card-body">
        <div class="">
            <label>Periode</label>
            <div class="row">

                <div class="col-md-6">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Bulan</span>
                        </div>
                        <select class="form-control field_periode" id="periode_bulan" name="peride_bulan" required {{($form_detail === true)?'disabled':''}}>
                            @foreach($dict_periode_of_month as $month_number => $month_name )
                                <option value="{{$month_number}}" {{($periode_bulan == $month_number)?'selected': ''}}>{{$month_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6 field-form">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Tahun</span>
                        </div>
                        <input type="number" id="periode_tahun" class="form-control field_periode" name="periode_tahun" value="{{$periode_tahun}}" required {{($form_detail === true)?'disabled':''}}>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>