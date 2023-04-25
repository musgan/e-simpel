@section("js")
<script type="text/javascript">
    $(".editor").summernote({
        tabsize: 2,
        height: 250,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['para', ['ul', 'ol', 'paragraph']],
        ]
    });
    $("#form-submit").validate({
        submitHandler: function(form) {
            $("#deleted_file").html("")
            const uncheckbox = $(".checked_file:checkbox:not(:checked)")
            uncheckbox.each(function(index,item){
                $("#deleted_file").append('<input type="hidden" name="uncheckedfiles[]" value="'+$(item).val()+'">')
            })
            const formData = new FormData();
            const files = $("#files")[0].files
            for(let index = 0; index < files.length; index++)
                formData.append("files[]", files[index])

            const data = $(form).serializeArray()
            data.forEach(function(item, index){
                formData.append(item.name, item.value)
            })
            const url = $(form).attr('action')
            $.ajax({
                url:url,
                type:'POST',
                data:formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success:onSuccess,
                error: onFail
            });
            return false;
        },
        errorPlacement: function (error, e) {
            console.log(error)
            e.parents(".field-form").append(error);
        },
    });

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

    $(".field_periode").on('change',getFormKesesuaian)
    function getFormKesesuaian(){
        const url = "{{url($path_url_kesesuaian."/getbyperiode")}}"
        const data = {
            'periode_bulan': $("#periode_bulan").val(),
            'periode_tahun': $('#periode_tahun').val()
        }
        $.get(url, data, function(response){
            if(response.uraian !== undefined)
                $("#uraian_kesesuaian").html(response.uraian)
            else $("#uraian_kesesuaian").html("")
        })
    }
    getFormKesesuaian()

</script>
@endsection