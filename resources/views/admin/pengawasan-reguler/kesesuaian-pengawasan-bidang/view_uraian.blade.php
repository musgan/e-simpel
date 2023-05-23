@if($data)
    <ol type="A" style="">
    @foreach($data as $row_lingkup)
            <li>{{$row_lingkup->nama}}
                <ol type="a">
            @foreach($row_lingkup->items as $row_lingkup_item)
                <li>{{$row_lingkup_item->nama}}
                    <ol>
                @foreach($row_lingkup_item->kesesuaian_pengawasan_regular as $row_kesesuaian)
                    <li>{!! strip_tags($row_kesesuaian->uraian)!!}</li>
                @endforeach
                    </ol>
                </li>
            @endforeach
                </ol>
            </li>
    @endforeach
    </ol>
@endif