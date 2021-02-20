$('#master').on('change', function () {


	var anuncio_categoria_pai_id = $(this).val();
	

	if(anuncio_categoria_pai_id) {

		/*
		* Maravilha foi escolhida uma categoria principal, passamos agora apra o ajax request
		*/

		$.ajax({

			type: 'POST',
			dataType: 'json',
			url: BASE_URL + 'restrita/anuncios/get_categorias_filhas',
			data: {

				anuncio_categoria_pai_id: anuncio_categoria_pai_id,

			},
			success: function (data) {

                //Renderizamos o select option de categorias um texto para o administrador
                $('#anuncio_categoria').html('<option value="">Escolha uma categoria secundária</option>');



                if(data) {

                   /*
                    * Maravilha categorias filhas foram encontradas renderizamos as mesmas para o administrador/anunciante
                    */

                    /*
                    * Fazendo o foreach no data que veio como retorno
                    */
                    $(data).each(function () {

                        var option = $('<option />');

                         /*
                         * Na variavel 'option' setamaos no atributo value o id da categoria filha
                         * E no atributo 'text' o nome da categoria
                         */
                        option.attr('value', this.categoria_id).text(this.categoria_nome);

                        $('#anuncio_categoria').append(option);


                    });

                } else {

                	/*
                	* Se caiu aqui é porque não existe na base de dados nenhuma categoria filha atrelada a categoria pai informada
                	*/
                   $('#anuncio_categoria').html('<option value="">Categoria secundárias não encontradas</option>');


                }

			},

		});

         

	}else{

        /*
        * S e caiu aqui é porque não foi escolhida nenuma categoria principal
        *Dessa forma renderizamos um <option>Escolha uma categoria principal</option> na div anuncio categoria #anuncio_categoria
        */

        $('#anuncio_categoria').html('<option value="">Escolha uma categoria principal</option>');

	}


});






$('[name=anuncio_localizacao_cep]').focusout(function () {


	var anuncio_localizacao_cep = $(this).val();


	$.ajax({

		type: 'POST',
		url: BASE_URL + 'restrita/anuncios/valida_anuncio_localizacao_cep',
		dataType: 'json',
		data: {

			anuncio_localizacao_cep: anuncio_localizacao_cep,

		},
		beforeSend: function () {
			$('#anuncio_localizacao_cep').html('<i class="fas fa-cog fa-spin text-info"></i>&nbsp; Consultando CEP');
		},
		success: function (response) {

			if(response.erro === 0){

				$('#anuncio_localizacao_cep').html(response.anuncio_localizacao_cep);
                
            }else{

            	$('#anuncio_localizacao_cep').html(response.anuncio_localizacao_cep);


            }

		},
		error: function () {

		   $('#anuncio_localizacao_cep').html('Não foi possível consultar seu CEEP, tente novamente em alguns minutos');

		}

	});


});