<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notfound extends Frontend_Controller {

	public function __construct()
	{
		parent::__construct();
		
		//load stencil
		$this->stencil->slice(array('head','categori_menu_extend','mobile_menu_extend','top_bar_extend','navbar_extend','modal','breadcrumb','navbar','site_footer_extend','footer'));
	}

	public function index()
	{
		//set title
		$this->stencil->title('Oops. Halaman tidak ditemukan 404');
		//set layout
		$this->stencil->layout('frontend_layout');
		//set css
		//$this->stencil->css('bootstrap/bootstrap.min');
		//set js
		//$this->stencil->js('bootstrap/bootstrap.min');
		//set breadcrumb
		$this->load->library('breadcrumb');
		$this->breadcrumb->add('not found', 'not_found');
		//get meta data
		$meta = frontend_controller::get_meta(2);
		//set metadata
		$this->stencil->meta(array(
            'description' 	=> 'Lolin merupakan produk perawatan khusus anak dengan varian Shampoo, Conditioner, Facial Wash, dan Body Lotion.',
            'keywords' 		=> 'lolin, lolin kids care product, perawatan anak sejak dini, perawatan anak, produk anak, shampoo anak, conditioner anak, facial wash anak, body lotion anak',
            'author' 		=> 'Lolin Kids Care Product',
        ));
		//set data
		$data = array(
            'label'			=> '',
        );

		//set view
		$this->stencil->paint('404/index',$data);
	}

}

/* End of file Notfound.php */
/* Location: ./application/modules/frontend/controllers/Notfound.php */