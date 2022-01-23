<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Socialmedia_model extends CI_Model {

	// Method Cari Sosial Media
    public function cari_socialmedia($id)
    {
    	$this->db->where('md5(socialId)', $id);
		return $this->db->get('socialmedia')->row();
    }

    // Method Update Sosial Media
    public function update_socialmedia($info, $id)
    {
        $this->db->where('socialId', $id);
        $this->db->update('socialmedia', $info);

        if($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

}

/* End of file Socialmedia_model.php */
/* Location: ./application/modules/backend/models/Socialmedia_model.php */