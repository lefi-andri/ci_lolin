<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_model extends CI_Model {

	public function ambil_data_profile(){
		$this->db->select('*');
		$this->db->from('users_groups');
		$this->db->join('users', 'users.id = users_groups.user_id');
		$this->db->join('groups', 'groups.id = users_groups.group_id');
		$this->db->where('users_groups.user_id', $this->session->userdata('user_id'));
		$query = $this->db->get();

		return $query;
	}

}

/* End of file Profile_model.php */
/* Location: ./application/modules/backend/models/Profile_model.php */