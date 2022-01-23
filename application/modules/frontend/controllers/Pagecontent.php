<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pagecontent extends Frontend_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('pagecontent_model');
	}

	public function index($id = NULL)
	{
		if (empty($id)) {
			redirect(base_url(),'refresh');
		}

		$this->load->library('breadcrumb');
		if ($this->uri->segment(1) == 'about') {
			$this->breadcrumb->add('about', 'about');
		}elseif ($this->uri->segment(1) == 'prosedur') {
			$this->breadcrumb->add('prosedur', 'prosedur');
		}
		$this->breadcrumb->add(strtolower(str_replace('-', ' ', $id)), strtolower($id));

		$meta = $this->pagecontent_model->meta_tag_pagecontent($id)->row();



		$data = array(
            'title' 				=> $meta->contentTitle,
            'metadesc'				=> $meta->contentDescSeo,
            'metakeyword'			=> $meta->contentKeywordSeo,
            'content'				=> $meta->contentDesc,
            #'halaman_konten'		=> $halaman_konten,
            'label'					=> $meta->contentTitle,
            'main_view'				=> 'pagecontent/index',
            'stylesheet_source'		=> 'include/stylesheet/pagecontent/pagecontent_stylesheet',
			'javascript_source'		=> 'include/javascript/pagecontent/pagecontent_javascript',
        );

        #CHECK KONTEN
		if ($id == "faq") {

			$this->load->library('parser');
			$this->load->model('faq_model');
			$data['halaman_konten'] 	= $this->faq_model->showFaq();



			#$halaman_konten = $id;
		}else{
			#$halaman_konten = "";
			$data['halaman_konten'] = "";
		}
				
		$this->load->view('include/template/main', $data);
	}

	public function notfound()
	{
		$this->load->library('breadcrumb');
		$this->breadcrumb->add("page not found", "not-found");

		$data = array(
            'title' 				=> '',
            'metadesc'				=> '',
            'metakeyword'			=> '',
            'content'				=> '',
            'label'					=> "Page Not Found",
            'main_view'				=> 'pagecontent/index',
            'stylesheet_source'		=> 'include/stylesheet/pagecontent/pagecontent_stylesheet',
			'javascript_source'		=> 'include/javascript/pagecontent/pagecontent_javascript',
        );
				
		$this->load->view('include/template/main', $data);
	}

}

/* End of file Pagecontent.php */
/* Location: ./application/modules/frontend/controllers/Pagecontent.php */