<div class="modal fade" id="modal-form-dokumentasi-rapat" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >@lang("form.button.add.text") Dokumentasi Rapat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-dokumentasi-rapat" method="post" enctype="multipart/form-data" action="">
                {{ csrf_field() }}
                <div class="modal-body">
                    <input type="hidden" name="kategori_dokumentasi" id="kategori_dokumentasi">
                    <div class="">
                        <label>Periode</label>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Bulan</span>
                                    </div>
                                    {{Form::select('periode_bulan',$periode_bulan,$bulan,['class'  => 'form-control'])}}
                                </div>
                            </div>

                            <div class="col-md-6 field-form">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Tahun</span>
                                    </div>
                                    <input type="number" class="form-control" name="periode_tahun" value="{{$tahun}}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Notulensi</label>
                        <input id="notulensi" type="file" class="form-control" name="notulensi[]" multiple>
                    </div>
                    <div class="form-group">
                        <label>Absensi</label>
                        <input id="absensi" type="file" class="form-control" name="absensi[]" multiple>
                    </div>
                    <div class="form-group">
                        <label>Foto</label>
                        <input id="foto" type="file" class="form-control" name="foto[]" multiple>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>