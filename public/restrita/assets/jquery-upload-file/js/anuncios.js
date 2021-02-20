$(document).ready(function ()
{
    $("#fileuploader").uploadFile({
        url: BASE_URL + "restrita/anuncios/upload",
        fileName: "foto_produto",
        returnType: "json",
        onSuccess: function (files, data) {

            if (data.erro === 0) {
                $("#uploaded_image").append('<ul style="list-style: none; display: inline-block"><li><img src="' + BASE_URL + 'uploads/anuncios/' + data.uploaded_data['file_name'] + '" width="80" class="img-thumbnail mb-2 mr-1"><input type="hidden" name="fotos_produtos[]" value="' + data.foto_nome + '"><button type="button" class="btn btn-sm btn-danger btn-icon btn-block btn-remove text-white mx-auto mb-30" style="width: 50px"><i class="fa fa-times"></i></a></li></ul>');
            } else {

                $("#erro_uploaded").html(data.mensagem);
            }

        },
    });


    $('#uploaded_image').on('click', '.btn-remove', function () {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn bg-danger text-white ml-2',
                cancelButton: 'btn bg-primary text-white mr-20'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Tem certeza da exclusão?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '<i class="fa fa-exclamation-circle"></i>&nbsp;&nbsp;Excluir!',
            cancelButtonText: '<i class="fa fa-arrow-circle-left"></i>&nbsp;&nbsp;Cancelar!',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $(this).parent().remove();
            } else {
                return false;
            }
        })
    });

});