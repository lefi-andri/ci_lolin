<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unggah_gambar_model extends CI_Model {

	public function get_data_unggah_gambar(){
		
        $query = $this->db->get('unggah_gambar');

		return $query;
	}

	public function simpan_unggah_gambar($input, $nama_file)
    {	
    	$data = array(
    		'caption' => $this->input->post('caption'),
    		'nama_file' => $nama_file,
    		'tanggal' => date("Y-m-d h:i:s"),
    		'admin_id' => $this->session->userdata('user_id')
    	);

        $this->db->insert('unggah_gambar', $data);

        if($this->db->affected_rows() > 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function cari_unggah_gambar($id)
    {
    	$query = $this->db->get_where('unggah_gambar', array('id' => $id))->row();
    	return $query;
    }

    public function update_unggah_gambar($id, $input)
    {
    	$data = array(
    		'caption' => $this->input->post('caption'),
    	);

        $this->db->where('id', $id);
        $query = $this->db->update('unggah_gambar', $data);

        if($query){
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function cari_gambar_unggah_gambar($id)
    {
        $this->db->where('id',$id);
        return $this->db->get('unggah_gambar');
    }

    public function hapus_unggah_gambar($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('unggah_gambar');

        if($this->db->affected_rows() > 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

/* End of file Unggah_gambar_model.php */
/* Location: ./application/modules/backend/models/Unggah_gambar_model.php */