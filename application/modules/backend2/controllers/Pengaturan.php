<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaturan extends Backend_Controller {

	public $data = array(
		'main_view' 	=> 'pengaturan/form_pengaturan',
		'form_action' 	=> 'admin/pengaturan'
	);

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
		
		$this->load->model('pengaturan_model');
	}

	public function index()
	{
		$this->load->helper('security');
		$this->load->library('breadcrumb');

		$url = $this->session->userdata('lolin_urlback_backend');
		$this->data['lolin_urlback_backend'] = $url;

		//tahun
		for ($i=date('Y'); $i >= 2007 ; $i--) { 
			$this->data['opt_filter'][$i] = $i;
		}
		
		$this->form_validation->set_rules('pengaturanTahun', 'Pengaturan Tahun', 'trim|required|xss_clean');
		$this->form_validation->set_rules('pengaturanOwnerName', 'Pengaturan Nama Pemilik', 'trim|required|xss_clean');
		$this->form_validation->set_rules('pengaturanCompanyName', 'Pengaturan Nama Perusahaan', 'trim|required|xss_clean');
		$this->form_validation->set_rules('pengaturanEmail', 'Pengaturan Email', 'trim|required|xss_clean');

		if (isset($_POST['submit'])) {
			if ($this->form_validation->run() == FALSE) {

				$this->breadcrumb->add('Member', 'adm_member_area');
				$this->breadcrumb->add('Tambah Member', 'adm_member_area/add_member');
				
				$this->data['pesan_error'] = "Terjadi Kesalahan ";
				$this->load->view('include/template', $this->data);
			} else {

				$input = $this->input->post(null, TRUE);

				if ($this->pengaturan_model->simpan_pengaturan($input) === TRUE) {

					$this->session->set_flashdata('message_success', 'Berhasil mengubah pengaturan.');
					redirect('admin/pengaturan');
				}else{
					
					$this->breadcrumb->add('Member', 'adm_member_area');
					$this->breadcrumb->add('Tambah Member', 'adm_member_area/add_member');

					$this->data['pesan_error'] = "Terjadi Kesalahan ";
					$this->load->view('include/template', $this->data);
				}

			}
		}else{

			$sms = $this->pengaturan_model->cari_set_ta();

			foreach ($sms as $key => $value) {
				$this->data['form_value'][$key] = $value;
			}

			$this->breadcrumb->add('Member', 'adm_member_area');
			$this->breadcrumb->add('Tambah Member', 'adm_member_area/add_member');

			$this->load->view('include/template', $this->data);
		}
	}

}

/* End of file Pengaturan.php */
/* Location: ./application/modules/backend/controllers/Pengaturan.php */