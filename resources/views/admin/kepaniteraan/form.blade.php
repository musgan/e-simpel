<div class="card mb-3">
    <div class="card-body">
        <div class="row">
            <div class="form-group col-md-4">
                <label>Periode</label>
                <div class="form-control h-auto" readonly >{{CostumHelper::getNameMonth($secretariat->periode_bulan)}}  {{$secretariat->periode_tahun}}</div>
            </div>
            <div class="form-group col-md-4">
                <label>Penanggung Jawab Bidang</label>
                <div class="form-control h-auto" readonly >{{$secretariat->sector->nama}}</div>
            </div>
            <div class="form-group col-md-4">
                <label>Bidang terkait</label>
                <div class="form-control h-auto" readonly>{{$indikator_sector->sector->nama}}</div>
            </div>
        </div>


        <div class="form-group {{ $errors->has('indikator') ? 'has-error' : ''}}">
            {!! Form::label('indikator', 'Indikator', ['class' => 'control-label']) !!}

            {!! Form::textarea('indikator', $secretariat->indikator, ['class' => 'form-control','readonly'  => 'readonly','rows'  => 5]) !!}
            {!! $errors->first('indikator', '<p class="help-block">:message</p>') !!}
        </div>

        <div class="form-group  {{ $errors->has('uraian_hawasbid') ? 'has-error' : ''}}">
            {!! Form::label('uraian', 'Uraian Hawasbid', ['class' => 'control-label']) !!}
            <div class="">
                {!! Form::textarea('uraian_hawasbid', $indikator_sector->uraian_hawasbid, ['class' => 'form-control','rows'  => 5,'required'   => 'required']) !!}
                {!! $errors->first('uraian_hawasbid', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
</div>
