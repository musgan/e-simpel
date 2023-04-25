@extends('layouts.app_admin')
@extends('layouts.nav_admin')

@php
$status = $form->statuspengawasanregular;
@endphp

@section('content')
    <section class="justify-content-between mb-4">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="h3 mb-0 text-gray-800"><a href="{{url($path_url)}}" class="mr-2  text-decoration-none"><i class="fa fa-chevron-left" aria-hidden="true"></i> Pengawasan Reguler</a></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">{{$sector_selected->category}}</a></li>
                    <li class="breadcrumb-item"><a href="#">{{$sector_selected->nama}}</a></li>
                    <li class="breadcrumb-item active">@lang("form.button.edit.text")</li>
                </ol>
            </div>
        </div>
    </section>
    <div class="card mb-3">
        <div class="card-body">
            <h4><span class="badge mr-3" style="color: {{$status->text_color}}; background-color: {{$status->background_color}};">{!! $status->icon !!}</span>{{$status->nama}}</h4>
        </div>
    </div>
    @include("admin.pengawasan-reguler.pengawasan-bidang.form")
    <form action="{{url($path_url."/".$form->id)}}"  method="POST" id="form-submit" enctype="multipart/form-data" >
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        @include($path_view."form")
        <div class="form-group">
            <a class="btn btn-secondary btn-flat mr-2" href="{{url($path_url)}}">@lang("form.button.back.show")</a>
            <button class="btn btn-primary btn-flat mr-2">@lang("form.button.save.show")</button>
        </div>
    </form>
@endsection
@include($path_view."form-js")