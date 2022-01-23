<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tags_blog_model extends CI_Model {

	public function get_data_tags_blog(){
		$query = $this->db->get('tags_blog');

		return $query;
	}

	public function simpan_tags($input)
    {
    	$data = array(
    		'nama_tag' => $this->input->post('nama_tag'),
    	);

        $this->db->insert('tags_blog', $data);

        if($this->db->affected_rows() > 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function cari_tags($id)
    {
    	$query = $this->db->get_where('tags_blog', array('id' => $id))->row();
    	return $query;
    }

    public function update_tags($id, $input)
    {		
    	$data = array(
    		'nama_tag' => $this->input->post('nama_tag'),
    	);

        $this->db->where('id', $id);
        $this->db->update('tags_blog', $data);

        if($this->db->affected_rows() > 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function hapus_tags($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tags_blog');

        if($this->db->affected_rows() > 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

/* End of file Tags_blog_model.php */
/* Location: ./application/modules/backend/models/Tags_blog_model.php */