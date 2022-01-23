<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Konten_halaman_model extends CI_Model {

	public function get_data_konten_halaman(){

		$this->db->select('*');
		$this->db->from('status');
		$this->db->join('konten_halaman', 'konten_halaman.status_id = status.id');
		$query = $this->db->get();

		return $query;
	}

	public function simpan_konten_halaman($input)
    {	

    	$this->load->helper('slug');

    	$data = array(
    		'judul' => $this->input->post('judul'),
    		'slug' => slug($this->input->post('judul')),
    		'deskripsi' => $this->input->post('deskripsi'),
    		'deskripsi_seo' => $this->input->post('deskripsi_seo'),
    		'keyword_seo' => $this->input->post('keyword_seo'),
    		'status_id' => $this->input->post('status_id'),
    		'perbolehkan_tampil' => $this->input->post('perbolehkan_tampil'),
    		'peta_situs' => $this->input->post('peta_situs'),
    		'admin_id' => $this->session->userdata('user_id')
    	);

        $this->db->insert('konten_halaman', $data);

        if($this->db->affected_rows() > 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function cari_konten_halaman($id)
    {
    	$query = $this->db->get_where('konten_halaman', array('id' => $id))->row();
    	return $query;
    }

    public function update_konten_halaman($id, $input)
    {
    	$data = array(
    		'judul' => $this->input->post('judul'),
    		'slug' => slug($this->input->post('judul')),
    		'deskripsi' => $this->input->post('deskripsi'),
    		'deskripsi_seo' => $this->input->post('deskripsi_seo'),
    		'keyword_seo' => $this->input->post('keyword_seo'),
    		'status_id' => $this->input->post('status_id'),
    		'perbolehkan_tampil' => $this->input->post('perbolehkan_tampil'),
    		'peta_situs' => $this->input->post('peta_situs'),
    		'admin_id' => $this->session->userdata('user_id')
    	);

        $this->db->where('id', $id);
        $query = $this->db->update('konten_halaman', $data);

        if($query){
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function cari_gambar_konten_halaman($id)
    {
        $this->db->where('id',$id);
        return $this->db->get('konten_halaman');
    }

    public function hapus_konten_halaman($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('konten_halaman');

        if($this->db->affected_rows() > 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function dropdown_status()
    {
        $this->db->order_by('nama_status', 'asc');
        $result = $this->db->get('status');
        $dropdown[''] = 'Please Select';
        if ($result->num_rows()>0) {
            foreach ($result->result() as $row) {
                $dropdown[$row->id] = $row->nama_status;
            }
        }
        return $dropdown;
    }

}

/* End of file Konten_halaman_model.php */
/* Location: ./application/modules/backend/models/Konten_halaman_model.php */