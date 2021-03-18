<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index() {

	    $data = array(
	    	'titulo' => 'Seja bem vindo (a)!', 
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

	    $data['anuncios'] = $this->anuncios_model->get_all_anuncios_random(array('anuncios.anuncio_publicado' => 1));


	    $this->load->view('web/layout/header', $data);
	    $this->load->view('web/home/index');
	    $this->load->view('web/layout/footer');
    }
}

