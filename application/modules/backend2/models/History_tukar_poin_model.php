<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class History_tukar_poin_model extends CI_Model {

	// Method Hapus Member
    public function hapus_tukar_poin_model($id)
    {

        $data = array(
            "DELETE FROM tukar_poin WHERE md5(tukarId)='$id'"
        );

        for ($i = 0; $i < count($data); $i++) {
            $query = $this->db->query($data[$i]);
        }

        if($this->db->affected_rows() > 0){
            return TRUE;
        }else {           
            return FALSE;
        }
    }

}

/* End of file History_tukar_poin_model.php */
/* Location: ./application/modules/backend/models/History_tukar_poin_model.php */