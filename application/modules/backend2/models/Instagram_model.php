<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Instagram_model extends CI_Model {

	public function get_data_instagram(){
		
        $query = $this->db->get('instagram');

		return $query;
	}

	public function simpan_instagram($input, $nama_file)
    {	
    	$data = array(
    		'caption' => $this->input->post('caption'),
    		'deskripsi' => $this->input->post('deskripsi'),
    		'link' => $this->input->post('link'),
    		'perbolehkan_tampil' => $this->input->post('perbolehkan_tampil'),
    		'nama_file' => $nama_file,
    		'tanggal' => date("Y-m-d h:i:s"),
    		'admin_id' => $this->session->userdata('user_id')
    	);

        $this->db->insert('instagram', $data);

        if($this->db->affected_rows() > 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function cari_instagram($id)
    {
    	$query = $this->db->get_where('instagram', array('id' => $id))->row();
    	return $query;
    }

    public function update_instagram($id, $input)
    {
    	$data = array(
    		'caption' => $this->input->post('caption'),
    		'deskripsi' => $this->input->post('deskripsi'),
    		'link' => $this->input->post('link'),
    		'perbolehkan_tampil' => $this->input->post('perbolehkan_tampil'),
    	);

        $this->db->where('id', $id);
        $query = $this->db->update('instagram', $data);

        if($query){
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function cari_gambar_instagram($id)
    {
        $this->db->where('id',$id);
        return $this->db->get('instagram');
    }

    public function hapus_instagram($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('instagram');

        if($this->db->affected_rows() > 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }


}

/* End of file Instagram_model.php */
/* Location: ./application/modules/backend/models/Instagram_model.php */