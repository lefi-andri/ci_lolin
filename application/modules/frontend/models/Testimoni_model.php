<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Testimoni_model extends CI_Model {

	public function get_testimoni()
	{
		$query = $this->db->get_where('testimoni', array('perbolehkan_tampil' => '1'));
		return $query;
	}

}

/* End of file Testimoni_model.php */
/* Location: ./application/modules/frontend/models/Testimoni_model.php */