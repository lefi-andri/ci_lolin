<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Iklan_model extends CI_Model {

	public function get_data_iklan(){
		
        $query = $this->db->get('iklan');

		return $query;
	}

	public function simpan_iklan($input, $nama_file)
    {	
    	$data = array(
            'konten_id' => $this->input->post('konten_id'),
    		'caption' => $this->input->post('caption'),
    		'deskripsi' => $this->input->post('deskripsi'),
    		'link' => $this->input->post('link'),
    		'perbolehkan_tampil' => $this->input->post('perbolehkan_tampil'),
    		'nama_file' => $nama_file,
    		'tanggal' => date("Y-m-d h:i:s"),
    		'admin_id' => $this->session->userdata('user_id')
    	);

        $this->db->insert('iklan', $data);

        if($this->db->affected_rows() > 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function cari_iklan($id)
    {
    	$query = $this->db->get_where('iklan', array('id' => $id))->row();
    	return $query;
    }

    public function update_iklan($id, $input)
    {
    	$data = array(
            'konten_id' => $this->input->post('konten_id'),
    		'caption' => $this->input->post('caption'),
    		'deskripsi' => $this->input->post('deskripsi'),
    		'link' => $this->input->post('link'),
    		'perbolehkan_tampil' => $this->input->post('perbolehkan_tampil'),
    	);

        $this->db->where('id', $id);
        $query = $this->db->update('iklan', $data);

        if($query){
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function cari_gambar_iklan($id)
    {
        $this->db->where('id',$id);
        return $this->db->get('iklan');
    }

    public function hapus_iklan($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('iklan');

        if($this->db->affected_rows() > 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function dropdown_konten()
    {
        $this->db->order_by('judul', 'asc');
        $result = $this->db->get('konten_halaman');
        $dropdown[''] = 'Please Select';
        if ($result->num_rows()>0) {
            foreach ($result->result() as $row) {
                $dropdown[$row->id] = $row->judul;
            }
        }
        return $dropdown;
    }

}

/* End of file Iklan_model.php */
/* Location: ./application/modules/backend/models/Iklan_model.php */