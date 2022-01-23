<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faq extends Frontend_Controller {

	public function __construct()
	{
		parent::__construct();
		//load stencil
		$this->stencil->slice(array('head','categori_menu_extend','mobile_menu_extend','top_bar_extend','navbar_extend','modal','breadcrumb','navbar','site_footer_extend','footer'));
		//load model
		$this->load->model('faq_model', 'models');
	}

	public function index()
	{
		//set title
		$this->stencil->title('Faq');
		//set layout
		$this->stencil->layout('frontend_layout');
		//set css
		//$this->stencil->css('bootstrap/bootstrap.min');
		//set js
		//$this->stencil->js('bootstrap/bootstrap.min');
		//set breadcrumb
		$this->load->library('breadcrumb');
		$this->breadcrumb->add('faq', 'faq');
		//get meta data
		$meta = frontend_controller::get_meta(7);
		//set metadata
		$this->stencil->meta(array(
            'description' 	=> $meta->deskripsi_seo,
            'keywords' 		=> $meta->keyword_seo,
            'author' 		=> 'Lolin Kids Care Product',
        ));

		//set data
		$data = array(
            'label'					=> 'Frequently Asked Questions',
            'konten'				=> $this->models->get_faq(),
        );

		//set view
		$this->stencil->paint('faq/index',$data);
	}

}

/* End of file Faq.php */
/* Location: ./application/modules/frontend/controllers/Faq.php */