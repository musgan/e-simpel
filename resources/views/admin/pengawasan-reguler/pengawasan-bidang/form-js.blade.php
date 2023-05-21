@section("js")
    <script type="text/javascript">
        $(".select2").select2()
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
                const data = $(form).serialize()
                const url = $(form).attr('action')
                $.post(url, data, onSuccess)
                    .fail(onFail)
                return false;
            },
            errorPlacement: function (error, e) {
                // console.log(error)
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