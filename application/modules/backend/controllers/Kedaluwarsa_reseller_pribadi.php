<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kedaluwarsa_reseller_pribadi extends Backend_Controller {

	public function __construct()
	{
		parent::__construct();

		if (!$this->ion_auth->logged_in())
        {
        	$this->session->set_flashdata('message_warning', 'You must be an admin to view this page');
            redirect('login/auth/index','refresh');
        }

        if (!$this->ion_auth->is_admin())
        {
           $this->session->set_flashdata('message_warning', 'You must be an admin to view this page');
           redirect('login/auth/index','refresh');
        }
		
		$this->load->model('kedaluwarsa_reseller_pribadi_model', 'models');

		$this->load->helper('indonesiandate');
	}

	public function index()
	{
		$this->load->library('breadcrumb');

		$url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_backend', $url);

		$this->load->library('table');

		$this->table->set_heading(array('No.', 'Id Reseller', 'Nama Reseller', 'Tanggal Daftar', 'Tanggal Experied', 'Check','Kedaluwarsa', '',''));

		$group = 'reseller_pribadi';
		$users = $this->ion_auth->get_users($group);

		$no = 1;
		foreach ($users as $value) {

			list($tanggal, $waktu) = explode(' ', $value->tanggal_daftar_reseller);

			$selisih = core::Interval_days($value->tanggal_kedaluwarsa_poin_reseller);

			$this->table->add_row(array(
				$no, 
				$value->reseller_id,
				$value->nama_lengkap,
				indonesian_date($tanggal),
				indonesian_date($value->tanggal_kedaluwarsa_poin_reseller),
				anchor(base_url().'backend/kedaluwarsa_reseller_pribadi/backup_data/'.$value->id, '<span class="glyphicon glyphicon-file" aria-hidden="true"></span> Check', array('class'=>'btn btn-info btn-xs')),
				($selisih <= 0)? '<span class="label label-danger">Kedaluwarsa</span>': '',
				($selisih <= 0)? anchor(base_url().'backend/kedaluwarsa_reseller_pribadi/backup_data/'.$value->id, '<span class="glyphicon glyphicon-file" aria-hidden="true"></span> Backup Data', array('class'=>'btn btn-warning btn-xs')) : '',
				($selisih <= 0)? anchor(base_url().'backend/kedaluwarsa_reseller_pribadi/delete_data/'.$value->id, '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Hapus Data', array('class'=>'btn btn-danger btn-xs', 'title'=>'Hapus data reseller', 'onclick' => "return confirm('Anda yakin ingin menghapus reseller ?')")) : '',
			));
			$no++;
		}

		core:: buat_tabel();

		$this->data = array(
			'main_view' 	=> 'kedaluwarsa_reseller_pribadi/list_kedaluwarsa',
			'table' 		=> $this->table->generate(),
		);

		$this->load->view('include/template', $this->data);
	}

	public function backup_data($id = NULL){

		$this->load->library('breadcrumb');

		$this->load->helper('indonesiandate');

		$total_semua_poin = core::hitung_total_poin($id);

		$total_semua_penukaran = core::hitung_tukar_poin($id);

		$total_poin_saat_ini = core::cek_poin_saat_ini($total_semua_poin, $total_semua_penukaran);

		$reseller = $this->db->get_where('users', array('id' => $id))->row();
		$email = $reseller->email;
		$data_reseller = $this->ion_auth->get_user_by_email($email);

		$this->data = array(
			'data_reseller'				=> $data_reseller,
            'data_rekaman' 				=> $this->models->get_rekaman($id),
            'data_rekaman_penukaran' 	=> $this->models->get_rekaman_penukaran($id),
            'reseller_id'				=> $id,
            'poin_saat_ini'				=> $total_poin_saat_ini,
            'admin'						=> $this->ion_auth->get_user(),
		);

		$this->load->view('kedaluwarsa_reseller_pribadi/list_backup_data', $this->data);
	}

	public function delete_data($id = NULL){
		$this->db->delete('temporary_purchase_order', array('reseller_id' => $id));
		$this->db->delete('tukar_poin', array('reseller_id' => $id));
		$this->db->delete('purchase_order', array('reseller_id' => $id));

		$reseller = $this->db->get_where('meta', array('id' => $id))->row();
		$foto_profile = $reseller->foto_profile;

		if ($foto_profile != "") {
			unlink('./assets/images/foto_profile/'.$foto_profile);
			unlink('./assets/images/foto_profile/small_'.$foto_profile);
			unlink('./assets/images/foto_profile/middle_'.$foto_profile);
		}

		$this->ion_auth->delete_user($id);

		$this->session->set_flashdata('message_success', 'Berhasil Menghapus User');
        redirect('backend/kedaluwarsa_reseller_pribadi/index');
	}

}

/* End of file Kedaluwarsa_reseller_pribadi.php */
/* Location: ./application/modules/backend/controllers/Kedaluwarsa_reseller_pribadi.php */