<div class="card mb-3">
	<div class="card-body">
		<div class="row">
			<div class="col-md-6 form-group {{ $errors->has('periode_tahun') ? 'has-error' : ''}}">
				{!! Form::label('Periode Tahun', null, ['class' => 'control-label font-weight-bold']) !!}

				{!!
					isset($submitButtonText) ?

					Form::number('periode_tahun',null,['class' => 'form-control','required'=>'required','placehoder'	=>'yyyy','min'	=> 2020,'max'=>9999, 'readonly' => 'readonly' ]) :

					Form::number('periode_tahun',null,['class' => 'form-control','required'=>'required','placehoder'	=>'yyyy','min'	=> 2020,'max'=>9999 ])
					 !!}

			</div>

			<div class="col-md-6 form-group {{ $errors->has('periode_bulan') ? 'has-error' : ''}}">
				@php
				$propertyOptionBulan = ['class'=>'form-control','required'=>'required'];
                if(isset($submitButtonText))
                    $propertyOptionBulan['disabled'] = 'disabled';
				@endphp
				{!! Form::label('Periode Bulan', null, ['class' => 'control-label font-weight-bold']) !!}
				{!! Form::select('periode_bulan',$periode_bulan,null,$propertyOptionBulan) !!}
				@if(isset($submitButtonText))
					<input type="hidden" name="periode_bulan" value="{{$data->periode_bulan}}" />
				@endif
			</div>
		</div>

		<div class="form-group">
			{!! Form::label('Periode Input Dokumen', null, ['class' => 'control-label font-weight-bold']) !!}
			<div class="row">
				<div class="col-md-6">
					{!! Form::label('start', null, ['class' => 'control-label']) !!}
					{!! Form::date('start_input_session',null,['class' =>'form-control','required'=>'required']) !!}
				</div>

				<div class="col-md-6">
					{!! Form::label('stop', null, ['class' => 'control-label']) !!}
					{!! Form::date('stop_input_session',null,['class' =>'form-control','required'=>'required']) !!}
				</div>
			</div>
		</div>

		<div class="form-group">
			{!! Form::label('Tindak lanjut', null, ['class' => 'control-label font-weight-bold']) !!}
			<div class="row">
				<div class="col-md-6">
					{!! Form::label('start', null, ['class' => 'control-label']) !!}
					{!! Form::date('start_periode_tindak_lanjut',null,['class' =>'form-control','required'=>'required']) !!}
				</div>

				<div class="col-md-6">
					{!! Form::label('stop', null, ['class' => 'control-label']) !!}
					{!! Form::date('stop_periode_tindak_lanjut',null,['class' =>'form-control','required'=>'required']) !!}
				</div>
			</div>
		</div>
	</div>
</div>