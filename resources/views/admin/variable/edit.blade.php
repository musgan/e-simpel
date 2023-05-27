@extends('layouts.app_admin')
@extends('layouts.nav_admin')

@section('content')
    <section class="justify-content-between mb-4">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="h3 mb-0 text-gray-800"><a href="{{url($path_url)}}" class="mr-2  text-decoration-none"><i class="fa fa-chevron-left" aria-hidden="true"></i> Variabel</a></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Variabel</a></li>
                    <li class="breadcrumb-item active">@lang('form.button.edit.text')</li>
                </ol>
            </div>
        </div>
    </section>
    <form action="{{url($path_url."/".$form->key)}}" method="POST" id="form-submit">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        @include($path_view."form")
        <div class="form-group">
            <a class="btn btn-secondary btn-flat mr-2" href="{{url($path_url)}}">@lang("form.button.back.show")</a>
            <button class="btn btn-primary btn-flat">@lang("form.button.save.show")</button>
        </div>
    </form>
@endsection
@include($path_view."form-js")