<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karir extends Frontend_Controller {

	public function __construct()
	{
		parent::__construct();
		//load stencil
		$this->stencil->slice(array('head','categori_menu_extend','mobile_menu_extend','top_bar_extend','navbar_extend','modal','breadcrumb','navbar','site_footer_extend','footer'));
		//load model
		$this->load->model('karir_model', 'models');
	}

	public function index()
	{
		//set title
		$this->stencil->title('Career');
		//set layout
		$this->stencil->layout('frontend_layout');
		//set css
		//$this->stencil->css('bootstrap/bootstrap.min');
		//set js
		//$this->stencil->js('bootstrap/bootstrap.min');
		//set breadcrumb
		$this->load->library('breadcrumb');
		$this->breadcrumb->add('career', 'career');
		//get meta data
		$meta = frontend_controller::get_meta(11);
		//set metadata
		$this->stencil->meta(array(
            'description' 	=> $meta->deskripsi_seo,
            'keywords' 		=> $meta->keyword_seo,
            'author' 		=> 'Lolin Kids Care Product',
        ));
		//set data
		$data = array(
            'label'					=> 'Career',
            'deskripsi'				=> $meta->deskripsi,
        );

		//set view
		$this->stencil->paint('karir/index',$data);
	}

}

/* End of file Karir.php */
/* Location: ./application/modules/frontend/controllers/Karir.php */