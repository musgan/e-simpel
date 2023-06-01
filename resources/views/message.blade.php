@if (session('status'))
    @if(session('status') == "success")
        <div class="alert alert-success">
            {!! session('message') !!}
        </div>
    @elseif(session('status') == "error")
        <div class="alert alert-danger">
            {!!  session('message') !!}
        </div>
    @else
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
@endif