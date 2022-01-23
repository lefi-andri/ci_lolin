<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penukaran_poin_reseller_organisasi_model extends CI_Model {

	public function get_data_tukar_poin(){
		$this->db->select('*');
		$this->db->from('tukar_poin');
		$this->db->join('bonus_poin', 'bonus_poin.bonus_poin_id = tukar_poin.bonus_poin_id');
		$this->db->join('groups', 'groups.id = bonus_poin.group_id');
		$this->db->join('users', 'users.id = tukar_poin.reseller_id');
		$this->db->join('meta', 'meta.user_id = users.id');
        $this->db->like('meta.reseller_id', 'RSO');
		$query = $this->db->get();

		return $query;
	}

	public function get_data_reseller_organisasi(){
		$group = 'reseller_organisasi';
		$users = $this->ion_auth->get_users($group);

		return $users;
	}

	public function get_data_bonus_poin(){
		$this->db->select('*');
		$this->db->from('bonus_poin');
		$this->db->join('groups', 'groups.id = bonus_poin.group_id');
		$this->db->where('groups.name', 'reseller_organisasi');
		$query = $this->db->get();

		return $query;
	}

	function simpan_tukar_poin($input, $kode_tukar_poin){

        $data = array(
            'reseller_id'      => $this->input->post('user_id'),
            'bonus_poin_id'      => $this->input->post('bonus_poin_id'),
            'kode_tukar_poin' => $kode_tukar_poin,
            'tanggal_tukar_poin' => date("Y-m-d h:i:s"),
        );

        $this->db->insert('tukar_poin', $data);

        if($this->db->affected_rows() > 0){
            return TRUE;
        }else{           
            return FALSE;
        }
	}

	function cari_tukar_poin($id){
		return $this->db->get_where('tukar_poin', array('tukar_poin_id'=>$id))->row();
	}

	function update_tukar_poin($input,$id)
    {
    	$data = array(
            'reseller_id'      => $this->input->post('user_id'),
            'bonus_poin_id'      => $this->input->post('bonus_poin_id'),
        );

        $this->db->where('tukar_poin_id', $id);
        $this->db->update('tukar_poin', $data);

        if($this->db->affected_rows() > 0){
            return TRUE;
        }else{           
            return FALSE;
        }
    }

    function hapus_tukar_poin($id)
    {
        $this->db->where('tukar_poin_id', $id);
        $this->db->delete('tukar_poin');

        if($this->db->affected_rows() > 0){
            return TRUE;
        }else{           
            return FALSE;
        }
    }

}

/* End of file Penukaran_poin_reseller_organisasi_model.php */
/* Location: ./application/modules/backend/models/Penukaran_poin_reseller_organisasi_model.php */