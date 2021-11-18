<div class="row">

    <div class="form-group col-md-4 {{ $errors->has('nama_file') ? 'has-error' : ''}}">
        {!! Form::label('nama_file', 'Nama File', ['class' => 'control-label font-weight-bold']) !!}
    
        {!! Form::text('nama_file',null,['class'    => 'form-control','required' => 'required',
        'autocomplete'=>'off']) !!}
        
    </div>


    <div class="form-group col-md-4 {{ $errors->has('nama_file') ? 'has-error' : ''}}">
        {!! Form::label('', 'Jenis File', ['class' => 'control-label font-weight-bold']) !!}
        <div class="col-md-12 row">
            {!! Form::select('jenis_file',[1=> "excel",2=>"pdf"],null,[ 
            'class' => 'form-control',
            'id'=> 'id_jenisFile', 
            'required' => 'required']) !!}
        </div>
    </div>

</div>


<div class="row">
        <div class="form-group col-md-4 mb-3">
            {!! Form::label('', 'Jenis Laporan', ['class' => 'control-label font-weight-bold']) !!}

            {{Form::select('jenis_laporan',$jenis_laporan, null, ["class"  => "form-control", "required"    => "required", 'id' => 'jenis_laporan'])}}
        
        </div>

        <div class="col-md-4 form-group {{ $errors->has('sector_id') ? 'has-error' : ''}}" id="fsector_form">
            {!! Form::label('sector_id', 'Bidang', ['class' => 'control-label font-weight-bold']) !!}
            
            <div class="col-md-12 row">
                {!! Form::select('sector_id[]', $sectors,null, ['multiple' => 'multiple','class' => 'form-control', 'id'=> 'sector_form']) !!}
                {!! $errors->first('sector_id', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
</div>

<div id="signature_lap_bidang" class="form-group">
    {!! Form::label('', 'Peletakan Tandatangan (letakkan pada halaman baru ?)', ['class' => 'control-label font-weight-bold']) !!} 
    <div class="" style="background-color: #EEEEEE; padding: 10px">
        <div class="row col-md-12" >
            @foreach($sectors as $key => $value)
            <div class="col-md-3 signature_bidang_item" id="signature_bidang_{{$key}}">
                 {!! Form::label(null, $value, ['class' => 'control-label']) !!}
                 <div class="row">
                     <div class="radio col-md-6">
                      <label><input type="radio" name="signature_break_{{$key}}" value="n" checked> Tidak</label>
                    </div>
                    <div class="radio  col-md-6">
                      <label><input type="radio" name="signature_break_{{$key}}" value="y"> Ya</label>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    
</div>

<div id="signature_lap_keseluruhan" class="form-group">
     {!! Form::label('', 'Peletakan Tandatangan (letakkan pada halaman baru ?)', ['class' => 'control-label font-weight-bold']) !!} 
    <div class="" style="background-color: #EEEEEE; padding: 10px">
        <div class="row col-md-12" >
            
            <div class="col-md-4">
                 {!! Form::label(null, "Laporan Keseluruhan Bulan Terpilih", ['class' => 'control-label']) !!}
                 <div class="row">
                     <div class="radio col-md-6">
                      <label><input type="radio" name="signature_break_01" value="n" checked> Tidak</label>
                    </div>
                    <div class="radio  col-md-6">
                      <label><input type="radio" name="signature_break_01" value="y"> Ya</label>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                 {!! Form::label(null, "Hasil Temuan", ['class' => 'control-label']) !!}
                 <div class="row">
                     <div class="radio col-md-6">
                      <label><input type="radio" name="signature_break_02" value="n" checked> Tidak</label>
                    </div>
                    <div class="radio  col-md-6">
                      <label><input type="radio" name="signature_break_02" value="y"> Ya</label>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                 {!! Form::label(null, "Tidak Lanjut", ['class' => 'control-label']) !!}
                 <div class="row">
                     <div class="radio col-md-6">
                      <label><input type="radio" name="signature_break_03" value="n" checked> Tidak</label>
                    </div>
                    <div class="radio  col-md-6">
                      <label><input type="radio" name="signature_break_03" value="y"> Ya</label>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row col-md-12">
        {!! Form::label('', 'Periode', ['class' => 'control-label font-weight-bold']) !!}
    </div>

    <div class="row">
        <div class="col-md-4">
            {{Form::select('periode_bulan', $periode_bulan,null,['class'=> 'form-control','required'    => 'required','placeholder' => '- Pilih Bulan -'])}}
        </div>
        <div class="col-md-4">
            {{Form::input('number','periode_tahun',null,['class'=> 'form-control','required'    => 'required','placeholder' => 'Masukkan Tahun'])}}
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row col-md-offset-2 col-md-3">
        <button type="submit" class="btn btn-primary btn-md btn-flat">Cetak</button>
    </div>
</div>