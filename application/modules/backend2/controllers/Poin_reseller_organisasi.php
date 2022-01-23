<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Poin_reseller_organisasi extends Backend_Controller {

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
		
		$this->load->model('poin_reseller_organisasi_model', 'models');
	}

	public function index()
	{
		$this->load->library('breadcrumb');

		$url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_backend', $url);

		$this->load->library('table');

		$this->table->set_heading('No.', 'Nama Reseller', 'Total Poin', 'Poin Yang Ditukar', 'Sisa');

		$group = 'reseller_organisasi';
		$users = $this->ion_auth->get_users($group);

		$no = 1;
		foreach ($users as $value_user) {

			$total_semua_poin = core::hitung_total_poin($value_user->id);

			$total_semua_penukaran = core::hitung_tukar_poin($value_user->id);

			$total_poin_saat_ini = core::cek_poin_saat_ini($total_semua_poin, $total_semua_penukaran);

			$this->table->add_row(
				$no,
				anchor(base_url().'backend/rekaman_order_reseller_organisasi/data_rekaman/'.$value_user->id, $value_user->nama_lengkap, array(''=>'')),
				$total_semua_poin,
				$total_semua_penukaran,
				$total_poin_saat_ini
			);
			$no++;
		}

		core:: buat_tabel();

		$data = array(
			'main_view' => 'poin_reseller_organisasi/list_poin',
			'table' => $this->table->generate(),
		);

		$this->load->view('include/template', $data);
	}

}

/* End of file Poin_reseller_organisasi.php */
/* Location: ./application/modules/backend/controllers/Poin_reseller_organisasi.php */