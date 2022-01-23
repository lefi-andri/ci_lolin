<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unggah_file_model extends CI_Model {

	public function get_data_unggah_file(){
		
        $query = $this->db->get('unggah_file');

		return $query;
	}

	public function simpan_unggah_file($input, $nama_file, $ekstensi_file, $tipe_file, $ukuran_file)
    {	
    	$data = array(
    		'caption' => $this->input->post('caption'),
    		'nama_file' => $nama_file,
    		'tipe_file' => $tipe_file,
    		'ukuran_file' => $ukuran_file,
    		'ekstensi_file' => $ekstensi_file,
    		'tanggal' => date("Y-m-d h:i:s"),
    		'admin_id' => $this->session->userdata('user_id')
    	);

        $this->db->insert('unggah_file', $data);

        if($this->db->affected_rows() > 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function cari_unggah_file($id)
    {
    	$query = $this->db->get_where('unggah_file', array('id' => $id))->row();
    	return $query;
    }

    public function update_unggah_file($id, $input)
    {
    	$data = array(
    		'caption' => $this->input->post('caption'),
    	);

        $this->db->where('id', $id);
        $query = $this->db->update('unggah_file', $data);

        if($query){
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function hapus_unggah_file($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('unggah_file');

        if($this->db->affected_rows() > 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

/* End of file Unggah_file_model.php */
/* Location: ./application/modules/backend/models/Unggah_file_model.php */