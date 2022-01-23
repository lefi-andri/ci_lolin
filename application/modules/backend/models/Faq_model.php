<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faq_model extends CI_Model {

	public function get_data_faq(){
		$query = $this->db->get('faq');
		return $query;
	}

	public function simpan_faq($input)
    {
    	$this->load->helper('slug');
				
    	$data = array(
    		'pertanyaan' => $this->input->post('pertanyaan'),
    		'jawaban' => $this->input->post('jawaban'),
    		'urutan' => $this->input->post('urutan'),
    		'label' => $this->input->post('label'),
    		'slug' => slug($this->input->post('label')),
    		'perbolehkan_tampil' => $this->input->post('perbolehkan_tampil')
    	);

        $this->db->insert('faq', $data);

        if($this->db->affected_rows() > 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function cari_faq($id)
    {
    	$query = $this->db->get_where('faq', array('id' => $id))->row();
    	return $query;
    }

    public function update_faq($id, $input)
    {
    	$this->load->helper('slug');
				
    	$data = array(
    		'pertanyaan' => $this->input->post('pertanyaan'),
    		'jawaban' => $this->input->post('jawaban'),
    		'urutan' => $this->input->post('urutan'),
    		'label' => $this->input->post('label'),
    		'slug' => slug($this->input->post('label')),
    		'perbolehkan_tampil' => $this->input->post('perbolehkan_tampil')
    	);

        $this->db->where('id', $id);
        $this->db->update('faq', $data);

        if($this->db->affected_rows() > 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function hapus_faq($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('faq');

        if($this->db->affected_rows() > 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

/* End of file Faq_model.php */
/* Location: ./application/modules/backend/models/Faq_model.php */