<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaturan_model extends CI_Model {

	public function cari_set_ta()
	{
		return $this->db->get('pengaturan')->row();
	}

	public function simpan_pengaturan($input)
    {
    	$pengaturanTahun 			= $input['pengaturanTahun'];
    	$pengaturanOwnerName 		= $input['pengaturanOwnerName'];
    	$pengaturanCompanyName 		= $input['pengaturanCompanyName'];
        $pengaturanEmail            = $input['pengaturanEmail'];

        $data = array(
            "UPDATE pengaturan SET pengaturanTahun='$pengaturanTahun', pengaturanOwnerName='$pengaturanOwnerName', pengaturanCompanyName='$pengaturanCompanyName', pengaturanEmail='$pengaturanEmail'"
        );

        for ($i = 0; $i < count($data); $i++) {
            $query = $this->db->query($data[$i]);
        }

        if($this->db->affected_rows() > 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }

}

/* End of file Pengaturan_model.php */
/* Location: ./application/modules/backend/models/Pengaturan_model.php */