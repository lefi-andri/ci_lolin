<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekaman_order_reseller_pribadi_model extends CI_Model {

	// hitung jumlah total data PAGING
    function total_record($id) {
        $this->db->select('*');
        $this->db->group_by('order_code');
        $this->db->from('purchase_order');
        $this->db->where('reseller_id', $id);
        $query = $this->db->count_all_results();

        return $query;
    }
    // tampilkan dengan limit PAGING
    function user_limit($limit, $start = 0, $id) {
        $this->db->order_by('order_id', 'ASC');
        $this->db->limit($limit, $start);
        $this->db->where('reseller_id', $id);
        $this->db->group_by('order_code');
        return $this->db->get('purchase_order');
    }

    function get_rekaman($id){
    	$this->db->select('*');
		$this->db->from('purchase_order');
		$this->db->join('users', 'users.id = purchase_order.reseller_id');
        $this->db->join('meta', 'meta.user_id = users.id');
		$this->db->where('purchase_order.reseller_id', $id);
		$this->db->group_by('purchase_order.order_code');
        $this->db->order_by('purchase_order.order_code', 'desc');
		$query = $this->db->get();
		return $query;
    }

}

/* End of file Rekaman_order_reseller_pribadi_model.php */
/* Location: ./application/modules/backend/models/Rekaman_order_reseller_pribadi_model.php */