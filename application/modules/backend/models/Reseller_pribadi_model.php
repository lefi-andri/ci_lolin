<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reseller_pribadi_model extends CI_Model {

    public function dropdown_paket_reseller()
    {
        $this->db->order_by('id', 'asc');
        $this->db->where('group_id', 3);
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

        $tanggal = $this->input->post('tanggal');
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        $tanggal_lahir = $tahun.'-'.$bulan.'-'.$tanggal;
        
        $data = array(
            'nama_lengkap' => $this->input->post('nama_lengkap'),
            'nomor_ktp' => $this->input->post('nomor_ktp'),
            'tempat_lahir' => $this->input->post('tempat_lahir'),
            'tanggal_lahir' => $tanggal_lahir,
            'nomor_telepon_reseller' => $this->input->post('nomor_telepon_reseller'),
            'alamat_reseller' => $this->input->post('alamat_reseller'),
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

    function dropdown_tanggal()
    {
        for ($i = 1; $i <= 31 ; $i++) {
              $tgl = ($i<10) ? "0$i" : $i;
              $dropdown[$tgl] = $tgl;
        }
        return $dropdown;
    }

    function dropdown_bulan()
    {
        for ($j = 1; $j <= 12 ; $j++) {
              $bln = ($j<10) ? "0$j" : $j;
              $dropdown[$bln] = $bln;
        }
        return $dropdown;
    }

    function dropdown_tahun()
    {
        for ($k = 1970; $k <= 2000 ; $k++) {
             $dropdown[$k] = $k;
        }
        return $dropdown;
    }

}

/* End of file Reseller_pribadi_model.php */
/* Location: ./application/modules/backend/models/Reseller_pribadi_model.php */