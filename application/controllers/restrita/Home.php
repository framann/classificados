<?php 

/*
Controle responsavel pela Home da area restrita do projeto
*/

defined('BASEPATH') OR exit('Ação não permitida');

class Home extends CI_Controller {

    public function __construct() {
        parent:: __construct();

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

    }

    public function index() {

        $this->load->view('restrita/layout/header');
        $this->load->view('restrita/home/index');
        $this->load->view('restrita/layout/footer');

    }


}