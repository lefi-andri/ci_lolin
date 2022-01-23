<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faq_model extends CI_Model {

	public function get_faq(){
		$query = $this->db->get('faq');
		return $query;
	}

}

/* End of file Faq_model.php */
/* Location: ./application/modules/frontend/models/Faq_model.php */