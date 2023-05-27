@section("js")
<script type="text/javascript">
    $(document).on('submit','#form-submit',function (e){
        e.preventDefault()
        const data = $(this).serialize()
        const url = $(this).attr('action')
        $.post(url, data, onSuccess)
            .fail(onFail)
    })

    function onSuccess(response){
        alert(response.message)
        window.location = "{{url($path_url)}}"
    }
    function onFail(xhr){
        if(xhr.status == 400) {
            alert(xhr.responseText)
            return;
        }
        if(xhr.responseJSON == undefined) {
            alert("error")
            return;
        }
        const response = xhr.responseJSON
        let message = ""
        for(const key in response){
            response[key].forEach(function (item, index){
                if(message !== "")
                    message += "\n"
                message += item
            })
        }
        alert(message)
    }
</script>
@endsection