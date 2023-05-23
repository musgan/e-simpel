
<div class="row">
    <div class="form-group col-lg-6 {{ $errors->has('user_level_id') ? 'has-error' : ''}}">
        {!! Form::label('user_level_id', 'Level Pengguna', ['class' => 'control-label']) !!}
        {!! Form::select('user_level_id', $user_levels,null, ['class' => 'form-control','required'  => 'required', 'id' => 'user_id']) !!}
        {!! $errors->first('user_level_id', '<p class="help-block">:message</p>') !!}

    </div>

    <div id="fsector_form" class="form-group col-lg-6 {{ $errors->has('sector_id') ? 'has-error' : ''}}">
        {!! Form::label('sector_id', 'Bidang', ['class' => 'control-label']) !!}
        <div class="clearfix" ></div>
        {!! Form::select('sector_id[]', $sectors,$selected_sector, ['multiple' => 'multiple','class' => 'form-control', 'id'=> 'sector_form']) !!}
        {!! $errors->first('sector_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="row">
    <div class="form-group col-lg-6 {{ $errors->has('name') ? 'has-error' : ''}}">
        {!! Form::label('name', 'Nama Lengkap', ['class' => 'control-label']) !!}
        {!! Form::text('name', null, ['class' => 'form-control','required'	=> 'required', 'placeholder'=>'required']) !!}
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group col-lg-6 {{ $errors->has('name') ? 'has-error' : ''}}">
        {!! Form::label('', 'NIP', ['class' => 'control-label']) !!}
        {!! Form::text('nip', null, ['class' => 'form-control','required'  => 'required']) !!}
        {!! $errors->first('nip', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
    {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
    {!! Form::email('email', null, ['class' => 'form-control',isset($submitButtonText) ? 'readonly' : 'required', 'placeholder'=>'required']) !!}
    {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
</div>
<div class="row">
    <div class="form-group col-lg-6 {{ $errors->has('password') ? 'has-error' : ''}}">
        {!! Form::label('password', 'Password', ['class' => 'control-label']) !!}
        <input type="password" {!! isset($submitButtonText) ? '' : 'required' !!} class="form-control" name="password" placeholder="{!! isset($submitButtonText) ? 'Kosongkan jika tidak ingin password diperbaharui' : 'required' !!}">

    </div>

    <div class="form-group col-lg-6  {{ $errors->has('password_confirmation') ? 'has-error' : ''}}">
        {!! Form::label('password_confirmation ', 'Ketik Ulang Password', ['class' => 'control-label']) !!}
        <input type="password" {!! isset($submitButtonText) ? '' : 'required' !!}  class="form-control" name="password_confirmation" placeholder="{!! isset($submitButtonText) ? '' : 'required' !!}">

    </div>
</div>


<div class="form-group">
    <div class="col-md-offset-2">
        <button type="submit" class="btn btn-primary btn-md btn-flat"><i class="fa fa-floppy-o" aria-hidden="true"></i> {!! isset($submitButtonText) ? $submitButtonText : 'Create' !!}</button>
    </div>
</div>