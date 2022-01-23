<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Foto_profile_model extends CI_Model {

	public function cari_gambar_foto_profile($id_reseller)
    {
    	$query = $this->db->get_where('meta', array('user_id' => $id_reseller));
    	return $query;
    }

}

/* End of file Foto_profile_model.php */
/* Location: ./application/modules/frontend/models/Foto_profile_model.php */