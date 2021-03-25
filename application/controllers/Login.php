<?php 

/*
Controle responsavel pelo login na area web
*/

defined('BASEPATH') OR exit('Ação não permitida');

    class Login extends CI_Controller {


    public function index() {
        $data = array(
            'titulo' => 'Login na área do anunciante',
        );

        $this->load->view('web/layout/header', $data);
        $this->load->view('web/login/index');
        $this->load->view('web/layout/footer');
    }

    public function auth() {


        $identity = $this->input->post('email');
        $password = $this->input->post('password');
        $remember = ($this->input->post('remember' ? TRUE : FALSE));


        if ($this->ion_auth->login($identity, $password, $remember)) {

            /*
             só permitiremos que o administrador faça login na area restrita
            */
           if($this->ion_auth->is_admin()) {
              redirect('restrita');
           } else {
              redirect('/');
           }
        } else {
            
            /*
            erro de login
            */
           $this->session->set_flashdata('erro', 'Verifique seus dados de acesso');
           redirect($this->router->fetch_class());
        }

    }

    public function logout() {

        $this->ion_auth->logout();
        redirect($this->router->fetch_class());
    }

}

