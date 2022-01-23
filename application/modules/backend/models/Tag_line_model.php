<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tag_line_model extends CI_Model {

    public function get_data_tag_line(){
        $query = $this->db->get('tag_line');

        return $query;
    }

    public function simpan_tag_line($input)
    {
           
        $data = array(
            'konten' => $this->input->post('konten'),
            'perbolehkan_tampil' => $this->input->post('perbolehkan_tampil'),
            'urutan' => $this->input->post('urutan'),
        );

        $this->db->insert('tag_line', $data);

        if($this->db->affected_rows() > 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function cari_tag_line($id)
    {
        $query = $this->db->get_where('tag_line', array('id' => $id))->row();
        return $query;
    }

    public function update_tag_line($id, $input)
    {
             
        $data = array(
            'konten' => $this->input->post('konten'),
            'perbolehkan_tampil' => $this->input->post('perbolehkan_tampil'),
            'urutan' => $this->input->post('urutan'),
        );

        $this->db->where('id', $id);
        $this->db->update('tag_line', $data);

        if($this->db->affected_rows() > 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function hapus_tag_line($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tag_line');

        if($this->db->affected_rows() > 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

/* End of file Tag_line_model.php */
/* Location: ./application/modules/backend/models/Tag_line_model.php */