<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_reseller_model extends CI_Model {

	function update_profile_reseller($input, $id_reseller){
		if ($this->input->post('grup_reseller')=='reseller_pribadi') {

			$tanggal = $this->input->post('tanggal');
	        $bulan = $this->input->post('bulan');
	        $tahun = $this->input->post('tahun');
	        $tanggal_lahir = $tahun.'-'.$bulan.'-'.$tanggal;

			$data = array(
	            'nama_lengkap'      		=> $this->input->post('nama_lengkap'),
	            'nomor_ktp'     	 		=> $this->input->post('nomor_ktp'),
	            'tempat_lahir'      		=> $this->input->post('tempat_lahir'),
	            'tanggal_lahir'     		=> $tanggal_lahir,
	            'nomor_telepon_reseller'    => $this->input->post('nomor_telepon_reseller'),
	            'alamat_reseller'			=> $this->input->post('alamat_reseller'),

                'nama_toko'                 => $this->input->post('nama_toko'),
                'link_toko'                 => $this->input->post('link_toko'),

	            //'bank_id'      				=> $this->input->post('bank_id'),
	            //'nomor_rekening'      		=> $this->input->post('nomor_rekening'),
	            //'nama_pemilik_rekening'     => $this->input->post('nama_pemilik_rekening'),
	        );
		}

		if ($this->input->post('grup_reseller')=='reseller_organisasi') {
			$data = array(
	            'nama_organisasi'     		=> $this->input->post('nama_organisasi'),
	            'alamat_organisasi'      	=> $this->input->post('alamat_organisasi'),
	            'nomor_telepon_organisasi'  => $this->input->post('nomor_telepon_organisasi'),

	            'nama_lengkap'     			=> $this->input->post('nama_lengkap'),
	            'nomor_ktp'      			=> $this->input->post('nomor_ktp'),
	            'nomor_telepon_reseller'    => $this->input->post('nomor_telepon_reseller'),

                'nama_toko'                 => $this->input->post('nama_toko'),
                'link_toko'                 => $this->input->post('link_toko'),

	            //'bank_id'      				=> $this->input->post('bank_id'),
	            //'nomor_rekening'      		=> $this->input->post('nomor_rekening'),
	            //'nama_pemilik_rekening'     => $this->input->post('nama_pemilik_rekening'),
	        );
		}

		if ($this->input->post('password')) {
        	$data['password'] = $this->input->post('password');
        }

        $update = $this->ion_auth->update_user($id_reseller, $data);
		
        if ($update) {
        	return TRUE;
        } else{
            return FALSE;
        }
	}

	public function dropdown_bank()
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

	public function dropdown_tanggal()
    {
        for ($i = 1; $i <= 31 ; $i++) {
              $tgl = ($i<10) ? "0$i" : $i;
              $dropdown[$tgl] = $tgl;
        }
        return $dropdown;
    }

    public function dropdown_bulan()
    {
        for ($j = 1; $j <= 12 ; $j++) {
              $bln = ($j<10) ? "0$j" : $j;
              $dropdown[$bln] = $bln;
        }
        return $dropdown;
    }

    public function dropdown_tahun()
    {
        for ($k = 1970; $k <= 2000 ; $k++) {
             $dropdown[$k] = $k;
        }
        return $dropdown;
    }

}

/* End of file Profile_reseller_model.php */
/* Location: ./application/modules/frontend/models/Profile_reseller_model.php */