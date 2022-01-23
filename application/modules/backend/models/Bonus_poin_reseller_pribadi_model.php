<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bonus_poin_reseller_pribadi_model extends CI_Model {

	function get_data_bonus_poin(){
		$this->db->select('*');
		$this->db->from('bonus_poin');
		$this->db->join('groups', 'groups.id = bonus_poin.group_id');
		$this->db->where('groups.name', 'reseller_pribadi');
		$query = $this->db->get();

		return $query;
	}

	function simpan_bonus_poin($input){

        $data = array(
            'nama_jenis_bonus'  => $this->input->post('nama_jenis_bonus'),
            'group_id'          => 3,                 
            'nilai_bonus'       => $this->input->post('nilai_bonus'),
            'poin_bonus'        => $this->input->post('poin_bonus'),
            'bonus_aktif'       => $this->input->post('bonus_aktif'),

        );

        $this->db->insert('bonus_poin', $data);

        if($this->db->affected_rows() > 0){
            return TRUE;
        }else{           
            return FALSE;
        }
	}

	function cari_bonus_poin($id){
		return $this->db->get_where('bonus_poin', array('bonus_poin_id'=>$id))->row();
	}

	function update_bonus_poin($input,$id)
    {
    	$data = array(
            'nama_jenis_bonus'  => $this->input->post('nama_jenis_bonus'),
            'nilai_bonus'       => $this->input->post('nilai_bonus'),
            'poin_bonus'        => $this->input->post('poin_bonus'),
            'bonus_aktif'       => $this->input->post('bonus_aktif'),

        );

        $this->db->where('bonus_poin_id', $id);
        $this->db->update('bonus_poin', $data);

        if($this->db->affected_rows() > 0){
            return TRUE;
        }else{           
            return FALSE;
        }
    }

    function hapus_bonus_poin($id)
    {
        $this->db->where('bonus_poin_id', $id);
        $this->db->delete('bonus_poin');

        if($this->db->affected_rows() > 0){
            return TRUE;
        }else{           
            return FALSE;
        }
    }


}

/* End of file Bonus_poin_reseller_pribadi_model.php */
/* Location: ./application/modules/backend/models/Bonus_poin_reseller_pribadi_model.php */