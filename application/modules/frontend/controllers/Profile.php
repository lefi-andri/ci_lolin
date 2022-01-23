<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends Frontend_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('profile_model');
	}

	public function index()
	{
		$this->load->library('breadcrumb');
		$this->breadcrumb->add('Profile', 'profile');

		$url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_frontend', $url);

		$meta = frontend_controller::get_meta(2);
		
		$data = array(
            'title' 				=> $meta->judul,
            'description'			=> $meta->deskripsi_seo,
            'keyword'				=> $meta->keyword_seo,

            'label'					=> 'Profil',
            'content_profile' 		=> $this->db->get_where('content', ["contentId" => "2"])->row()->contentDesc,
            'main_view'				=> 'profile/index',
            'stylesheet_source'		=> 'include/stylesheet/pagecontent/pagecontent_stylesheet',
			'javascript_source'		=> 'include/javascript/pagecontent/pagecontent_javascript',
        );
				
		$this->load->view('include/template/main', $data);
	}

}

/* End of file Profile.php */
/* Location: ./application/modules/frontend/controllers/Profile.php */