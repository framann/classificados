<?php 

/*
* Funções que serão utilizadas tanto na área rstrita, como na área publica
*/

defined('BASEPATH') OR exit ('Ação não permitida');

class Anuncios_model extends CI_Model {

    /*
    * Função que lista todos os anuncios do anunciante logado
    * E tambem lista todos os anuncios para o administrador (area restrita)
    */

    public function get_all($user_id = null) {

   	   $this->db->select([
   	   	   'anuncios.*',
           'categorias.categoria_nome',
   	   	   'categorias_pai.categoria_pai_nome',
   	   	   'users.id',
   	   	   'users.first_name',
   	   	   'anuncios_fotos.foto_nome',
   	   	]);



        /*
         *Não foi informado o $user_id, retorna apenas os anuncios daquele usuario (anunciante)
        */
        if ($user_id) {

        	$this->db->where('anuncios.anuncio_user_id', $user_id);
        }


        $this->db->join('categorias', 'categorias.categoria_id = anuncios.anuncio_categoria_id', 'LEFT');
        $this->db->join('categorias_pai', 'categorias_pai.categoria_pai_id = categorias.categoria_pai_id', 'LEFT'); 
        $this->db->join('anuncios_fotos', 'anuncios_fotos.foto_anuncio_id = anuncios.anuncio_id', 'LEFT');
        $this->db->join('users', 'users.id = anuncios.anuncio_user_id', 'LEFT');


        $this->db->group_by('anuncios.anuncio_id');

        return $this->db->get('anuncios')->result();
   }



  public function get_by_id($condicoes = null) {


       $this->db->select([
           'anuncios.*',
           'categorias.categoria_id',
           'categorias.categoria_nome',
           'categorias.categoria_meta_link',
           'categorias_pai.categoria_pai_nome',
           'categorias_pai.categoria_pai_meta_link',
           'users.id',
           'CONCAT(users.first_name, "", users.last_name) as nome_anunciante',
           'users.phone as telefone_anunciante',
           'users.created_on as anunciante_desde',
        ]);


        if (is_array($condicoes)) {

          $this->db->where($condicoes);
        }


        $this->db->join('categorias', 'categorias.categoria_id = anuncios.anuncio_categoria_id');
        $this->db->join('categorias_pai', 'categorias_pai.categoria_pai_id = anuncios.anuncio_categoria_pai_id'); 
        $this->db->join('users', 'users.id = anuncios.anuncio_user_id');

        return $this->db->get('anuncios')->row();
   }


   /*
   *Recuperamos todas as categorias pai, onde a categoria filha esteja atrelada a categoria pai
   *Utilizado para editar um anuncio
   */


   public function get_all_categorias_pai() {

    $this->db->select([
        'categorias_pai.*',
    ]);


    $this->db->where('categorias_pai.categoria_pai_ativa', 1);

    $this->db->join('categorias', 'categorias.categoria_pai_id = categorias_pai.categoria_pai_id');

    $this->db->group_by('categorias_pai.categoria_pai_id');

    return $this->db->get('categorias_pai')->result();


   }

}

?>