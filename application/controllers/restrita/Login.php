<?php 

/*
Controle responsavel pelo login na area restrita
*/

defined('BASEPATH') OR exit('Ação não permitida');

    class Login extends CI_Controller {


    public function index() {
        $data = array(
            'titulo' => 'Login na área restrita',
        );

        $this->load->view('restrita/layout/header');
        $this->load->view('restrita/login/index');
        $this->load->view('restrita/layout/footer');
    }

    public function auth() {

        /*
         [email] => lojasc@gmail.com
         [password] => 123456
         [remember] => on
        */


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
        }else{
            
            /*
            erro de login
            */
           $this->session->set_flashdata('erro', 'Verifique seus dados de acesso');
           redirect('restrita/' . $this->router->fetch_class());
        }

    }

    public function logout() {

        $this->ion_auth->logout();
        redirect('restrita/' . $this->router->fetch_class());

    }


}

