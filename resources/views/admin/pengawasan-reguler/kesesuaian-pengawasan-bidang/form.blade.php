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