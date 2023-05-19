@if(isset($content))
@foreach($content as $row)
    @php
        $rowNodeName = $row['nodeName'];
        $rowContent = $row['content'];
        $list = array("ol","ul");
    @endphp
    @if(in_array($rowNodeName,$list))
        <ol style="font-family: Arial; font-size: 12pt">
            @include("template-word.template-word", ['content'   => $rowContent])
        </ol>
    @elseif($rowNodeName == "li")
        <li style="font-family: Arial; font-size: 12pt">{{$rowContent}}</li>
    @elseif($rowNodeName == "p")
        <p style="font-family: Arial; font-size: 12pt">{{$rowContent}}</p>
    @endif
@endforeach

@endif