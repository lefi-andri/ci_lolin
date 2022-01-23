<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

    public function update_user($id, $input){
				
		$this->load->library('ion_auth');
        
        $data = array(
            'nama_lengkap' => $this->input->post('nama_lengkap')
        );

        if ($this->input->post('email')) {
        	$data['email'] = $this->input->post('email');
        }
        if ($this->input->post('password')) {
        	$data['password'] = $this->input->post('password');
        }

        $update = $this->ion_auth->update_user($id, $data);

        if($update){
            return TRUE;
        }else{
            return FALSE;
        }
    }

}

/* End of file Admin_model.php */
/* Location: ./application/modules/backend/models/Admin_model.php */