<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reseller_organisasi_model extends CI_Model {

    public function dropdown_paket_distributor()
    {
        $this->db->order_by('id', 'asc');
        $this->db->where('group_id', 4);
        $result = $this->db->get('paket_reseller');
        $dropdown[''] = 'Please Select';
        if ($result->num_rows()>0) {
            foreach ($result->result() as $row) {
                $dropdown[$row->id] = $row->nama_paket.' --- Rp. '.number_format($row->harga_paket, 0, ".", ".");
            }
        }
        return $dropdown;
    }

    public function update_user($id, $input){
				
		$this->load->library('ion_auth');
        
        $data = array(
            'nama_organisasi' => $this->input->post('nama_organisasi'),
            'alamat_organisasi' => $this->input->post('alamat_organisasi'),
            'nomor_telepon_organisasi' => $this->input->post('nomor_telepon_organisasi'),
            'nama_lengkap' => $this->input->post('nama_lengkap'),
            'nomor_ktp' => $this->input->post('nomor_ktp'),
            'bank_id' => $this->input->post('bank_id'),
            'nomor_rekening' => $this->input->post('nomor_rekening'),
            'nama_pemilik_rekening' => $this->input->post('nama_pemilik_rekening'),
            'paket_reseller_id' => $this->input->post('paket_id'),
        );

        if ($this->input->post('email')) {
        	$data['email'] = $this->input->post('email');
        }
        if ($this->input->post('password')) {
        	$data['password'] = $this->input->post('password');
        }

        $update = $this->ion_auth->update_user($id, $data);

        if($update){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    function dropdown_bank()
    {
        $this->db->order_by('nama_bank', 'asc');
        $result = $this->db->get('bank');
        $dropdown[''] = 'Please Select';
        if ($result->num_rows()>0) {
            foreach ($result->result() as $row) {
                $dropdown[$row->id] = $row->nama_bank;
            }
        }
        return $dropdown;
    }

    public function cari_gambar_foto_profile($id)
    {
        $query = $this->db->get_where('meta', array('user_id' => $id));
        return $query;
    }

}

/* End of file Reseller_organisasi_model.php */
/* Location: ./application/modules/backend/models/Reseller_organisasi_model.php */