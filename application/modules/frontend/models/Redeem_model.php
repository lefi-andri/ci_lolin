<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Redeem_model extends CI_Model {

	public function ambil_data_item_penukaran($group){
		
		$this->db->select('*');
		$this->db->from('groups');
		$this->db->join('bonus_poin', 'bonus_poin.group_id = groups.id');
		$this->db->where('groups.name', $group);
		$this->db->where('bonus_poin.bonus_aktif', 1);
		$query = $this->db->get();
		return $query;
	}

	public function dd_tukar_poin($group)
    {
    	$this->db->select('*');
		$this->db->from('groups');
		$this->db->join('bonus_poin', 'bonus_poin.group_id = groups.id');
		$this->db->where('groups.name', $group);
		$this->db->where('bonus_poin.bonus_aktif', 1);
    	$this->db->order_by('bonus_poin.bonus_poin_id', 'asc');
		$result = $this->db->get();
		$dd[''] = 'Please Select';
		if ($result->num_rows()>0) {
			foreach ($result->result() as $row) {
				$dd[$row->bonus_poin_id] = $row->nama_jenis_bonus;
			}
		}
		return $dd;
    }

    public function simpan_tukar_poin($reseller_id, $input, $kode_tukar_poin){

        $data = array(
            'reseller_id'           => $reseller_id,
            'bonus_poin_id'         => $this->input->post('bonus_poin_id'),
            'kode_tukar_poin'       => $kode_tukar_poin,
            'tanggal_tukar_poin'    => date("Y-m-d h:i:s"),
            'acc_tukar_poin'		=> 0,
            'bank_id'				=> $this->input->post('bank_id'),
            'nomor_rekening'		=> $this->input->post('nomor_rekening'),
            'nama_pemilik_rekening'	=> $this->input->post('nama_pemilik_rekening'),
        );

        $this->db->insert('tukar_poin', $data);

        if($this->db->affected_rows() > 0){
            return TRUE;
        }else{           
            return FALSE;
        }
	}

	public function dropdown_bank()
    {
        $this->db->order_by('nama_bank', 'asc');
        $result = $this->db->get('bank');
        $dropdown[''] = 'Please Select';
        if ($result->num_rows()>0) {
            foreach ($result->result() as $row) {
                $dropdown[$row->id] = $row->nama_bank;
            }
        }
        return $dropdown;
    }

}

/* End of file Redeem_model.php */
/* Location: ./application/modules/frontend/models/Redeem_model.php */