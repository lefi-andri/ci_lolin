<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Backend_Controller {

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
		
		$this->load->model('dashboard_model', 'model');
	}

	public function index()
	{
		

		$url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_backend', $url);
		
		$this->load->library('breadcrumb');
		$this->breadcrumb->add('Dashboard','adm_dashboard');

		$data = array(
			'konten_halaman'	=> $this->db->get('konten_halaman')->num_rows(),
			'blog'				=> $this->db->get('blog')->num_rows(),
			'produk'			=> $this->db->get('product')->num_rows(),
			'pesan_contact'		=> $this->db->get('contact_me')->num_rows(),
            'title' 			=> 'Backend Form Administrator',            
            'main_view'			=> 'dashboard/index',
        );
				
		$this->load->view('include/template',$data);
	}

}

/* End of file Dashboard.php */
/* Location: ./application/modules/backend/controllers/Dashboard.php */