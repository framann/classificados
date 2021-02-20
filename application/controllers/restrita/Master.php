<?php 

/*
controle por gerenciar as categorias pai (Master)
*/

defined('BASEPATH') OR exit ('acao não permitida');

class Master extends CI_Controller {

    public function __construct() {
    	parent::__construct();

      /*
      definir se ha sessão valida
      */
      if (!$this->ion_auth->logged_in())  {
          redirect('restrita/login');
      }

      /*
      definir se é admin
      se não for, será redirecionado para parte publica
      */
      if (!$this->ion_auth->is_admin()) {
          redirect('/');
      }

      $this->load->model('categorias_model');
    }

    public function index() {

        $data = array(
            'titulo' => 'Categorias pai cadastradas',
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
        	'master' => $this->core_model->get_all('categorias_pai'),
        );

$this->load->view('restrita/layout/header', $data);
$this->load->view('restrita/master/index');
$this->load->view('restrita/layout/footer');

    }



     public function core($categoria_pai_id = null) {


        $categoria_pai_id = (int) $categoria_pai_id;


        if(!$categoria_pai_id){


            /*
            Cadastrando nova categoria
            */


            $this->form_validation->set_rules('categoria_pai_nome', 'Nome da categoria', 'trim|required|min_length[4]|max_length[45]|callback_valida_nome_categoria');
            $this->form_validation->set_rules('categoria_pai_classe_icone', 'icone da categoria', 'trim|required|min_length[3]|max_length[20]');


            if($this->form_validation->run()) {

                    /*
                     formulário validado ... salvando no banco de dados
                    */


                     $data = elements(
                      array(
                        'categoria_pai_nome',
                        'categoria_pai_classe_icone',
                        'categoria_pai_ativa',
                    ), $this->input->post()
                  );


                  /*
                   definindo o meta link da categoria
                  */

                   $data['categoria_pai_meta_link'] = url_amigavel($data['categoria_pai_nome']);

                   $data = html_escape($data);


                   $this->core_model->insert('categorias_pai', $data);
                   redirect('restrita/' . $this->router->fetch_class());
               } else {

                      /*
                       erros de validação
                      */

                       $data = array(
                        'titulo' => 'Cadastrar categoria pai',
                    );


                       $this->load->view('restrita/layout/header', $data);
                       $this->load->view('restrita/master/core');
                       $this->load->view('restrita/layout/footer');


                   }

        } else {


            /*
             categoria foi informada, contudo, devemos garantir a sua existencia na base de dados
            */


             if(!$categoria = $this->core_model->get_by_id('categorias_pai', array('categoria_pai_id' => $categoria_pai_id))) {
                $this->session->set_flashdata('erro', 'Categoria não foi encontrada');           
                redirect('restrita/' . $this->router->fetch_class());
            } else {


                /*
                 Maravilha categoria foi encontrada, passamos para as validações
                */

                 $this->form_validation->set_rules('categoria_pai_nome', 'Nome da categoria', 'trim|required|min_length[4]|max_length[45]|callback_valida_nome_categoria');
                 $this->form_validation->set_rules('categoria_pai_classe_icone', 'icone da categoria', 'trim|required|min_length[3]|max_length[20]');


                 if($this->form_validation->run()) {

                    /*
                     formulário validado ... salvando no banco de dados
                    */


                  $data = elements(
                          array(
                            'categoria_pai_nome',
                            'categoria_pai_classe_icone',
                            'categoria_pai_ativa',
                        ), $this->input->post()
                  );


                  /*
                   definindo o meta link da categoria
                  */

                   $data['categoria_pai_meta_link'] = url_amigavel($data['categoria_pai_nome']);

                   $data = html_escape($data);


                   $this->core_model->update('categorias_pai', $data, array('categoria_pai_id' => $categoria->categoria_pai_id));
                   redirect('restrita/' . $this->router->fetch_class());
                  } else {

                      /*
                       erros de validação
                      */

                       $data = array(
                        'titulo' => 'Editar categoria pai',
                        'categoria' => $categoria,
                    );


                       $this->load->view('restrita/layout/header', $data);
                       $this->load->view('restrita/master/core');
                       $this->load->view('restrita/layout/footer');


                 }
            }


        }

    }


    public function valida_nome_categoria($categoria_pai_nome){


        $categoria_pai_id = $this->input->post('categoria_pai_id');


        if(!$categoria_pai_id){

            /*
             cadastro . . .
            */

            if($this->core_model->get_by_id('categorias_pai', array('categoria_pai_nome' => $categoria_pai_nome, 'categoria_pai_id !=' => $categoria_pai_id))) {

                $this->form_validation->set_message('valida_nome_categoria', 'Essa categoria já existe');
                return false;

            } else {

                return true;

            }

        }else{

            /*
             editando ...
            */

        if($this->core_model->get_by_id('categorias_pai', array('categoria_pai_nome' => $categoria_pai_nome, 'categoria_pai_id !=' => $categoria_pai_id))) {

                $this->for_validation->set_message('valida_nome_categoria', 'Essa categoria já existe');
                return false;

            }else{

                return true;


            }

        }
    }


    public function delete($categoria_pai_id = null) {


        $categoria_pai_id = (int) $categoria_pai_id;


        if(!$categoria_pai_id ||!$categoria = $this->core_model->get_by_id('categorias_pai', array('categoria_pai_id' => $categoria_pai_id))) {
                $this->session->set_flashdata('erro', 'Categoria não foi encontrada');           
                redirect('restrita/' . $this->router->fetch_class());
            }


            if($categoria->categoria_pai_ativa == 1) {
                $this->session->set_flashdata('erro', 'Não é permitido excluir uma categoria pai que esteja ativa');           
                redirect('restrita/' . $this->router->fetch_class());
            }


            $this->core_model->delete('categorias_pai', array('categoria_pai_id' => $categoria->categoria_pai_id));
            redirect('restrita/' . $this->router->fetch_class());
    }

}