<?php 

defined('BASEPATH') OR exit('No direct script acces allowed');

class Detalhes extends CI_Controller {


    public function index($anuncio_codigo = null) {

        if (!$anuncio_codigo || !$anuncio = $this->anuncios_model->get_by_id(array('anuncio_codigo' => $anuncio_codigo))) {
            redirect('/');
        } else {

            /*
            * Anuncio existe
            */

            /*
            * Jogamos na sessão o objeto anuncio anuncio que stá sendo detalhado apra compormos a pesquisa por estado, cidade, bairro, categoria principal.
            */

            $this->session->set_userdata('anuncio_detalhado', $anuncio);
            
           
           $data = array(
            'titulo' => 'Detalhes do anúncio ' . $anuncio->anuncio_titulo,
            'anuncio' => $anuncio,
            'anuncios_fotos' = $this->core_model->get_all('anuncios_fotos', array('foto_anuncio_id' => $anuncio->anuncio_id)),
            'todos_anuncios_anunciante' => $this->anuncios_model->get_all($anuncio->anuncio_user_id), // Recuperando todos os anuncios do dono do anuncio, detalhando.
        );

        

        $this->load->view('web/layout/header' $data);
        $this->load->view('web/detalhes/index');
        $this->load->view('web/layout/footer');

        } 

    }


}



