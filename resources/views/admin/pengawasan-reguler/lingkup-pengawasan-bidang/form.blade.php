@php
$items = [];
if(isset($lingkup_pengawasan_bidang)){
    foreach ($lingkup_pengawasan_bidang as $row) {
        array_push($items, $row->item_lingkup_pengawasan_id);
    }
}

@endphp
<div class="card mb-3">
    <div class="card-header">
        <h5>Lingkup Pengawasan Bidang</h5>
    </div>
    <div class="card-body">
        <div class="form-group">
            <label>Bidang</label>
            <select id="sector_id" name="sector_id" class="form-control select2" required>
                @foreach($menu_sectors as $row)
                    <option value="{{$row->id}}" {{isset($sector_id)?($sector_id == $row->id?"selected":''):''}}>{{$row->nama}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Lingkup Pengawasan</label>
            <select class="form-control select2" id="lingkup_pengawasan_id" name="lingkup_pengawasan_id[]" multiple="multiple" required>
                @foreach($lingkup_pengawasan as $row)
                    <optgroup label="{{$row->nama}}">
                        @foreach($row->items as $rowItem)
                            <option value="{{$rowItem->id}}" {{in_array($rowItem->id,$items)?'selected':''}}>{{$rowItem->nama}}</option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
        </div>
    </div>
</div>