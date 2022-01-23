<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penukaran_poin_reseller_pribadi_model extends CI_Model {

	public function get_data_tukar_poin(){
		$this->db->select('*');
		$this->db->from('tukar_poin');
		$this->db->join('bonus_poin', 'bonus_poin.bonus_poin_id = tukar_poin.bonus_poin_id');
		$this->db->join('groups', 'groups.id = bonus_poin.group_id');
		$this->db->join('users', 'users.id = tukar_poin.reseller_id');
		$this->db->join('meta', 'meta.user_id = users.id');
        $this->db->like('meta.reseller_id', 'RSP');
        $this->db->order_by('tukar_poin.tanggal_tukar_poin', 'desc');
		$query = $this->db->get();

		return $query;
	}

	public function get_data_reseller_pribadi(){
		$group = 'reseller_pribadi';
		$users = $this->ion_auth->get_users($group);

		return $users;
	}

	public function get_data_bonus_poin(){
		$this->db->select('*');
		$this->db->from('bonus_poin');
		$this->db->join('groups', 'groups.id = bonus_poin.group_id');
		$this->db->where('groups.name', 'reseller_pribadi');
		$query = $this->db->get();

		return $query;
	}

	public function simpan_tukar_poin($input, $kode_tukar_poin){

        $data = array(
            'reseller_id'           => $this->input->post('user_id'),
            'bonus_poin_id'         => $this->input->post('bonus_poin_id'),
            'kode_tukar_poin'       => $kode_tukar_poin,
            'tanggal_tukar_poin'    => date("Y-m-d h:i:s"),
        );

        $this->db->insert('tukar_poin', $data);

        $object = array(
            'tipe_transaksi_id' => 2,
            'reseller_id' => $this->input->post('user_id'),
            'related_id' => $kode_tukar_poin,
            'tanggal_log' => date("Y-m-d h:i:s")
        );

        $this->db->insert('log_transaksi', $object);

        if($this->db->affected_rows() > 0){
            return TRUE;
        }else{           
            return FALSE;
        }
	}

	public function cari_tukar_poin($id){
		return $this->db->get_where('tukar_poin', array('tukar_poin_id'=>$id))->row();
	}

	public function update_tukar_poin($input,$id)
    {
    	$data = array(
            'reseller_id'      => $this->input->post('user_id'),
            'bonus_poin_id'      => $this->input->post('bonus_poin_id'),
        );

        $this->db->where('tukar_poin_id', $id);
        $this->db->update('tukar_poin', $data);

        if($this->db->affected_rows() > 0){
            return TRUE;
        }else{           
            return FALSE;
        }
    }

    public function hapus_tukar_poin($id)
    {
        $tukar_poin_id = $this->db->get_where('tukar_poin', array('tukar_poin_id'=>$id))->row()->kode_tukar_poin;

        $this->db->where('related_id', $tukar_poin_id);
        $this->db->delete('log_transaksi');

        $this->db->where('tukar_poin_id', $id);
        $this->db->delete('tukar_poin');



        if($this->db->affected_rows() > 0){
            return TRUE;
        }else{           
            return FALSE;
        }
    }

    public function cari_konfirmasi_email($id)
    {
        //$query = $this->db->get_where('tukar_poin', array('tukar_poin_id' => $id))->row();
        //return $query;

        $this->db->select('bonus_poin.nama_jenis_bonus,
                            bonus_poin.poin_bonus,
                            bonus_poin.nilai_bonus,
                            tukar_poin.tukar_poin_id,
                            tukar_poin.kode_tukar_poin,
                            tukar_poin.tanggal_tukar_poin,
                            tukar_poin.nama_pemilik_rekening as pemilik_rek,
                            tukar_poin.nomor_rekening as norek,
                            tukar_poin.konfirmasi_email_pesan,
                            bank.nama_bank,
                            users.email,
                            meta.nama_lengkap,

                            meta.reseller_id,
                            meta.nomor_telepon_reseller,
                            meta.alamat_reseller,
                            meta.nama_organisasi,
                            meta.nomor_telepon_organisasi,
                            meta.alamat_organisasi
                          ');
        $this->db->from('tukar_poin');
        $this->db->join('bonus_poin', 'bonus_poin.bonus_poin_id = tukar_poin.bonus_poin_id');
        $this->db->join('users', 'users.id = tukar_poin.reseller_id');
        $this->db->join('groups', 'groups.id = users.group_id');
        $this->db->join('meta', 'meta.user_id = users.id');
        $this->db->join('bank', 'bank.id = tukar_poin.bank_id');
        $this->db->where('tukar_poin.tukar_poin_id', $id);
        $query = $this->db->get()->row();

        return $query;
    }

}

/* End of file Penukaran_poin_reseller_pribadi_model.php */
/* Location: ./application/modules/backend/models/Penukaran_poin_reseller_pribadi_model.php */