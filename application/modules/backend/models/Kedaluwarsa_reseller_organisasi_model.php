<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kedaluwarsa_reseller_organisasi_model extends CI_Model {

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

    public function get_rekaman_penukaran($id){
		$this->db->select('*');
		$this->db->from('tukar_poin');
		$this->db->join('users', 'users.id = tukar_poin.reseller_id');
        $this->db->join('meta', 'meta.user_id = users.id');
        $this->db->join('bonus_poin', 'bonus_poin.bonus_poin_id = tukar_poin.bonus_poin_id');
		$this->db->where('tukar_poin.reseller_id', $id);
		$this->db->group_by('tukar_poin.kode_tukar_poin');
		$query = $this->db->get();

		return $query;
	}

}

/* End of file Kedaluwarsa_reseller_organisasi_model.php */
/* Location: ./application/modules/backend/models/Kedaluwarsa_reseller_organisasi_model.php */