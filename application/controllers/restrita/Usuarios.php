<?php 

/*
controle por gerenciar os usuarios
*/

defined('BASEPATH') OR exit ('acao não permitida');

class Usuarios extends CI_Controller {

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
    }

    public function index() {

        $data = array(
            'usuarios' => $this->ion_auth->users()->result(),
            'titulo' => 'Usuarios cadastrados',
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

$this->load->view('restrita/layout/header', $data);
$this->load->view('restrita/usuarios/index');
$this->load->view('restrita/layout/footer');

    }

    public function core($usuario_id = null) {

        /*
         esse metodo será responsavel pela criação e edição de usuarios.
        */

        $usuario_id = (int) $usuario_id;

        if(!$usuario_id){
        /*
        cadastra um novo usuario
        */

        $this->form_validation->set_rules('first_name', 'Nome', 'trim|required|min_length[3]|max_length[45]');
        $this->form_validation->set_rules('last_name', 'Sobrenome', 'trim|required|min_length[3]|max_length[45]');
        $this->form_validation->set_rules('user_cpf', 'CPF', 'trim|required|exact_length[14]Callback_valida_cpf');
        $this->form_validation->set_rules('phone', 'Telefone', 'trim|required|min_length[14]|max_length[15]Callback_valida_telefone');
        $this->form_validation->set_rules('email', 'E-mail', 'trim|required|valid_email|max_length[150]Callback_valida_email');
        $this->form_validation->set_rules('user_cep', 'CEP', 'trim|required|exact_length[9]');
        $this->form_validation->set_rules('user_endereco', 'Endereco', 'trim|required|min_length[5]|max_length[45]');
        $this->form_validation->set_rules('user_numero_endereco', 'Numero', 'trim|max_length[45]');
        $this->form_validation->set_rules('user_bairro', 'Bairro', 'trim|required|min_length[3]|max_length[45]');
        $this->form_validation->set_rules('user_cidade', 'Cidade', 'trim|required|min_length[3]|max_length[45]');
        $this->form_validation->set_rules('user_estado', 'Estado', 'trim|required|exact_length[2]');
        $this->form_validation->set_rules('user_foto', 'Avatar', 'trim|required');
       
        $this->form_validation->set_rules('password', 'Senha', 'trim|required|min_length[6]|max_length[200]');
        $this->form_validation->set_rules('confirma_senha', 'Confirma senha', 'trim|matches[password]');


        if ($this->form_validation->run()) {


                /*
                 Sucesso formulário foi validado, agora damos sequencia
                */

                $username = $this->input->post('first_name') .'-' . $this->input->post('last_name');
                $password = $this->input->post('password');
                $email = $this->input->post('email');

                 
                $additional_data = elements(
                    array(
                        'first_name',
                        'last_name',
                        'user_cpf',
                        'phone',
                        'user_cep',
                        'user_endereco',
                        'user_numero_endereco',
                        'user_bairro',
                        'user_cidade',
                        'user_estado',
                        'active',
                        'user_foto',
                    ), $this->input->post()
                );
                

                $group = array($this->input->post('perfil')); //Admin ou anunciante

                if($this->ion_auth->register($username, $password, $email, $additional_data, $group)) {

                   $this->session->set_flashdata('sucesso', 'Usuário criado com sucesso');
                }else{

                    $this->session->set_flashdata('erro', $this->ion_auth->errors());
                }

                redirect('restrita/' . $this->router->fetch_class());
            } else {

                /*
                 erros de validação
                */


                 $data = array(
                    'titulo' => 'Cadastrar usuário',
                    'scripts' => array(
                        'assets/mask/jquery.mask.min.js',
                        'assets/mask/custom.js',
                        'assets/js/usuarios.js',
                    ),
                    'grupos' => $this->ion_auth->groups()->result(),
                );

            //echo '<pre>';
            //print_r($data);
            //exit();

                 $this->load->view('restrita/layout/header', $data);
                 $this->load->view('restrita/usuarios/core');
                 $this->load->view('restrita/layout/footer');

             }

         } else {

            /*
            verificamos que o usuario_id ja existe no banco de dados
            */
        if(!$usuario = $this->ion_auth->user($usuario_id)->row()) {

           $this->session->set_flashdata('erro', 'Usuário não foi encontrado');
           redirect('restrita/' . $this->router->fetch_class());
       } else {

           /*
              Maravilha usuario foi encontrado, agora passamos para as validações
           */

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

                /*echo '<pre>';
                print_r($this->input->post());
                exit();
                */
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
                        'active',
                        'user_foto',
                    ), $this->input->post()
                 );

                 /*
                  removo do array $data e passwor caso o mesmo não seja informado, pois não é obrigatório
                 */


                 if($data['password']){
                    unset($data['password']);
                 }


                /*
                 populamos o $id com o id do objeto (é mais seguro);
                */


                 $id = $usuario->id;

                
                 if($this->ion_auth->update($id, $data)){


                    /*
                    atualizamos o grupo de acesso do usuario
                    */
                    $perfil = (int) $this->input->post('perfil');

                    $this->ion_auth->remove_from_group(NULL, $id);
                    $this->ion_auth->add_to_group($perfil, $id);


                     $this->session->set_flashdata('sucesso', 'Usuário atualizado com sucesso');
                 }else {
                    $this->session->set_flashdata('erro', $this->ion_auth->errors());
                 }

                redirect('restrita/' . $this->router->fetch_class());
            } else {

                /*
                 erros de validação
                */

               
                $data = array(
                'titulo' => 'Editando usuário',
                'scripts' => array(
                    'assets/mask/jquery.mask.min.js',
                    'assets/mask/custom.js',
                    'assets/js/usuarios.js',

            ),

                'usuario' => $usuario,
                'perfil' => $this->ion_auth->get_users_groups($usuario->id)->row(),
                'grupos' => $this->ion_auth->groups()->result(),
            );

            //echo '<pre>';
            //print_r($data);
            //exit();
            
            $this->load->view('restrita/layout/header', $data);
            $this->load->view('restrita/usuarios/core');
            $this->load->view('restrita/layout/footer');

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
        }else{
             
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


        if($usuario_id){

            /*
             cadastrando
            */

             if($this->core_model->get_by_id('users', array('phone' =>$phone))){

                $this->form_validation->set_message('valida_telefone', 'Este telefone já existe');

                return false;
             }else{
                return true;
             }
        }else{

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
        }else{

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

    public function delete($usuario_id = NULL) {


        $usuario_id = (int) $usuario_id;


        if(!$usuario_id || !$usuario =  $this->ion_auth->user($usuario_id)->row()){
            $this->session->set_flashdata('erro', 'Usuário não foi encontrado');
            redirect('restrita/' . $this->router->fetch_class());
        }

        if (!$this->ion_auth->is_admin($usuario->id)){
            $this->session->set_flashdata('erro', 'Não é permitido excluir um administrador');
            redirect('restrita/' . $this->router->fetch_class());
        }


         if ($this->ion_auth->delete_user($usuario->id)){

            /*
             maravilha exluimos o usuario, agora passamos para exlusão das imagens do diretório uploads/usuarios
            */


            /*
             recuperamos a imagem
            */


            $user_foto = $usuario->user_foto;

            $imagem_grande = FCPATH . 'uploads/usuarios/' . $user_foto;
            $imagem_pequena = FCPATH . 'uploads/usuarios/small' . $user_foto;

            if(file_exists($imagem_grande)){
                unlink($imagem_grande);
            }

            if(file_exists($imagem_pequena)){
                unlink($imagem_pequena);
            }
            

            $this->session->set_flashdata('sucesso', 'Usuário excluido com sucesso');

        }else{

            /*
             Não foi possivel excluir
            */


            $this->session->set_flashdata('erro', $this->ion->auth->errors());
        }


        redirect('restrita/' .$this->router->fetch_class());
    }

}


 ?>
