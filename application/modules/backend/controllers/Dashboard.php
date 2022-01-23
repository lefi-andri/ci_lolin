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
		
		//set stecil
		$this->stencil->slice(array('head','navbar','header','side_panel','theme_configurator','footer','footer_javascript'));
		//set model
		$this->load->model('dashboard_model', 'model');
	}

	public function index()
	{
		//set title
		$this->stencil->title('Dashboard');
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
		$data = array(
			'label'	=> 'Dashboard',
			'konten_halaman'	=> $this->db->get('konten_halaman')->num_rows(),
			'blog'				=> $this->db->get('blog')->num_rows(),
			'produk'			=> $this->db->get('product')->num_rows(),
			'pesan_contact'		=> $this->db->get('contact_me')->num_rows(),
		);

		//set view
		$this->stencil->paint('dashboard/index',$data);
	}

}

/* End of file Dashboard.php */
/* Location: ./application/modules/backend/controllers/Dashboard.php */