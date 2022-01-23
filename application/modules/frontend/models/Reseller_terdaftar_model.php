<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reseller_terdaftar_model extends CI_Model {

	public function get_reseller_terdaftar(){
		$this->db->select('nama_toko, link_toko');
		$query = $this->db->get_where('meta', array('nama_toko !=' => ''));
		return $query;
	}

}

/* End of file Reseller_terdaftar_model.php */
/* Location: ./application/modules/frontend/models/Reseller_terdaftar_model.php */