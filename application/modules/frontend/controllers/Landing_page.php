<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Landing_page extends Frontend_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here

		$this->load->model('profile_model');
	}

	public function index()
	{
		if (!$this->session->flashdata('registrasi_berhasil')) {
			redirect(base_url(),'refresh');
		}

		$this->load->library('breadcrumb');
		$this->breadcrumb->add('Profile', 'profile');

		$meta = frontend_controller::get_meta(2);
		
		$data = array(
            'title' 				=> $meta->judul,
            'description'			=> $meta->deskripsi_seo,
            'keyword'				=> $meta->keyword_seo,
            
            'label'					=> 'Success',
            #'content_profile' 		=> $this->db->get_where('content', ["contentId" => "2"])->row()->contentDesc,
            'main_view'				=> 'landing_page/index',
            'stylesheet_source'		=> 'include/stylesheet/pagecontent/pagecontent_stylesheet',
			'javascript_source'		=> 'include/javascript/pagecontent/pagecontent_javascript',
        );
				
		$this->load->view('include/template/main', $data);
	}

}

/* End of file Landing_page.php */
/* Location: ./application/modules/frontend/controllers/Landing_page.php */