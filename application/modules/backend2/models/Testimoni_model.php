<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Testimoni_model extends CI_Model {

	public function get_data_testimoni(){
		
        $query = $this->db->get('testimoni');

		return $query;
	}

	public function simpan_testimoni($input, $nama_file)
    {	
    	$data = array(
    		'caption' => $this->input->post('caption'),
    		'deskripsi' => $this->input->post('deskripsi'),
    		'perbolehkan_tampil' => $this->input->post('perbolehkan_tampil'),
    		'urutan' => $this->input->post('urutan'),
    		'nama_file' => $nama_file,
    		'tanggal' => date("Y-m-d h:i:s"),
    		'admin_id' => $this->session->userdata('user_id')
    	);

        $this->db->insert('testimoni', $data);

        if($this->db->affected_rows() > 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function cari_testimoni($id)
    {
    	$query = $this->db->get_where('testimoni', array('id' => $id))->row();
    	return $query;
    }

    public function update_testimoni($id, $input)
    {
    	$data = array(
    		'caption' => $this->input->post('caption'),
    		'deskripsi' => $this->input->post('deskripsi'),
    		'perbolehkan_tampil' => $this->input->post('perbolehkan_tampil'),
    		'urutan' => $this->input->post('urutan'),
    	);

        $this->db->where('id', $id);
        $query = $this->db->update('testimoni', $data);

        if($query){
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function cari_gambar_testimoni($id)
    {
        $this->db->where('id',$id);
        return $this->db->get('testimoni');
    }

    public function hapus_testimoni($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('testimoni');

        if($this->db->affected_rows() > 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

/* End of file Testimoni_model.php */
/* Location: ./application/modules/backend/models/Testimoni_model.php */