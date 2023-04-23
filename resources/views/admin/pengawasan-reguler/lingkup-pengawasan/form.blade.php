<input name="id_items" type="hidden" id="id_items" />
<div class="card mb-3">
    <div class="card-header">
        <h5>Lingkup Pengawasan</h5>
    </div>
    <div class="card-body">
        <div class="form-group">
            <label>Nama  <span class="text-danger">*</span></label>
            <input name="name" type="text" class="form-control" value="{{isset($form)?$form->nama:''}}" required />
        </div>
    </div>
</div>