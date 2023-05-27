<div class="form-group">
    <label>Key</label>
    <input name="key" class="form-control" value="{{isset($form)?$form->key:''}}" readonly />
</div>
<div class="form-group">
    <label>Nilai</label>
    <input name="value" class="form-control" value="{{isset($form)?$form->value:''}}" required/>
</div>

<div class="form-group">
    <label>keterangan</label>
    <textarea name="keterangan" class="form-control" rows="5" required>{!! isset($form)?$form->keterangan:'' !!}</textarea>
</div>