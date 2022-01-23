<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pertanyaan_model extends CI_Model {

	public function get_data_pertanyaan(){
		
		$query = $this->db->get('pertanyaan');
		return $query;

	}

	public function hapus_pertanyaan($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('pertanyaan');

        if($this->db->affected_rows() > 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

/* End of file Pertanyaan_model.php */
/* Location: ./application/modules/backend/models/Pertanyaan_model.php */