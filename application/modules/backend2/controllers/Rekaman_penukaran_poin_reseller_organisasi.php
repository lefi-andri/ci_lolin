<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekaman_penukaran_poin_reseller_organisasi extends Backend_Controller {

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
		
		$this->load->model('rekaman_penukaran_poin_reseller_organisasi_model', 'models');
	}

	public function index()
	{
		$this->load->library('breadcrumb');

		$url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_backend', $url);

		$this->load->library('table');

		$this->table->set_heading(array('No.', 'Nama Organisasi', 'Alamat','Nama Perwakilan Organisasi','Reseller Aktif', ''));

		$group = 'reseller_organisasi';
		$users = $this->ion_auth->get_users($group);

		$no = 1;
		foreach ($users as $value) {
			$this->table->add_row(array(
				$no, 
				$value->nama_organisasi,
				$value->alamat_organisasi,
				$value->nama_lengkap,
				($value->active == '1') ? 'Ya' : 'Tidak',
				anchor(base_url().'backend/rekaman_penukaran_poin_reseller_organisasi/data_rekaman/'.$value->id, 'Lihat Data', array('class'=>'btn btn-warning btn-xs')),
			));
			$no++;
		}

		core:: buat_tabel();

		$this->data = array(
			'main_view' 	=> 'rekaman_penukaran_poin_reseller_organisasi/list_reseller',
			'table' 		=> $this->table->generate(),
		);

		$this->load->view('include/template', $this->data);
	}

	public function data_rekaman($id = NULL){

		$this->load->library('breadcrumb');

		$this->load->library('table');

		$this->table->set_heading(array('No.', 'Kode Penukaran', 'Nama Bonus', 'Poin', 'Tanggal Tukar'));

		$data_rekaman = $this->models->get_rekaman_penukaran($id);

		$total_tukar=0;
		$no = 1;
		foreach ($data_rekaman->result() as $value_rekaman) {
			$this->table->add_row(array(
				$no,
				$value_rekaman->kode_tukar_poin,
				$value_rekaman->nama_jenis_bonus,
				$value_rekaman->poin_bonus,
				$value_rekaman->tanggal_tukar_poin
			));
			$no++;

			$total_tukar += $value_rekaman->poin_bonus;
		}

		core:: buat_tabel();

		$this->data = array(
			'main_view' 	=> 'rekaman_penukaran_poin_reseller_organisasi/list_rekaman_penukaran_poin',
            'table' 		=> $this->table->generate(),
            'total'			=> $total_tukar,
		);

		$this->load->view('include/template', $this->data);
	}

}

/* End of file Rekaman_penukaran_poin_reseller_organisasi.php */
/* Location: ./application/modules/backend/controllers/Rekaman_penukaran_poin_reseller_organisasi.php */