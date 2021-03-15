<input type="hidden" name="bulan" value="{{$bulan}}" />
<input type="hidden" name="tahun" value="{{$tahun}}" />
<div class="form-group {{ $errors->has('evidence') ? 'has-error' : ''}}">
    {!! Form::label('', 'Notulensi (pilih beberapa file)', ['class' => 'col-md-12 control-label']) !!}
    
    <div class="col-md-12">
        {!! Form::file('notulensi[]',['multiple' => 'multiple', 'id'=> 'notulen']) !!}
        {!! $errors->first('notulensi', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<div class="form-group {{ $errors->has('evidence') ? 'has-error' : ''}}">
    {!! Form::label('', 'Absensi (pilih beberapa file)', ['class' => 'col-md-12 control-label']) !!}
    
    <div class="col-md-12">
        {!! Form::file('absensi[]',['multiple' => 'multiple', 'id'=> 'absensi']) !!}
        {!! $errors->first('absensi', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('evidence') ? 'has-error' : ''}}">
    {!! Form::label('', 'foto (pilih beberapa file) max: 2 MB tiap file ', ['class' => 'col-md-12 control-label']) !!}
    
    <div class="col-md-12">
        {!! Form::file('foto[]',['multiple' => 'multiple', 'accept'=> '"image/*"', 'id'=> 'foto']) !!}
        {!! $errors->first('foto', '<p class="help-block">:message</p>') !!}
    </div>
</div>


<div class="form-group">
    <div class="col-md-12">
        <button type="submit" class="btn btn-primary btn-md btn-flat">Upload</button>
    </div>
</div>