<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Testimoni extends Frontend_Controller {

	public function __construct()
	{
		parent::__construct();

		//load stencil
		$this->stencil->slice(array('head','categori_menu_extend','mobile_menu_extend','top_bar_extend','navbar_extend','modal','breadcrumb','navbar','site_footer_extend','footer'));
		//load model
		$this->load->model('testimoni_model', 'models');
	}

	public function index()
	{
		//set title
		$this->stencil->title('Testimoni');
		//set layout
		$this->stencil->layout('frontend_layout');
		//set css
		//$this->stencil->css('bootstrap/bootstrap.min');
		//set js
		//$this->stencil->js('bootstrap/bootstrap.min');
		//set breadcrumb
		$this->load->library('breadcrumb');
		$this->breadcrumb->add('Testimoni', 'testimoni');
		//get meta data
		$meta = frontend_controller::get_meta(2);
		//set metadata
		$this->stencil->meta(array(
            'description' 	=> $meta->deskripsi_seo,
            'keywords' 		=> $meta->keyword_seo,
            'author' 		=> 'Lolin Kids Care Product',
        ));
		//set data
		$data = array(
            'label'					=> 'Testimoni',
            'konten' 				=> $this->models->get_testimoni(),
        );

		//set view
		$this->stencil->paint('testimoni/index',$data);
	}

}

/* End of file Testimoni.php */
/* Location: ./application/modules/frontend/controllers/Testimoni.php */