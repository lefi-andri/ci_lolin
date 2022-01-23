<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event_model extends CI_Model {

	public function cari_id($id)
	{
		$query = $this->db->get_where('events',array('eventsSlug'=>$id));
		return $query;
	}

}

/* End of file Event_model.php */
/* Location: ./application/modules/frontend/models/Event_model.php */