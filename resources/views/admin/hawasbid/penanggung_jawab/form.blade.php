<div class="row col-md-12">
    <div class="form-group col-md-3 {{ $errors->has('') ? 'has-error' : ''}}">
        {!! Form::label('', 'Warna Dasar', ['class' => 'control-label']) !!}
        
        <div class="">
            {!! Form::text('base_color', null, ['class' => 'form-control']) !!}
            {!! $errors->first('base_color', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="form-group col-md-5 {{ $errors->has('nama') ? 'has-error' : ''}}">
        {!! Form::label('nama', 'Nama', ['class' => 'control-label']) !!}
        
        <div class="">
            {!! Form::text('nama', null, ['class' => 'form-control','readonly'  => 'readonly']) !!}
            {!! $errors->first('nama', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>

<div class="form-group {{ $errors->has('penanggung_jawab') ? 'has-error' : ''}}">
    {!! Form::label('penanggung_jawab', 'Penanggung Jawab', ['class' => 'col-md-2 control-label']) !!}
    
    <div class="col-md-8">
        {!! Form::text('penanggung_jawab', null, ['class' => 'form-control','required'  => 'required']) !!}
        {!! $errors->first('penanggung_jawab', '<p class="help-block">:message</p>') !!}
    </div>
</div>


<div class="form-group {{ $errors->has('nip') ? 'has-error' : ''}}">
    {!! Form::label('nip', 'NIP', ['class' => 'col-md-2 control-label']) !!}
    
    <div class="col-md-8">
        {!! Form::text('nip', null, ['class' => 'form-control','required'  => 'required']) !!}
        {!! $errors->first('nip', '<p class="help-block">:message</p>') !!}
    </div>
</div>


<div class="form-group">
    <div class="col-md-offset-2 col-md-3">
        <button type="submit" class="btn btn-primary btn-md btn-flat"><i class="fa fa-floppy-o" aria-hidden="true"></i> {!! isset($submitButtonText) ? $submitButtonText : 'Create' !!}</button>
    </div>
</div>