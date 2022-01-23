<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banner_model extends CI_Model {

	public function get_data_banner(){
		
        $query = $this->db->get('banner');

		return $query;
	}

	public function simpan_banner($input, $nama_file)
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

        $this->db->insert('banner', $data);

        if($this->db->affected_rows() > 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function cari_banner($id)
    {
    	$query = $this->db->get_where('banner', array('id' => $id))->row();
    	return $query;
    }

    public function update_banner($id, $input)
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
        $query = $this->db->update('banner', $data);

        if($query){
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function cari_gambar_banner($id)
    {
        $this->db->where('id',$id);
        return $this->db->get('banner');
    }

    public function hapus_banner($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('banner');

        if($this->db->affected_rows() > 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

/* End of file Banner_model.php */
/* Location: ./application/modules/backend/models/Banner_model.php */