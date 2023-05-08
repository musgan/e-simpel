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
</script>