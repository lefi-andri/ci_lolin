<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_pending_reseller_organisasi_model extends CI_Model {

	public function ambil_data_order_pending(){
		$this->db->select('*');
		$this->db->from('temporary_purchase_order');
		$this->db->join('users', 'users.id = temporary_purchase_order.reseller_id');
		$this->db->join('meta', 'meta.user_id = users.id');
		$this->db->like('meta.reseller_id', 'RSO');
		$this->db->group_by('kode_temporary');
		$query = $this->db->get();
		return $query;
	}

	function ambil_data_temporary_order($id){
		$this->db->select('*');
		$this->db->from('temporary_purchase_order');
		$this->db->where('kode_temporary', $id);
		$query = $this->db->get();
		return $query;
	}

	function hapus_temporary($id_temp){
		$this->db->where('kode_temporary', $id_temp);
		$query = $this->db->delete('temporary_purchase_order');
		return $query;
	}

	public function hapus_order_pending($id){
		$this->db->where('kode_temporary', $id);
		$query = $this->db->delete('temporary_purchase_order');
		return $query;
	}

}

/* End of file Order_pending_reseller_organisasi_model.php */
/* Location: ./application/modules/backend/models/Order_pending_reseller_organisasi_model.php */