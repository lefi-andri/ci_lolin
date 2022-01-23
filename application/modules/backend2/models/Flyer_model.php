<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Flyer_model extends CI_Model {

	public function get_data_flyer(){
		
        $query = $this->db->get('flyer');

		return $query;
	}

	public function simpan_flyer($input, $nama_file)
    {	
    	$data = array(
    		'caption' => $this->input->post('caption'),
    		'deskripsi' => $this->input->post('deskripsi'),
    		'link' => $this->input->post('link'),
    		'class_active' => $this->input->post('class_active'),
    		'perbolehkan_tampil' => $this->input->post('perbolehkan_tampil'),
    		'urutan' => $this->input->post('urutan'),
    		'nama_file' => $nama_file,
    		'tanggal' => date("Y-m-d h:i:s"),
    		'admin_id' => $this->session->userdata('user_id')
    	);

        $this->db->insert('flyer', $data);

        if($this->db->affected_rows() > 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function cari_flyer($id)
    {
    	$query = $this->db->get_where('flyer', array('id' => $id))->row();
    	return $query;
    }

    public function update_flyer($id, $input)
    {
    	$data = array(
    		'caption' => $this->input->post('caption'),
    		'deskripsi' => $this->input->post('deskripsi'),
    		'link' => $this->input->post('link'),
    		'class_active' => $this->input->post('class_active'),
    		'perbolehkan_tampil' => $this->input->post('perbolehkan_tampil'),
    		'urutan' => $this->input->post('urutan'),
    	);

        $this->db->where('id', $id);
        $query = $this->db->update('flyer', $data);

        if($query){
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function cari_gambar_flyer($id)
    {
        $this->db->where('id',$id);
        return $this->db->get('flyer');
    }

    public function hapus_flyer($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('flyer');

        if($this->db->affected_rows() > 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

/* End of file Flyer_model.php */
/* Location: ./application/modules/backend/models/Flyer_model.php */