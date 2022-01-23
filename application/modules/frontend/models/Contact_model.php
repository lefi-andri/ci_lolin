<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact_model extends CI_Model {

	// Method Simpan Contact
    public function simpan_contact($info)
    {
        $this->db->insert('contact_me', $info);

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

/* End of file Contact_model.php */
/* Location: ./application/modules/frontend/models/Contact_model.php */