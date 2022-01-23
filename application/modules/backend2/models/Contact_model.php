<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact_model extends CI_Model {

	/**
    * @ Method Contact
    *
    */

    // Method Hapus Contact
    public function hapus_contact($id)
    {
        $this->db->where('md5(conId)', $id);
        $this->db->delete('contact_me');

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
/* Location: ./application/modules/backend/models/Contact_model.php */