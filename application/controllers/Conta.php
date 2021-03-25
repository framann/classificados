<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Conta extends CI_Controller {

	public function __construct()  {
		parent::__construct();


		if(!$this->ion_auth->logged_in()) {
			redirect('login');
		}
	}

	public function index() {

		/*
		* Montando um objeto com os dados do anunciante logado para enviar para view
		* e compor a pesquisa por total dos anuncios cadastrados
		*/

		$anunciante = get_info_anunciante();

	    $data = array(
	        'titulo' => 'Gerenciar minha conta',
          'anunciante' => $anunciante,
	        'total_anuncios_cadastrados' => $this->core_model->count_all_results('anuncios', array('anuncio_user_id' => $anunciante->id)),
	    );
        

	    $this->load->view('web/layout/header', $data);
	    $this->load->view('web/conta/index');
	    $this->load->view('web/layout/footer');
}

public function perfil() {

         /*
         * Recuperamos da sessão ouser_id do anunciante logado para realizar a edição do perfil
         */
	$user_id = $this->session->userdata('user_id');

	/*
	* Se a variavel 'user_id' não contiver um valor, redirecionamos para o login
	*/

	if(!$user_id) {
		redirect('login');
	} else {

		/*
		 * Maravilha 'user_id' contém um valor podemos continuar a edição
		 */

		/*
		 * Recuperamos os dados do anunciante logado, para enviarmos para a view
		 */

		$usuario = get_info_anunciante();


		    $this->form_validation->set_rules('first_name', 'Nome', 'trim|required|min_length[3]|max_length[45]');
            $this->form_validation->set_rules('last_name', 'Sobrenome', 'trim|required|min_length[3]|max_length[45]');
            $this->form_validation->set_rules('user_cpf', 'CPF', 'trim|required|exact_length[14]Callback_valida_Cpf');
            $this->form_validation->set_rules('phone', 'Telefone', 'trim|required|min_length[14]|max_length[15]Callback_valida_telefone');
            $this->form_validation->set_rules('email', 'E-mail', 'trim|required|valid_email|max_length[150]Callback_valida_email');
            $this->form_validation->set_rules('user_cep', 'CEP', 'trim|required|exact_length[9]');
            $this->form_validation->set_rules('user_endereco', 'Endereco', 'trim|required|min_length[5]|max_length[45]');
            $this->form_validation->set_rules('user_numero_endereco', 'Numero', 'trim|max_length[45]');
            $this->form_validation->set_rules('user_bairro', 'Bairro', 'trim|required|min_length[3]|max_length[45]');
            $this->form_validation->set_rules('user_cidade', 'Cidade', 'trim|required|min_length[3]|max_length[45]');
            $this->form_validation->set_rules('user_estado', 'Estado', 'trim|required|exact_length[2]');
            $this->form_validation->set_rules('user_foto', 'Avatar', 'trim|required');

            $this->form_validation->set_rules('password', 'Senha', 'trim|min_length[6]|max_length[200]');
            $this->form_validation->set_rules('confirma_senha', 'Confirma senha', 'trim|matches[password]');


            if($this->form_validation->run()) {
                
                 $data = elements(
                    array(
                        'first_name',
                        'last_name',
                        'password',
                        'user_cpf',
                        'phone',
                        'email',
                        'user_cep',
                        'user_endereco',
                        'user_numero_endereco',
                        'user_bairro',
                        'user_cidade',
                        'user_estado',
                        'user_foto',
                    ), $this->input->post()
                 );

                 /*
                  removo do array $data e passwor caso o mesmo não seja informado, pois não é obrigatório
                 */


                 if (!$data['password']){
                    unset($data['password']);
                 }


                /*
                 populamos o $id com o id do objeto (é mais seguro);
                */


                 $id = $usuario->id;

                
                 if ($this->ion_auth->update($id, $data)) {

                     $this->session->set_flashdata('sucesso', 'Seu perfil atualizado com sucesso');
                 }else {
                     $this->session->set_flashdata('erro', $this->ion_auth->errors());
                 }

                redirect($this->router->fetch_class() . '/perfil');
            } else {

            	/*
            	* Erros de validação
            	*/

            	$data = array(
            		'titulo' => 'Gerenciar meu perfil',
            		'scripts' => array(
                        'assets/mask/jquery.mask.min.js',
                        'assets/mask/custom.js',
                        'assets/js/anunciantes.js',
                    ),

            		'usuario' => $usuario,
            	);

            	$this->load->view('web/layout/header', $data);
            	$this->load->view('web/conta/perfil');
            	$this->load->view('web/layout/footer');
            }
	    }   
    }


    public function anuncios() {

        /*
        * Montamos um objeto do anunciante logado
        */

        $anunciante = get_info_anunciante();

        $data = array(
            'titulo' => 'Meus anuncios',
            'styles' => array(
              'assets/bundles/datatables/datatables.min.css',
              'assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css',
          ),
            'scripts' => array(
              'assets/bundles/datatables/datatables.min.js',
              'assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js',
              'assets/bundles/jquery-ui/jquery-ui.min.js',
              'assets/js/page/datatables.js',
          ),
        );

        /*
        *  Só enviamos para a view se existir pelo menos um anuncio cadastrado do anunciante logado
        */


        if ($anuncios = $this->anuncios_model->get_all($anunciante->id)) {
           $data['anuncios'] = $anuncios;
        }

        $this->load->view('web/layout/header', $data);
        $this->load->view('web/conta/anuncios');
        $this->load->view('web/layout/footer');
}



    public function core($anuncio_id = null) {


       /*
       *Função utilizada para editar ou cadastrar um anuncio
       */

       $anuncio_id = (int) $anuncio_id;

       if(!$anuncio_id) {

        /*
        * Cadastrando
        */

         
        $this->form_validation->set_rules('anuncio_titulo', 'Titulo do anuncio', 'trim|required|min_length[4]|max_length[240]');
        $this->form_validation->set_rules('anuncio_preco', 'Preço do anuncio', 'trim|required');
        $this->form_validation->set_rules('anuncio_categoria_pai_id', 'Categoria principal', 'trim|required');
        $this->form_validation->set_rules('anuncio_categoria_id', 'Categoria secundária', 'trim|required');
        $this->form_validation->set_rules('anuncio_situacao', 'Situação do Item', 'trim|required');

        $this->form_validation->set_rules('anuncio_localizacao_cep', 'CEP do anuncio', 'trim|required|exact_length[9]');
        $this->form_validation->set_rules('anuncio_descricao', 'Descrição do anuncio', 'trim|required|min_length[10]|max_length[5000]');

        /*
        *Para revalidarmos o campo fotos_produtos, que é do tipo array, temos que faze-lo da seguinte forma.
        */

        $fotos_produtos = $this->input->post('fotos_produtos');

        if (!$fotos_produtos) {
          $this->form_validation->set_rules('fotos_produtos', 'Imagens do anuncio', 'trim|required');
      }


      if ($this->form_validation->run()) {

          $data = elements(
            array(
              'anuncio_codigo',
              'anuncio_titulo',
              'anuncio_preco',
              'anuncio_categoria_pai_id',
              'anuncio_categoria_id',
              'anuncio_publicado',
              'anuncio_situacao',
              'anuncio_localizacao_cep',
              'anuncio_descricao',
          ), $this->input->post()
        );

           /*
           * Precisamos editar o anun cio, por tanto deixamos não publicado
           */
           $data['anuncio_publicado'] = 0;

           /*
           * Referenciando o id do anunciante logado
           */
           $data['anuncio_user_id'] = $this->session->userdata('user_id');

           /*
           * Recuperamos da sessão o objeto 'anuncio_endereco_sessao' para compor os dados de endereço d novo anúncio
           */


           $anuncio_endereco_sessao = $this->session->userdata('anuncio_endereco_sessao');

           $data['anuncio_logradouro'] = $anuncio_endereco_sessao->logradouro;
           $data['anuncio_bairro'] = $anuncio_endereco_sessao->bairro;
           $data['anuncio_cidade'] = $anuncio_endereco_sessao->localidade;
           $data['anuncio_estado'] = $anuncio_endereco_sessao->uf;

            /*
            *Montando o meta links do endereço
            */
           $data['anuncio_bairro_metalink'] = url_amigavel($data['anuncio_bairro']);
           $data['anuncio_cidade_metalink'] = url_amigavel($data['anuncio_cidade']);

           
             /*
             * Removemos da sessão o objeto $anuncio_sessao, não precisamos mais dele
             */

           $this->session->unset_userdata('anuncio_endereco_sessao');

            /*
            * Removendo a virgula
            */

           $data['anuncio_preco'] = str_replace(',', '', $data['anuncio_preco']);

            /*
            * Cadastramos o anuncio 
            */
           $this->core_model->insert('anuncios', $data, TRUE);

           /*
            *  e recuperamos da sessão o ultimo id inserido na tabela anúncios
            * ou seja o anuncio_id
            */

           $anuncio_id = $this->session->userdata('last_id');


           $fotos_produtos = $this->input->post('fotos_produtos');

            /*
            * contamos quantas imagens vieram no POST
            */
           $total_fotos = count($fotos_produtos);

           for($i = 0; $i < $total_fotos; $i++) {

          $data = array(
            'foto_anuncio_id' => $anuncio_id,
            'foto_nome' => $fotos_produtos[$i],
        );

          $this->core_model->insert('anuncios_fotos', $data);
      }


           /*
             * Montamos um objeto com todos os dados do anunciante
             */
           $anunciante = $this->ion_auth->user($anuncio->anuncio_user_id)->row();

            /*
             * Montamos um objeto com todos os dados do website porque precisamos do email
            */

            $sistema = info_header_footer();

            $this->email->set_mailtype("html");
            $this->email->set_newline("\r\n");

            $from_email = $sistema->sistema_email;

            $to_email = $anunciante->email;


            //$this->email->from('from_email', '$sistema->sistema_nome_fantasia');
            $this->email->to('$sto_email');

            $this->email->subject('Falta muito pouco para seu anuncio ser publicado');
            $this->email->message('Ola '. $anunciante->first_name . ' ' . $anunciante->last_name . ', Seu anuncio está em analise e muito em breve será publicado! <br>'
                . 'Assim que isso ocorrer enviaremos um email informando você. <br>'
                . '<strong>Título do anuncio: </strong>&nbsp;' . $this->input->post('anuncio_titulo'));


            $this->load->library('encryption'); // Evita o envio de span


            if($this->email->send(FALSE)){

              /*
              * Sucesso o email foi enviado
              *Não fazemos mais nada aqui
              */


          } else {

                /*
                * Não foi possivel enviar o email
                *Então jogamos no flashdata os erros que ocorreram
                */
                $this->session->set_flashdata("erro", $this->email->print_debugger('header'));
            } 

            redirect($this->router->fetch_class() . '/anuncios');
        } else {

          /*
          * Erros de validação
          */


          $data = array(
            'titulo' => 'Cadastrar anuncio',
            'styles' => array(
              'assets/jquery-upload-file/css/uploadfile.css',
              'assets/select2/select2.min.css',
          ),
            'scripts' => array(
              'assets/sweetalert2/sweetalert2.all.min.js', //Para confirmar a exclusão da iamgem no formulario
              'assets/jquery-upload-file/js/jquery.uploadfile.min.js',
              'assets/jquery-upload-file/js/anuncios.js',
              'assets/mask/jquery.mask.min.js',
              'assets/mask/custom.js',
              'assets/select2/select2.min.js',
              'assets/js/anuncios.js',
          ),

            'codigo_gerado' => $this->core_model->generate_unique_code('anuncios', 'numeric', 8, 'anuncio_codigo'),
            'categorias_pai' => $this->anuncios_model->get_all_categorias_pai(),
        );

        //  echo '<pre>';
        //  print_r($data);
        //  exit();

          $this->load->view('web/layout/header', $data);
          $this->load->view('web/conta/core');
          $this->load->view('web/layout/footer');

      } 

    } else {

        /*
        *  Editando
        */


        /*
       *Verificamos se o $anuncio_id existe na base de dados
      */


        if (!$anuncio = $this->anuncios_model->get_by_id(array('anuncio_id' => $anuncio_id))) {
            $this->session->set_flashdata('erro', 'anuncio não encontrado');
            redirect($this->router->fetch_class(). '/anuncios');
        } else {

            /*
            * Garantimos que o anunciante só possa editar um anuncio que seja eu
            */
             if ($anuncio->anuncio_user_id != $this->session->userdata('user_id')) {
                 $this->session->set_flashdata('erro', 'Este anuncio não está atribuido a sua conta de anunciante');
                 redirect($this->router->fetch_class(). '/anuncios');
        }

        /*
        *Maravilha confirmada a existencia do anuncio e que seja do anunciante logado, passamos para as validações
        */

        $this->form_validation->set_rules('anuncio_titulo', 'Titulo do anuncio', 'trim|required|min_length[4]|max_length[240]');
        $this->form_validation->set_rules('anuncio_preco', 'Preço do anuncio', 'trim|required');
        $this->form_validation->set_rules('anuncio_situacao', 'Situação do Item', 'trim|required');

        /*
        *Verifique se a categoria pai veio no post
        */

        $anuncio_categoria_pai_id = $this->input->post('anuncio_categoria_pai_id');


        /*
        *Caso sim, a categoria filha, se tornará obrigatória
        */



        if ($anuncio_categoria_pai_id) {
          $this->form_validation->set_rules('anuncio_categoria_id', 'Categoria secundária', 'trim|required');
      }



      $this->form_validation->set_rules('anuncio_localizacao_cep', 'CEP do anuncio', 'trim|required|exact_length[9]');
      $this->form_validation->set_rules('anuncio_descricao', 'Descrição do anuncio', 'trim|required|min_length[10]|max_length[5000]');

        /*
        *Para revalidarmos o campo fotos_produtos, que é do tipo array, temos que faze-lo da seguinte forma.
        */

        $fotos_produtos = $this->input->post('fotos_produtos');

        if (!$fotos_produtos) {
          $this->form_validation->set_rules('fotos_produtos', 'Imagens do anuncio', 'trim|required');
      }


      if ($this->form_validation->run()) {

          $data = elements(
            array(
              'anuncio_titulo',
              'anuncio_preco',
              'anuncio_categoria_pai_id',
              'anuncio_categoria_id',
              'anuncio_publicado',
              'anuncio_situacao',
              'anuncio_localizacao_cep',
              'anuncio_descricao',
          ), $this->input->post()
        );

           /*
           * Precisamos editar o anun cio, por tanto deixamos não publicado
           */
           $data['anuncio_publicado'] = 0;


           /*
           *Compondo o endereço completo do anuncio a partir dos dados do objeto 'anuncio_endereco_sessao' que esta na sessão atual
           * Mas só fazemos isso se o cep informado no post, for diferente do existente na base de dados
           */

           if ($anuncio->anuncio_localizacao_cep != $data['anuncio_localizacao_cep']){

               $anuncio_endereco_sessao = $this->session->userdata('anuncio_endereco_sessao');

               $data['anuncio_logradouro'] = $anuncio_endereco_sessao->logradouro;
               $data['anuncio_bairro'] = $anuncio_endereco_sessao->bairro;
               $data['anuncio_cidade'] = $anuncio_endereco_sessao->localidade;
               $data['anuncio_estado'] = $anuncio_endereco_sessao->uf;

           /*
           *Montando o meta links do endereço
           */
           $data['anuncio_bairro_metalink'] = url_amigavel($data['anuncio_bairro']);
           $data['anuncio_cidade_metalink'] = url_amigavel($data['anuncio_cidade']);

           
           /*
           * Removemos da sessão o objeto $anuncio_sessao, não precisamos mais dele
           */

           $this->session->unset_userdata('anuncio_endereco_sessao');

       }


       if (!$data['anuncio_categoria_pai_id']) {
          unset($data['anuncio_categoria_pai_id']);
      }

      if (!$data['anuncio_categoria_id']) {
          unset($data['anuncio_categoria_id']);
      }

         /*
         * Removendo a virgula
         */

         $data['anuncio_preco'] = str_replace(',', '', $data['anuncio_preco']);

         /*
         * Atualizamos o anuncio
         */
         $this->core_model->update('anuncios', $data, array('anuncio_id' => $anuncio->anuncio_id));


         /*
         * Deletamos as imagens antigas do anuncio
         */

         $this->core_model->delete('anuncios_fotos', array('foto_anuncio_id' => $anuncio->anuncio_id));


         $fotos_produtos = $this->input->post('fotos_produtos');

         /*
         * contamos quantas imagens vieram no POST
         */
         $total_fotos = count($fotos_produtos);

         for($i = 0; $i < $total_fotos; $i++) {

          $data = array(
            'foto_anuncio_id' => $anuncio->anuncio_id,
            'foto_nome' => $fotos_produtos[$i],
        );

          $this->core_model->insert('anuncios_fotos', $data);
      }

        
           /*
             * Montamos um objeto com todos os dados do anunciante
             */
             $anunciante = $this->ion_auth->user($anuncio->anuncio_user_id)->row();
             
            /*
             * Montamos um objeto com todos os dados do website porque precisamos do email
            */

            $sistema = info_header_footer();

            $this->email->set_mailtype("html");
            $this->email->set_newline("\r\n");

            $from_email = $sistema->sistema_email;

            $to_email = $anunciante->email;


            //$this->email->from('from_email', '$sistema->sistema_nome_fantasia');
            $this->email->to('$sto_email');

            $this->email->subject('Falta muito pouco para seu anuncio ser publicado');
            $this->email->message('Ola '. $anunciante->first_name . ' ' . $anunciante->last_name . ', Seu anuncio está em analise e muito em breve será publicado! <br>'
                    . 'Assim que isso ocorrer enviaremos um email informando você. <br>'
                    . '<strong>Título do anuncio: </strong>&nbsp;' . $this->input->post('anuncio_titulo'));


            $this->load->library('encryption'); // Evita o envio de span


            if($this->email->send(FALSE)){

              /*
              * Sucesso o email foi enviado
              *Não fazemos mais nada aqui
              */


          } else {

                /*
                * Não foi possivel enviar o email
                *Então jogamos no flashdata os erros que ocorreram
                */
                $this->session->set_flashdata("erro", $this->email->print_debugger('header'));
            } 

        redirect($this->router->fetch_class() . '/anuncios');
    } else {

          /*
          * Erros de validação
          */


          $data = array(
            'titulo' => 'Editar anuncios',
            'styles' => array(
              'assets/jquery-upload-file/css/uploadfile.css',
              'assets/select2/select2.min.css',
          ),
            'scripts' => array(
              'assets/sweetalert2/sweetalert2.all.min.js', //Para confirmar a exclusão da iamgem no formulario
              'assets/jquery-upload-file/js/jquery.uploadfile.min.js',
              'assets/jquery-upload-file/js/anuncios.js',
              'assets/mask/jquery.mask.min.js',
              'assets/mask/custom.js',
              'assets/select2/select2.min.js',
              'assets/js/anuncios.js',
          ),

            'anuncio' => $anuncio,
            'fotos_anuncio' => $this->core_model->get_all('anuncios_fotos', array('foto_anuncio_id' => $anuncio->anuncio_id)),
            'categorias_pai' => $this->anuncios_model->get_all_categorias_pai(),
        );

        //  echo '<pre>';
        //  print_r($data);
        //  exit();

          $this->load->view('web/layout/header', $data);
          $this->load->view('web/conta/core');
          $this->load->view('web/layout/footer');

        } 
     } 

    }

             
    }


    public function valida_cpf($cpf) {

        if ($this->input->post('usuario_id')) {

            /*
             Editando usuário
            */

            $usuario_id = $this->input->post('usuario_id');

            if ($this->core_model->get_by_id('users', array('id !=' => $usuario_id, 'user_cpf' => $cpf))) {
                $this->form_validation->set_message('valida_cpf', 'O campo {field} já existe, ele deve ser único');
                return FALSE;
            }
        } else {
             
             /*
              Cadastrando usuário
             */

            if ($this->core_model->get_by_id('users', array('user_cpf' => $cpf))) {
                $this->form_validation->set_message('valida_cpf', 'O campo {field} já existe, ele deve ser único');
                return FALSE;
            }
        }


        $cpf = str_pad(preg_replace('/[^0-9]/', '', $cpf), 11, '0', STR_PAD_LEFT);
        // Verifica se nenhuma das sequências abaixo foi digitada, caso seja, retorna falso
        if (strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999') {

            $this->form_validation->set_message('valida_cpf', 'Por favor digite um CPF válido');
            return FALSE;
        } else {
            // Calcula os números para verificar se o CPF é verdadeiro
            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf[$c] * (($t + 1) - $c); //Se PHP version < 7.4, $cpf{$c}
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf[$c] != $d) { //Se PHP version < 7.4, $cpf{$c}
                    $this->form_validation->set_message('valida_cpf', 'Por favor digite um CPF válido');
                    return FALSE;
                }
            }
            return TRUE;
        }
    }

    public function valida_telefone($phone) {


        $usuario_id = $this->input->post('usuario_id');


        if($usuario_id) {

            /*
             cadastrando
            */

             if($this->core_model->get_by_id('users', array('phone' =>$phone))) {

                $this->form_validation->set_message('valida_telefone', 'Este telefone já existe');

                return false;
             } else {
                return true;
             }
        } else {

            /*
             Editando 
            */

             if($this->core_model->get_by_id('users', array('phone' =>$phone, 'id !=' =>$usuario_id))){

                $this->form_validation->set_message('valida_telefone', 'Este telefone já existe');

                return false;
             }else{
                return true;
             }
        }
    }

    public function valida_email($email) {


        $usuario_id = $this->input->post('usuario_id');


        if($usuario_id){

            /*
             cadastrando
            */

             if($this->core_model->get_by_id('users', array('email' => $email))){

                $this->form_validation->set_message('valida_email', 'Este email já existe');

                return false;
             }else{
                return true;
             }
        } else {

            /*
             Editando 
            */

             if($this->core_model->get_by_id('users', array('email' => $email, 'id !=' =>$usuario_id))){

                $this->form_validation->set_message('valida_email', 'Este email já existe');

                return false;
             }else{
                return true;
             }
        }
    }


    public function preenche_endereco() {


        if(!$this->input->is_ajax_request()) {
            exit('Ação não permitida');
        }

        $this->form_validation->set_rules('user_cep', 'cep', 'trim|required|exact_length[9]');

        /*
        retornara dados para o javascript usuarios.js
        */

        $retorno = array();

            if ($this->form_validation->run()) {

                /*
                cep validado quanto a seu formato
                passamos para o inicio da requisição
                */

                /*
                  https://viacep.com.br/ws/01001000/json/
                */

                  /*
                   formatando o cep de acordo com que é definido pela API ViaCep
                  */
                

                $cep = str_replace("-", "", $this->input->post('user_cep'));

                $url = "https://viacep.com.br/ws/";
                $url .= $cep;
                $url .= "/json/";

                $cr = curl_init();

                /*
                 define a url e busca (requisição)
                */
                curl_setopt($cr, CURLOPT_URL, $url);


                curl_setopt($cr, CURLOPT_RETURNTRANSFER, true);

                $resultado_requisicao = curl_exec($cr);

                curl_close($cr);

                /*
                 transformando o resultado em um objeto para facilitar o acesso aos seus atributos
                */

                $resultado_requisicao = json_decode($resultado_requisicao);
                
                /*
                verifiamos se o cep informado é existente,
                caso não exista, retornamos para o javascript que o cep é valido
                caso cep seja existente, retornamos as informações do endereço
                */

    
                if(isset($resultado_requisicao->erro)) {

                    $retorno['erro'] = 3;
                    $retorno['user_cep'] = 'informe um cep válido';
                    $retorno['mensagem'] = 'informe um cep válido';
                }else {

                /*
                 sucesso na requisição ... o cep existe na base do viaCep
                */

                    $retorno['erro'] = 0;
                    $retorno['user_endereco'] = $resultado_requisicao->logradouro;
                    $retorno['user_bairro'] = $resultado_requisicao->bairro;
                    $retorno['user_cidade'] = $resultado_requisicao->localidade;
                    $retorno['user_estado'] = $resultado_requisicao->uf;
                    $retorno['mensagem'] = 'Cep encontrado';
                }


            }else {

                /*
                 erros de validação
                */

                $retorno['erro'] = 3;
                $retorno['user_cep'] = validation_errors();
                $retorno['mensagem'] = 'Cep inválido';
            }

            /*
             retorno os dados contidos no $retorno
            */

            echo json_encode($retorno);

    }

    public function upload_file() {

                $config['upload_path'] = './uploads/usuarios/';
                $config['allowed_types'] = 'jpg|png|JPG|PNG|Jpeg|JPEG';
                $config['encrypt_name'] = true;
                $config['max_size'] = 1048;
                $config['max_width'] = 500;
                $config['max_height'] = 500;
                $config['min_width'] = 350;
                $config['min_height'] = 340;

                /*
                 carregando a biblioteca 'upload' passando como parâmetro o $config
                */


                $this->load->library('upload', $config);

                if($this->upload->do_upload('user_foto_file')) {

                    $data = array(
                        'erro' => 0,
                        'foto_enviada' => $this->upload->data(),
                        'user_foto' => $this->upload->data('file_name'),
                        'mensagem' => 'Foto foi enviada com sucesso',
                    );

                    /*
                    criando uma copia da imagem um pouco menor (resize)
                    */

                    $config['image_library'] = 'gd2';
                    $config['source_image'] = './uploads/usuarios/' . $this->upload->data('file_name');
                    $config['new_image'] = './uploads/usuarios/small/' . $this->upload->data('file_name');
                    $config['width']  = 300;
                    $config['height'] = 280;

                    $this->load->library('image_lib', $config);

                    /*
                     verificamos se ouve erro no resize
                    */

                    if(!$this->image_lib->resize()) {

                        $data['erro'] = 3;
                        $data['mensagem'] = $this->image_lib->display_errors('<span class="text-danger">', '</span>');
                    }

                } else {

                    /*
                     erros no upload da imagem
                    */

                     $data = array(

                        'erro' => 3,
                        'mensagem' => $this->upload->display_errors('<span class="text-danger">', '</span>'),
                     );
                }

                echo json_encode($data);
    }

    /*
    *      Função que exclui o anuncio da base de dados
    */

    public function delete($anuncio_id = null) {
        $anuncio_id = (int) $anuncio_id;


        if (!$anuncio_id || !$anuncio = $this->anuncios_model->get_by_id(array('anuncio_id' => $anuncio_id))) {
            $this->session->set_flashdata('erro', 'anuncio não encontrado');
            redirect($this->router->fetch_class() . '/anuncios');
        }


        /*
        * Garantimos que o anunciante só possa editar um anuncio que seja eu
        */
        if ($anuncio->anuncio_user_id != $this->session->userdata('user_id')) {
            $this->session->set_flashdata('erro', 'Este anuncio não está atribuido a sua conta de anunciante');
            redirect($this->router->fetch_class() . '/anuncios');
        }
         

        /*
        * Recuperamos todas as iamgens do anuncio
        */
        $fotos_anuncio = $this->core_model->get_all('anuncios_fotos', array('foto_anuncio_id' => $anuncio->anuncio_id));

        /*
        * Excluo o anuncio
        */
        $this->core_model->delete('anuncios', array('anuncio_id' => $anuncio->anuncio_id));


        /*
        * Excluindo as imagens
        */
        if($fotos_anuncio) {

            foreach ($fotos_anuncio as $foto) {

                $foto_grande = FCPATH . 'uploads/anuncios/' . $foto->foto_nome;
                $foto_pequena = FCPATH . 'uploads/anuncios/small' . $foto->foto_nome;


                if(file_exists($foto_grande)) {
                    unlink($foto_grande);
                }

                 if(file_exists($foto_pequena)) {
                    unlink($foto_pequena);
                }
            }
        }

         redirect($this->router->fetch_class() . '/anuncios');


    }

}

