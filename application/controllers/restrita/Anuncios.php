<?php 

 /*
 *controle por gerenciar as categorias filhas (Master)
 */

defined('BASEPATH') OR exit ('Acao não permitida');

class Anuncios extends CI_Controller {

  public function __construct() {
    parent::__construct();

       /*
       * definir se ha sessão valida
       */
      if (!$this->ion_auth->logged_in())  {
        redirect('restrita/login');
      }

       /*
       definir se é admin
       se não for, será redirecionado para parte publica
        */
      //  if (!$this->ion_auth->is_admin()) {
      //    redirect('/');
      //  }


    }

    public function index() {

      $data = array(
        'titulo' => 'Anuncios cadastrados',
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


      if ($this->ion_auth->is_admin()) {
          $data['anuncios'] = $this->anuncios_model->get_all(); // não é informado nenhum parametro quando é admin
      } else {
          $data['anuncios'] = $this->anuncios_model->get_all($this->session->userdata('user_id'));
      }

       //echo '<pre>';
       //print_r($this->input->post());
       //exit();

      $this->load->view('restrita/layout/header', $data);
      $this->load->view('restrita/anuncios/index');
      $this->load->view('restrita/layout/footer');

    }

    public function core($anuncio_id = null) {


       /*
       *Função que só será utilizada para editar um anuncio
       */

      $anuncio_id = (int) $anuncio_id;

       /*
       *Verificamos se foi informado um $anuncio_id ou se o mesmo existe na base de dados
      */


      if (!$anuncio_id || !$anuncio = $this->anuncios_model->get_by_id(array('anuncio_id' => $anuncio_id))) {
        $this->session->set_flashdata('erro', 'anuncio não encontrado');
        redirect('restrita/' . $this->router->fetch_class());
      } else {

        /*
        *Maravilha confirmada a existencia do anuncio, passamos para as validações
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
           *Compondo o endereço completo do anuncio a partir dos dados do objeto 'anuncio_endereco_sessao' que esta na sessão atual
           * Mas só fazemos isso se o cep informado no post, for diferente do existente na base de dados
           */

          if ($anuncio->anuncio_localizacao_cep != $data['anuncio_localizacao_cep']){

           $anuncio_endereco_sessao = $this->session->userdata('anuncio_endereco_sessao');

           $data['anuncio_logradouro'] = $anuncio_endereco_sessao->logrouro;
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
         * contamos quantas iamgens vieram no POST
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
        * Chegamos na parte onde enviamos um email, informando ao anunciante para informar que o email foi publicado.
        * apenas e o anuncio for publicado
        */

        if ($this->input->post('anuncio_publicado') == 1){


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


            $this->email->from('from_email', '$sistema->sistema_nome_fantasia');
            $this->email->to('$sto_email');

            $this->email->subject('Boas noticias! seu anuncio foi publicado');
            $this->email->message('Ola '. $anunciante->first_name . ' ' . $anunciante->last_name . ', Seu anuncio foi publicado! <br><br>'
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

                $this->session->set_flashdata("erro", $thisemail->print_debugger('header'));
            }
        }

        redirect('restrita/' . $this->router->fetch_class());
    } else {

          /*
          * Erros de validação
          */


        $data = array(
            'titulo' => ' Editar anuncios',
            'styles' => array(
              'assets/jquery-upload-file/css/uploadfile.css',
              'assets/bundles/select2/dist/css/select2.min.css',
            ),
            'scripts' => array(
              'assets/sweetalert2/sweetalert2.all.min.js', //Para confirmar a exclusão da iamgem no formulario
              'assets/jquery-upload-file/js/jquery.uploadfile.min.js',
              'assets/jquery-upload-file/js/anuncios.js',
              'assets/mask/jquery.mask.min.js',
              'assets/bundles/select2/dist/js/select2.full.min.js',
              'assets/mask/custom.js',
              'assets/js/anuncios.js',
            ),

            'anuncio' => $anuncio,
            'fotos_anuncio' => $this->core_model->get_all('anuncios_fotos', array('foto_anuncio_id' => $anuncio->anuncio_id)),
            'categorias_pai' => $this->anuncios_model->get_all_categorias_pai(),
          );

          //echo '<pre>';
         //print_r($data);
          //exit();

          $this->load->view('restrita/layout/header', $data);
          $this->load->view('restrita/anuncios/core');
          $this->load->view('restrita/layout/footer');

        } 
      }       
    }




    public function get_categorias_filhas() {
      /*
      * Recupera todas as categorias filhas de acordo com a categoria pai que for informada no ajax request
      */

      if(!$this->input->is_ajax_request()) {
          exit('Ação não permitida');
      }


      $categorias = array();

      $anuncio_categoria_pai_id = $this->input->post('anuncio_categoria_pai_id');

      if($anuncio_categoria_pai_id){
          
          $categorias = $this->core_model->get_all('categorias', array('categoria_pai_id' => $anuncio_categoria_pai_id, 'categoria_ativa' => 1));

      }

      echo json_encode($categorias);
    }


    public function valida_anuncio_localizacao_cep() {

      /*
      * Função que valida se o cep informado é valido
      * caso sim, setamos na seção um objeto contendo todos os dados de endereço
      */

      if(!$this->input->is_ajax_request()) {
          exit('Ação não permitida');
      }

      $this->form_validation->set_rules('anuncio_localizacao_cep', 'Localização do anuncio', 'trim|required|exact_length[9]');

        /*
        retornara dados para o javascript anuncios.js
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


                   $cep = str_replace("-", "", $this->input->post('anuncio_localizacao_cep'));

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
                  $retorno['anuncio_localizacao_cep'] = '<span class="text-danger">Informe um cep validação</span>';
                } else {

                /*
                 sucesso na requisição ... o cep existe na base do viaCep
                 Agora setamos na seção um objeto contendo todos os dados de endereço do anuncio para que possamos recupera-lo
                 n metodo core()
                */

                 $this->session->set_userdata('anuncio_endereco_sessao', $resultado_requisicao);

                 $retorno['erro'] = 0;
                 $retorno['anuncio_localizacao_cep'] = '<span class="text-info">Seu CEP foi validado</span>';
               }
             } else {

                /*
                 erros de validação
                */

                 $retorno['erro'] = 3;
                 $retorno['anuncio_localizacao_cep'] = form_error('anuncio_localizacao_cep', '<div class="text-danger">', '</div>');
               }

            /*
             retorna os dados contidos no $retorno
            */

             echo json_encode($retorno);


    }


    public function upload() {

      $config['upload_path'] = './uploads/anuncios/';
      $config['allowed_types'] = 'jpg|png|JPG|PNG|Jpeg|JPEG';
      $config['encrypt_name'] = true;
      $config['max_size'] = 2048;
      $config['max_width'] = 1000;
      $config['max_height'] = 1000;

                /*
                 carregando a biblioteca 'upload' passando como parâmetro o $config
                */


                 $this->load->library('upload', $config);

                 if($this->upload->do_upload('foto_produto')) {

                  $data = array(
                    'erro' => 0,
                    'uploaded_data' => $this->upload->data(),
                    'foto_nome' => $this->upload->data('file_name'),
                    'mensagem' => 'Foto foi enviada com sucesso',
                  );

                    /*
                    criando uma copia da imagem um pouco menor (resize)
                    */

                    $config['image_library'] = 'gd2';
                    $config['source_image'] = './uploads/anuncios/' . $this->upload->data('file_name');
                    $config['new_image'] = './uploads/anuncios/small/' . $this->upload->data('file_name');
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
}