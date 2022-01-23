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
		
		$this->load->model('profile_model', 'models');
	}

	public function index()
	{
		$url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_backend', $url);
		
		#$id = $this->session->userdata('account_id');

		$this->load->library('breadcrumb');
		#$this->breadcrumb->add('Dashboard','adm_dashboard');

		$data = array(
            'title' 			=> 'Profile',            
            'main_view'			=> 'profile/index',
            #'data_profile'		=> $this->models->ambil_data_profile()->row(),
            'user' 				=> $this->ion_auth->get_user(),
        );
				
		$this->load->view('include/template',$data);
	}

}

/* End of file Profile.php */
/* Location: ./application/modules/backend/controllers/Profile.php */