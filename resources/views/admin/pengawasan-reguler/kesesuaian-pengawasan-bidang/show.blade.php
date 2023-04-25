@extends('layouts.app_admin')
@extends('layouts.nav_admin')

@section('content')
    <section class="justify-content-between mb-4">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="h3 mb-0 text-gray-800"><a href="{{url($path_url_pengawasan_bidang)}}" class="mr-2  text-decoration-none"><i class="fa fa-chevron-left" aria-hidden="true"></i> Pengawasan Reguler</a></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">{{$sector_selected->category}}</a></li>
                    <li class="breadcrumb-item"><a href="#">{{$sector_selected->nama}}</a></li>
                    <li class="breadcrumb-item"><a href="#">Kesesuaian</a></li>
                    <li class="breadcrumb-item active">@lang("form.button.show.text")</li>
                </ol>
            </div>
        </div>
    </section>


    @include("admin.pengawasan-reguler.pengawasan-bidang.form-periode")
    @include($path_view."form")

@endsection