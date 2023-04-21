@section("js")
    @include($path_view."form-item")
    <script type="text/javascript">
        class ItemLingkupPengawasan{
            id = ""
            nama = ""
        }
        const div_form_item = $("#form-group-item")
        const template = $("#template-item").clone().removeClass('d-none')
        let index = 1;

        const items = JSON.parse('{!!  isset($form)? json_encode($form->items):'[]'!!}');

        $(document).on('click','#add_item_view',function (e){
            addViewItem();
        })
        $(document).on('click','.delete-form',removeViewItem)
        $(document).on('submit','#form-submit',submit)
        function addViewItem(form = new ItemLingkupPengawasan){
            const v = template.clone()
            v.attr("id",index)
            console.log(v.find('.index-item'))
            v.find('.index-item').html(index)
            v.find('.form-input-name').attr('name','item['+index+']').val(form.nama)
            v.find('.form-input-id').attr('name','id['+index+']').val(form.id)
            v.find('.form-input-is-delete').attr('name','is_delete['+index+']')
            div_form_item.append(v)
            index+=1;
        }

        function removeViewItem(e){
            const card = $(this).parents(".card")
            const item  = $(card).find(".index-item").html()

            if(confirm("Anda yakin ingin menghapus Item "+item)){
                const form_is_delete = card.find('.form-input-is-delete')
                const form_id = card.find('.form-input-id')
                if(form_id.length > 0){
                    form_is_delete.val("true")
                    card.addClass("d-none")
                }else{
                    card.remove()
                }
            }
        }


        function getIndexOfArray(object = -1, array = []){
            let returnIndex = -1
            array.forEach(function (item, index){
                if (item == object)
                    returnIndex = index;
            });
            return returnIndex;
        }

        function submit(e){
            e.preventDefault()
            $("#id_items").val(getIdOfItem())
            const data = $(this).serialize()
            const url = $(this).attr('action')
            $.post(url, data, onSuccess)
                .fail(onFail)
            return false;
        }
        function getIdOfItem(){
            const ids = []
            const div_card = $(".card-item", $("#form-group-item"))
            div_card.each(function(item, index){
                ids.push($(this).attr("id"))
            })
            return ids.toString()
        }
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

        items.forEach(function(item, index){
            form = new ItemLingkupPengawasan();
            form.id = item.id;
            form.nama = item.nama;
            addViewItem(form)
        })

    </script>
@endsection