<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Introduction_model extends CI_Model {

	public function get_data_introduction(){
		
        $query = $this->db->get('introduction');

		return $query;
	}

	public function simpan_introduction($input, $nama_file)
    {	
    	$data = array(
    		'caption' => $this->input->post('caption'),
    		'deskripsi' => $this->input->post('deskripsi'),
    		'urutan' => $this->input->post('urutan'),
    		'nama_file' => $nama_file,
    		'admin_id' => $this->session->userdata('user_id')
    	);

        $this->db->insert('introduction', $data);

        if($this->db->affected_rows() > 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function cari_introduction($id)
    {
    	$query = $this->db->get_where('introduction', array('id' => $id))->row();
    	return $query;
    }

    public function update_introduction($id, $input)
    {
    	$data = array(
    		'caption' => $this->input->post('caption'),
    		'deskripsi' => $this->input->post('deskripsi'),
    		#'urutan' => $this->input->post('urutan'),
    		'admin_id' => $this->session->userdata('user_id')
    	);

        $this->db->where('id', $id);
        $query = $this->db->update('introduction', $data);

        if($query){
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function cari_gambar_introduction($id)
    {
        $this->db->where('id',$id);
        return $this->db->get('introduction');
    }

    public function hapus_introduction($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('introduction');

        if($this->db->affected_rows() > 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

/* End of file Introduction_model.php */
/* Location: ./application/modules/backend/models/Introduction_model.php */