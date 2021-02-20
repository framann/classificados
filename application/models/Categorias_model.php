<?php 

defined('BASEPATH') OR exit('Ação não permitida');

class Categorias_model extends CI_model{

	public function get_all_categorias() {


		$this->db->select([
			'categorias.*',
            'categorias_pai.categorias_pai_nome',
		]);

		$this->db->join('categorias_pai', 'categorias_pai.categoria_pai_id = categorias.categoria_pai_id');

		$this->db->order_by('categorias.categoria_id', 'DESC');

		return $this->db->get('categorias')->result();

	}
}

?>