<?php
    $terkait_bidang = $secretariat->indikator_sectors->pluck('sector.nama')->toArray();
?>
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

        <div class="form-group">
            <label>Uraian Hawasbid</label>
            <div class="form-control h-auto" readonly="" style="min-height: 100px">
                {!! $indikator_sector->uraian_hawasbid !!}
            </div>
        </div>

        <div class="form-group  {{ $errors->has('uraian') ? 'has-error' : ''}}">
            {!! Form::label('uraian', 'Uraian', ['class' => 'control-label']) !!}

            <div class="">
                {!! Form::textarea('uraian', $indikator_sector->uraian, ['class' => 'form-control','rows'  => 5,'required'   => 'required']) !!}
                {!! $errors->first('uraian', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group">
            <label>Evidence</label>
            <input class="form-control mb-3" type="file" multiple name="evidence[]">
            <ol>
            @foreach(Storage::allFiles($dir_evidence) as $file)
                <li>
                    <div class="form-check checkbox-lg">
                        <input style="" class="form-check-input checked_file" type="checkbox" value="{{$file}}" name="evidence_filechecked[]" checked>
                        <label class="form-check-label" for="flexCheckChecked">
                            <a href="{{asset(Storage::url($file))}}" target="_blank" >  {{basename($file)}} </a>
                        </label>
                    </div>
                </li>
            @endforeach
            </ol>
        </div>
    </div>
</div>
