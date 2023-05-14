@php
$detail = false;
if(isset($form_detail))
    $detail = $form_detail;

@endphp
<div class="card mb-3">
    <div class="card-header">
        <h5>Form kesesuaian</h5>
    </div>
    <div class="card-body">
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
        <div class="form-group">
            <label>Uraian</label>
            @if($detail)
                <div style="min-height: 100px" class="form-control h-auto" id="uraian_kesesuaian" readonly="">
                    {!! isset($form)?$form->uraian:'' !!}
                </div>
            @else
                <textarea id="uraian_kesesuaian" class="editor form-control" name="uraian_kesesuaian">{!! isset($form)?$form->uraian:'' !!}</textarea>
            @endif

        </div>
    </div>
</div>