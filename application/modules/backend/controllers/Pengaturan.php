<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaturan extends Backend_Controller {

	/*public $data = array(
		'main_view' 	=> 'pengaturan/form_pengaturan',
		'form_action' 	=> 'admin/pengaturan'
	);*/

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
		//set stecil
		$this->stencil->slice(array('head','navbar','header','side_panel','theme_configurator','footer','footer_javascript'));
		//load model
		$this->load->model('pengaturan_model');
	}

	public function index()
	{
		/*$this->load->helper('security');
		$this->load->library('breadcrumb');

		$url = $this->session->userdata('lolin_urlback_backend');
		$this->data['lolin_urlback_backend'] = $url;*/

		//set title
		$this->stencil->title('Pengaturan');
		//set layout
		$this->stencil->layout('backend_layout');
		//set css
		//$this->stencil->css('bootstrap/bootstrap.min');
		//set js
		//$this->stencil->js('bootstrap/bootstrap.min');

		$this->load->library('breadcrumb');

		$url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_backend', $url);

		//set metadata
		$this->stencil->meta(array(
            'author' 		=> 'Lefi Andri Lestari',
            'description' 	=> '',
            'keywords' 		=> ''
        ));

		//set data
		$this->data = array(
			'label'			=> 'Pengaturan',
			'form_action' 	=> 'admin/pengaturan'
		);

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
				//set view
				$this->stencil->paint('pengaturan/form_pengaturan',$this->data);
			} else {

				$input = $this->input->post(null, TRUE);

				if ($this->pengaturan_model->simpan_pengaturan($input) === TRUE) {

					$this->session->set_flashdata('message_success', 'Berhasil mengubah pengaturan.');
					redirect('admin/pengaturan');
				}else{
					
					$this->breadcrumb->add('Member', 'adm_member_area');
					$this->breadcrumb->add('Tambah Member', 'adm_member_area/add_member');

					$this->data['pesan_error'] = "Terjadi Kesalahan ";
					//set view
					$this->stencil->paint('pengaturan/form_pengaturan',$this->data);
				}

			}
		}else{

			$sms = $this->pengaturan_model->cari_set_ta();

			foreach ($sms as $key => $value) {
				$this->data['form_value'][$key] = $value;
			}

			$this->breadcrumb->add('Member', 'adm_member_area');
			$this->breadcrumb->add('Tambah Member', 'adm_member_area/add_member');

			//set view
			$this->stencil->paint('pengaturan/form_pengaturan',$this->data);
		}
	}

}

/* End of file Pengaturan.php */
/* Location: ./application/modules/backend/controllers/Pengaturan.php */