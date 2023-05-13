<script type="text/javascript">
    const modal_download_index = $("#modal-download-index")
    $(modal_download_index).on('submit',"#modal-form-download", function (e){
        e.preventDefault()
        const url = $(this).attr('action')
        const data = $(this).serialize()
        $.post(url, data, function (response){
            alert(response.message)
            if(response.path_download !== undefined)
                window.location = response.path_download
        }).fail(function (xhr){
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
        });
    })
    $(modal_download_index).on('click', "#upload-template", function (){
        $("#file-template").trigger("click")
    })
    $(modal_download_index).on('change', "#file-template", function(){
        if($(this).val() != ''){
            if(confirm("Apakah anda ingin mengpuload template dari file ini ?")){
                uploadFile();
            }else{
                $(this).val(null)
            }
        }
    })
    function uploadFile(){
        const url = "{{url($path_url.'/uploadtemplate')}}"
        const formData = new FormData();
        formData.append("_token","{{ csrf_token() }}")
        appendFileToFormData("#file-template", "file-template", formData)
        $.ajax({
            url:url,
            type:'POST',
            data:formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success:function (response){
                alert(response.message)
                location.reload()
            },
            error: function (xhr){
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
                $("#file-template").val(null)
            }
        });
    }
    function appendFileToFormData(id, add_to_index, formData = new FormData()){
        const files = $(id)[0].files
        for(let index = 0; index < files.length; index++)
            formData.append(add_to_index, files[index])
    }

</script>