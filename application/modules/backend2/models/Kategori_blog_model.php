<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori_blog_model extends CI_Model {

	public function get_data_kategori_blog(){
		$query = $this->db->get('kategori_blog');

		return $query;
	}

	public function simpan_kategori($input)
    {
    	$this->load->helper('slug');
				
    	$data = array(
    		'nama_kategori' => $this->input->post('nama_kategori'),
    		'slug' => slug($this->input->post('nama_kategori')),
    		'perbolehkan_tampil' => $this->input->post('perbolehkan_tampil'),
    	);

        $this->db->insert('kategori_blog', $data);

        if($this->db->affected_rows() > 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function cari_kategori($id)
    {
    	$query = $this->db->get_where('kategori_blog', array('id' => $id))->row();
    	return $query;
    }

    public function update_kategori($id, $input)
    {
    	$this->load->helper('slug');
				
    	$data = array(
    		'nama_kategori' => $this->input->post('nama_kategori'),
    		'slug' => slug($this->input->post('nama_kategori')),
    		'perbolehkan_tampil' => $this->input->post('perbolehkan_tampil')
    	);

        $this->db->where('id', $id);
        $this->db->update('kategori_blog', $data);

        if($this->db->affected_rows() > 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function hapus_kategori($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('kategori_blog');

        if($this->db->affected_rows() > 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

/* End of file Kategori_blog_model.php */
/* Location: ./application/modules/backend/models/Kategori_blog_model.php */