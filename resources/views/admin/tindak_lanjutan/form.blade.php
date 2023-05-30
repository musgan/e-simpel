<div class="card mb-3">
    <div class="card-body">
        <div class="form-group">
            <label>Bidang terkait</label>
            <div class="form-control h-auto" readonly="">{{$send->bidang}}</div>
        </div>
        <div class="form-group  {{ $errors->has('indikator') ? 'has-error' : ''}}">
            {!! Form::label('indikator', 'Indikator', ['class' => 'control-label']) !!}

            <div class="">
                {!! Form::textarea('indikator', null, ['class' => 'form-control','readonly'  => 'readonly','rows'  => 5]) !!}
                {!! $errors->first('indikator', '<p class="help-block">:message</p>') !!}
            </div>
        </div>

        <div class="form-group  {{ $errors->has('uraian') ? 'has-error' : ''}}">
            {!! Form::label('uraian', 'Uraian', ['class' => 'control-label']) !!}

            <div class="">
                {!! Form::textarea('uraian', null, ['class' => 'form-control','rows'  => 5,'required'   => 'required']) !!}
                {!! $errors->first('uraian', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
</div>