<script type="text/javascript">
    const modal_dokumentasi_rapat = $("#modal-form-dokumentasi-rapat")
    const table_dokumentasi = $("#table-dokumentasi").DataTable({
        processing: true,
        ajax: {
            url: "{{url($path_url."/gettable")}}",
            method: "post",
            data: function(d){
                d.periode_bulan  =  $("#dt_periode_bulan").val()
                d.periode_tahun  =  $("#dt_periode_tahun").val()
                d.kategori_dokumentasi = '{{isset($kategori_dokumentasi)?$kategori_dokumentasi:'hawasbid' }}'
            }
        },
        "autoWidth": false,
        columnDefs: [
            {name: "category", data:"category", targets: 0},
            {name: "file", data:"file", targets: 1},
            {name: "created_at", data:"created_at", targets: 2},
            {name: "action",orderable:false, searchable:false, data:"action",className:"text-center", targets: 3},
        ]
    })

    $("#form-dokumentasi-rapat").on('submit',modal_dokumentasi_rapat, function(){
        const url = $(this).attr("action")
        const formData = new FormData();
        appendFileToFormData("#notulensi", "notulensi[]", formData)
        appendFileToFormData("#absensi", "absensi[]", formData)
        appendFileToFormData("#foto", "foto[]", formData)

        const data = $(this).serializeArray()
        data.forEach(function(item, index){
            formData.append(item.name, item.value)
        })

        $.ajax({
            url:url,
            type:'POST',
            data:formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success:onSuccessDokumentasiRapat,
            error: onFailDokumentasiRapat
        });
        return false
    })

    function appendFileToFormData(id, add_to_index, formData = new FormData()){
        const files = $(id)[0].files
        for(let index = 0; index < files.length; index++)
            formData.append(add_to_index, files[index])
    }

    function onSuccessDokumentasiRapat(response){
        alert(response.message)
        table_dokumentasi.ajax.reload( null, false )
        {{--window.location = "{{url($path_url)}}"--}}
    }
    function onFailDokumentasiRapat(xhr){
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

    $(document).on("submit",".form-delete-file", function (e){
        e.preventDefault()
        const url = $(this).attr("action")
        const formdata = $(this).serialize()
        if(confirm("Apakah anda ingin menghapus file ini ?")){
            $.post(url, formdata, function (response){
                alert(response.message)
                table_dokumentasi.ajax.reload( null, false )
            }).fail(function (xhr){
                alert("hapus data gagal")
            })
        }
        return false;
    })
</script>