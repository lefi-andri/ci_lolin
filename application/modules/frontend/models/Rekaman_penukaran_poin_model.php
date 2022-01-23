<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekaman_penukaran_poin_model extends CI_Model {

	public function ambil_data_item_penukaran($id_reseller){
		$this->db->select('*');
		$this->db->from('tukar_poin');
		$this->db->join('bonus_poin', 'bonus_poin.bonus_poin_id = tukar_poin.bonus_poin_id');
		$this->db->join('users', 'users.id = tukar_poin.reseller_id');
		$this->db->where('bonus_poin.bonus_aktif', 1);
		$this->db->where('tukar_poin.reseller_id', $id_reseller);
		$query = $this->db->get();

		return $query;
	}

}

/* End of file Rekaman_penukaran_poin_model.php */
/* Location: ./application/modules/frontend/models/Rekaman_penukaran_poin_model.php */