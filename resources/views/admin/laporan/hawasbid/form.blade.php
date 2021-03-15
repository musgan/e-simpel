<div class="row">

<div class="form-group col-md-6 {{ $errors->has('nama_file') ? 'has-error' : ''}}">
    {!! Form::label('nama_file', 'Nama File', ['class' => 'control-label']) !!}
    <div class="col-md-12">
        {!! Form::text('nama_file',null,['class'    => 'form-control','required' => 'required',
        'autocomplete'=>'off']) !!}
    </div>
</div>


<div class="form-group col-md-2 {{ $errors->has('nama_file') ? 'has-error' : ''}}">
    {!! Form::label('', 'Jenis File', ['class' => 'control-label']) !!}
    <div class="col-md-12 row">
        {!! Form::select('jenis_file',[1=> "excel",2=>"pdf"],null,['class'    => 'form-control','required' => 'required']) !!}
    </div>
</div>

</div>


<div class="row col-md-12">
    <div class="form-group col-md-4 mb-3">
        {!! Form::label('', 'Jenis Laporan', ['class' => 'control-label']) !!}
        
        <div class="col-md-12 row">
            {{Form::select('jenis_laporan',$jenis_laporan, null, ["class"  => "form-control", "required"    => "required", 'id' => 'jenis_laporan'])}}
        </div>
    </div>

    <div class="col-md-4 form-group {{ $errors->has('sector_id') ? 'has-error' : ''}}" id="fsector_form">
        {!! Form::label('sector_id', 'Bidang', ['class' => 'control-label']) !!}
        
        <div class="col-md-12 row">
            {!! Form::select('sector_id[]', $sectors,null, ['multiple' => 'multiple','class' => 'form-control', 'id'=> 'sector_form']) !!}
            {!! $errors->first('sector_id', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>

<div class="form-group">
    {!! Form::label('', 'Periode', ['class' => 'col-md-2 control-label']) !!}
    <div class="row col-md-12">
        <div class="col-md-4">
            {{Form::select('periode_bulan', $periode_bulan,null,['class'=> 'form-control','required'    => 'required','placeholder' => '- Pilih Bulan -'])}}
        </div>
        <div class="col-md-4">
            {{Form::input('number','periode_tahun',null,['class'=> 'form-control','required'    => 'required','placeholder' => 'Masukkan Tahun'])}}
        </div>
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-2 col-md-3">
        <button type="submit" class="btn btn-primary btn-md btn-flat">Cetak</button>
    </div>
</div>