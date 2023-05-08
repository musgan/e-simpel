<!-- Modal -->
<div class="modal fade" id="modal-download-index" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Download</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{url($path_url.'/download')}}" id="modal-form-download" method="post">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="">
                        <label>Periode</label>
                        <div class="row">

                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Bulan</span>
                                    </div>
                                    <select class="form-control field_periode" id="periode_bulan" name="periode_bulan" required {{isset($form)?'disabled':''}}>
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
                                    <input type="number" id="periode_tahun" class="form-control field_periode" name="periode_tahun" value="{{$periode_tahun}}" required {{isset($form)?'disabled':''}}>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-flat" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary btn-flat">Download</button>
                </div>
            </form>
        </div>
    </div>
</div>