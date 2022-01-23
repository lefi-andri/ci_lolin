<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reseller_model extends CI_Model {

	public function dropdown_paket_reseller()
    {
        $this->db->order_by('id', 'asc');
        $this->db->where('group_id', 3);
        $result = $this->db->get('paket_reseller');
        $dropdown[''] = 'Please Select';
        if ($result->num_rows()>0) {
            foreach ($result->result() as $row) {
                $dropdown[$row->id] = $row->nama_paket.' --- Rp. '.number_format($row->harga_paket, 0, ".", ".").' --- '.$row->keterangan_paket;
            }
        }
        return $dropdown;
    }

    public function dropdown_paket_distributor()
    {
        $this->db->order_by('id', 'asc');
        $this->db->where('group_id', 4);
        $result = $this->db->get('paket_reseller');
        $dropdown[''] = 'Please Select';
        if ($result->num_rows()>0) {
            foreach ($result->result() as $row) {
                $dropdown[$row->id] = $row->nama_paket.' --- Rp. '.number_format($row->harga_paket, 0, ".", ".").' --- '.$row->keterangan_paket;
            }
        }
        return $dropdown;
    }

	# tambah reseller pribadi
	public function create_reseller_pribadi($input, $token, $buat_id_reseller){

		date_default_timezone_get('Asia/Jakarta');
		$waktu_sekarang = date("Y-m-d h:i:s");
		$tanggal_sekarang = date('Y-m-d');

        $username 	= $input['email'];
        $password 	= $input['password'];
        $email 		= $input['email'];

		$additional_data = array(
			'nama_lengkap' 				=> $this->input->post('nama_lengkap'),
			'nomor_telepon_reseller' 	=> $this->input->post('nomor_telepon_reseller'),
			'paket_reseller_id'			=> $this->input->post('paket_id'),
			'tanggal_lahir'				=> $tanggal_sekarang,
			'token' 					=> $token,
			'reseller_id' 				=> $buat_id_reseller
		);

		$group_name = 'reseller_pribadi';

		return $this->ion_auth->register($username, $password, $email, $additional_data, $group_name);

	}

	# tambah reseller organisasi
	public function create_reseller_organisasi($input, $token, $buat_id_reseller){
		
        $username 	= $input['email'];
        $password 	= $input['password'];
        $email 		= $input['email'];

		$additional_data = array(
        	'nama_organisasi' 			=> $this->input->post('nama_organisasi'),
        	'alamat_organisasi' 		=> $this->input->post('alamat_organisasi'),
        	'nomor_telepon_organisasi' 	=> $this->input->post('nomor_telepon_organisasi'),
			'nama_lengkap' 				=> $this->input->post('nama_lengkap'),
			'paket_reseller_id'			=> $this->input->post('paket_id'),
			'token' 					=> $token,
			'reseller_id' 				=> $buat_id_reseller
		);

		$group_name = 'reseller_organisasi';

       return $this->ion_auth->register($username, $password, $email, $additional_data, $group_name);
	}

	# cek username
	public function check_username($id){
		if (!$this->ion_auth->username_check($id)){  //Jika Username Belum Dipakai
		    return TRUE;
		}else{
			return FALSE;
		}
	}

	public function cari_jenis_reseller($id){
	    $this->db->select('*');
	    $this->db->from('users_groups');
	    $this->db->join('users', 'users.id = users_groups.user_id');
	    $this->db->join('groups', 'groups.id = users_groups.group_id');
	    $this->db->where('users.id', $id);
	    $data_reseller = $this->db->get()->row();
	    return $data_reseller;
	}

	public function cek_kode_aktivasi($id){
		$this->db->select('*');
		$this->db->from('users');
		$this->db->join('meta', 'meta.user_id = users.id');
		$this->db->where('meta.token', $id);
		$this->db->where('users.active', 0);
		$check = $this->db->get();

		if ($check->num_rows() > 0) {
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function cek_nama_organisasi($id){
		$this->db->select('*');
		$this->db->from('users');
		$this->db->join('meta', 'meta.user_id = users.id');
		$this->db->join('groups', 'groups.id = users.group_id');
		$this->db->where('meta.token', $id);
		$this->db->where('users.active', 0);
		$nama_grup = $this->db->get()->row()->name;

		return $nama_grup;
	}

	public function cek_data_kode_aktivasi($id){
		#$check = $this->db->get_where('users', array('token'=>$id, 'active'=>1));
		$this->db->select('*');
		$this->db->from('users');
		$this->db->join('meta', 'meta.user_id = users.id');
		$this->db->where('meta.token', $id);
		$this->db->where('users.active', 1);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query;
		}else{
			return FALSE;
		}
	}
	
	public function ubah_status_aktivasi($id, $tambah_masa_poin){

		$this->db->select('*');
		$this->db->from('users');
		$this->db->join('meta', 'meta.user_id = users.id');
		$this->db->where('meta.token', $id);
		$this->db->where('users.active', 0);
		$cari_data = $this->db->get();

		if ($cari_data->num_rows() > 0) {

			$data = array(
	    		'active' => '1',
	    	);
			$this->db->where('id', $cari_data->row()->user_id);
        	$this->db->update('users', $data);
			

			$data_meta = array(
				#'reseller_id' => $buat_id_reseller,
				'tanggal_daftar_reseller' => date("Y-m-d h:i:s"),
				'tanggal_kedaluwarsa_poin_reseller' => $tambah_masa_poin,
			);

			$this->db->where('user_id', $cari_data->row()->user_id);
			$this->db->update('meta', $data_meta);

			if($this->db->affected_rows() > 0){
	            return TRUE;
	        }else{           
	            return FALSE;
	        }

		}else{
			return FALSE;
		}
	}



}

/* End of file Reseller_model.php */
/* Location: ./application/modules/frontend/models/Reseller_model.php */