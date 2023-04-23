@extends('layouts.app_admin')
@extends('layouts.nav_admin')

@section('content')

    <section class="justify-content-between mb-4">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="h3 mb-0 text-gray-800"><a href="{{url($path_url)}}" class="mr-2  text-decoration-none"><i class="fa fa-chevron-left" aria-hidden="true"></i> Pengawasan Reguler</a></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Lingkup Pengawasan</a></li>
                    <li class="breadcrumb-item active">@lang('form.button.view.text')</li>
                </ol>
            </div>
        </div>
    </section>

    <div class="card">
        <div class="card-header">
            Lingkup Pengawasan
        </div>
        <div class="card-body pl-5 pr-5 pt-5 pb-5">
            <div class="form-group">
                <label class="">Nama</label>

                <input class="form-control" type="text" value="{{$form->nama}}" readonly>

            </div>

            <div class="form-group">
                @if(count($form->items) > 0)
                <ol>
                    @foreach($form->items as $row)
                        <li>{{$row->nama}}</li>
                    @endforeach
                </ol>
                @endif
            </div>
        </div>
    </div>

@endsection