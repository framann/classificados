$(document).ready( function () {

	$('#busca').autocomplete({

        source: function (request, response) {


        	$.ajax({

        		url: BASE_URL + 'busca/busca_ajax',
        		type: 'post',
        		datatype: 'json',
        		data: 'busca=' + request.term,
        		success: function (data) {

        			if(data.response == "false") {

        				var result = [{
                                label: 'infelizmente não encontramos o que está procurando',
                                value: response.term
        				}];
        			    response(result);

        			} else {

        				response(data.message);

        			}

        		}, // fim-success


        	});// fim $.ajax

        }, // fim source
        minLength: 1,
        select: function (event, ui) {

        	if(ui.item.value === 'infelizmente não encontramos o que está procurando') {
               return false;
        	} else {

        		$('$busca').val(ui.item.value);
        			$(event,target.form).submit(); //submite o formulario ao clicar em uma opção do select do autocomplete

        	}

        }, //fim select


	}); //fim busca



}); // fim document