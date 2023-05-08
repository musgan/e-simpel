<div class="card mb-3">
    <div class="card-header">
        <h5>{{$sector_selected->nama}}</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Tanggal Rapat Hawasbid</label>
                    <input type="date" name="tanggal_rapat_hawasbid" class="form-control" value="{{isset($form)?$form->tanggal_rapat_hawasbid:''}}" required {{isset($form)?'disabled':''}} />
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <label>Lingkup Pengawasan</label>
                    <select name="item_lingkup_pengawasan_id" class="form-control" required {{isset($form)?'disabled':''}}>
                        @foreach($lingkup_pengawasan_bidang as $row)
                            @php
                                $item = $row->item;
                                $lingkup_pengawasan = $item->lingkup_pengawasan;
                            @endphp
                            <option value="{{$item->id}}" {{isset($form)?($form->item_lingkup_pengawasan_id == $item->id?'selected': ''):''}}>{{$lingkup_pengawasan->nama." - ".$item->nama}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>


        <div class="form-group field-form">
            <label>Temuan</label>
            <div class="summernote">
                @if($form_detail == false)
                    <textarea  name="temuan" class="form-control editor" rows="5" required>{!! isset($form)?$form->temuan:'' !!}</textarea>
                @else
                    <div class="form-control h-auto" readonly>
                        {!! $form->temuan !!}
                    </div>
                @endif
            </div>
        </div>
        <div class="form-group field-form">
            <label>Kriteria</label>
            <div class="summernote">
                @if($form_detail == false)
                    <textarea name="kriteria" class="form-control editor" rows="5" required>{!! isset($form)?$form->kriteria:'' !!}</textarea>
                @else
                    <div class="form-control h-auto" readonly>
                        {!! $form->kriteria !!}
                    </div>
                @endif
            </div>
        </div>
        <div class="form-group field-form">
            <label>Sebab</label>
            <div class="summernote">
                @if($form_detail == false)
                <textarea name="sebab" class="form-control editor" rows="5" required>{!! isset($form)?$form->sebab:'' !!}</textarea>
                @else
                    <div class="form-control h-auto" readonly>
                        {!! $form->sebab !!}
                    </div>
                @endif
            </div>
        </div>
        <div class="form-group field-form">
            <label>Akibat</label>
            <div class="summernote">
                @if($form_detail == false)
                <textarea name="akibat" class="form-control editor" rows="5" required>{!! isset($form)?$form->akibat:'' !!}</textarea>
                @else
                    <div class="form-control h-auto" readonly>
                        {!! $form->akibat !!}
                    </div>
                @endif
            </div>
        </div>
        <div class="form-group field-form">
            <label>Rekomendasi</label>
            <div class="summernote">
                @if($form_detail == false)
                <textarea name="rekomendasi" class="form-control editor" rows="5" required>{!! isset($form)?$form->rekomendasi:'' !!}</textarea>
                @else
                    <div class="form-control h-auto" readonly>
                        {!! $form->rekomendasi !!}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>