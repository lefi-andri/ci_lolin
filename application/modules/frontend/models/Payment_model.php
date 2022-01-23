<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_model extends CI_Model {

	public function get_data_reseller_on_mail($id){
		$query = $this->db->get_where('users', array('id'=>$id))->row();
		return $query;
	}

}

/* End of file Payment_model.php */
/* Location: ./application/modules/frontend/models/Payment_model.php */