
        <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
            {!! Form::label('name', 'Nama', ['class' => 'control-label']) !!}
            <div class="">
                {!! Form::text('name', null, ['class' => 'form-control','required'	=> 'required', 'placeholder'=>'required']) !!}
                {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
            </div>
        </div>

        <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
            {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
            <div class="">
                {!! Form::email('email', null, ['class' => 'form-control',isset($submitButtonText) ? 'readonly' : 'required', 'placeholder'=>'required']) !!}
                {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('opsi password', 'Ganti Password', ['class' => 'control-label']) !!}
            <div class="">
                <label class="radio-inline"><input type="radio" class="psw-opt" name="optradio" value="0" checked> Tidak &nbsp &nbsp &nbsp</label>
                <label class="radio-inline"><input type="radio" class="psw-opt" name="optradio" value="1"> Ya </label>
            </div>
        </div>

        <div class="form-group password-hide {{ $errors->has('password') ? 'has-error' : ''}}">
            {!! Form::label('password', 'Password', ['class' => 'control-label']) !!}
            
            <div class="">
                <input type="password" {!! isset($submitButtonText) ? '' : 'required' !!} class="form-control pass" name="password" placeholder="{!! isset($submitButtonText) ? 'Kosongkan jika tidak ingin password diperbaharui' : 'required' !!}">
            </div>
        </div>

        <div class="form-group password-hide {{ $errors->has('password_confirmation') ? 'has-error' : ''}}">
            {!! Form::label('password_confirmation ', 'Ketik Ulang Password', ['class' => 'control-label']) !!}    
            <div class="">
                <input type="password" {!! isset($submitButtonText) ? '' : 'required' !!}  class="form-control pass" name="password_confirmation" placeholder="{!! isset($submitButtonText) ? '' : 'required' !!}">
            </div>
        </div>
    

<div class="form-group">
    <div class="">
        <button type="submit" class="btn btn-primary btn-md btn-flat"><i class="fa fa-floppy-o" aria-hidden="true"></i> {!! isset($submitButtonText) ? $submitButtonText : 'Create' !!}</button>
    </div>
</div>


