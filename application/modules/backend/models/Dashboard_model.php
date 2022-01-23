<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

	public function getUsers($id)
	{	
		$this->db->select('*');
		$this->db->from('user');
		$this->db->join('user_information', 'user_information.userInfoId = user.userInfoId');
		$this->db->join('user_auth', 'user_auth.authId = user.authId');
		$this->db->where('user_auth.authId', $id);
		return $this->db->get();
	}

}

/* End of file Dashboard_model.php */
/* Location: ./application/modules/backend/models/Dashboard_model.php */