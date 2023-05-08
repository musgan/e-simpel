
<body style="font-family: Arial; font-size: 12pt">
@if($temuan)
    @foreach($temuan as $row)
        <b>{{$row->itemlingkupPengawasanregular->nama}}</b>
        {!! $row->temuan !!}
    @endforeach
@endif
</body>