<div class="row col-md-12">
    <div class="form-group col-md-4 {{ $errors->has('sector_id') ? 'has-error' : ''}}">
        {!! Form::label('', 'Bidang Penanggun Jawab', ['class' => 'control-label']) !!}
        
        <div class="">
            {!! Form::select('pj_sector_id', $sectors, null, ['class' => 'form-control', 'required' => 'required','placeholder' => '- Pilih Salah Satu -']) !!}
            {!! $errors->first('sector_id', '<p class="help-block">:message</p>') !!}
        </div>
    </div>


    <div class="form-group col-md-6 {{ $errors->has('sector_id') ? 'has-error' : ''}}">
        {!! Form::label('', 'Bidang Terkait', ['class' => 'control-label']) !!}
        
        <div class="">
            {!! Form::select('sector_id[]', $sectors,$sectors_select, ['id' => 'sector_form','class' => 'form-control', 'multiple'   => 'multiple','required' => 'required']) !!}
            {!! $errors->first('sector_id', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>



<div class="form-group {{ $errors->has('tahun') ? 'has-error' : ''}}">
    
    {!! Form::label('Periode', 'Periode', ['class' => 'col-md-2 control-label']) !!}
    
    <div class="col-md-12 row">
        
        <div class="col-md-4">
            {!! Form::select('bulan',$periode_bulan, $periode_bulan_select, ['class' => 'form-control','required' => 'required']) !!}
            {!! $errors->first('bulan', '<p class="help-block">:message</p>') !!}
        </div>

        <div class="col-md-4">
            {!! Form::input('number','tahun', $periode_tahun_select, ['class' => 'form-control','required' => 'required','placeholder'   => 'Tahun']) !!}
            {!! $errors->first('tahun', '<p class="help-block">:message</p>') !!}
        </div>

    </div>
</div>


<div class="form-group {{ $errors->has('indikator') ? 'has-error' : ''}}">
    {!! Form::label('indikator', 'Indikator', ['class' => 'col-md-2 control-label']) !!}
    
    <div class="col-md-8">
        {!! Form::textarea('indikator', null, ['class' => 'form-control','required'  => 'required']) !!}
        {!! $errors->first('indikator', '<p class="help-block">:message</p>') !!}
    </div>
</div>


<div class="form-group">
    <div class="col-md-offset-2 col-md-3">
        <button type="submit" class="btn btn-primary btn-md btn-flat"><i class="fa fa-floppy-o" aria-hidden="true"></i> {!! isset($submitButtonText) ? $submitButtonText : 'Create' !!}</button>
    </div>
</div>