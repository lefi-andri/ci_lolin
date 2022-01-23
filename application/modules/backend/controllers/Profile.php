<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends Backend_Controller {

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
		$this->load->model('profile_model', 'models');
	}

	public function index()
	{
		//set title
		$this->stencil->title('Your Profile');
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
			'label'	=> 'Your Profile',
			'user' 				=> $this->ion_auth->get_user(),
		);

		//set view
		$this->stencil->paint('profile/index',$data);
	}

}

/* End of file Profile.php */
/* Location: ./application/modules/backend/controllers/Profile.php */