<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About_us extends Frontend_Controller {

	public function __construct()
	{
		parent::__construct();
		//load stencil
		$this->stencil->slice(array('head','categori_menu_extend','mobile_menu_extend','top_bar_extend','navbar_extend','modal','breadcrumb','navbar','site_footer_extend','footer'));
		//load model
		$this->load->model('about_us_model', 'models');
	}

	public function index()
	{
		//set title
		$this->stencil->title('About Us');
		//set layout
		$this->stencil->layout('frontend_layout');
		//set css
		//$this->stencil->css('bootstrap/bootstrap.min');
		//set js
		//$this->stencil->js('bootstrap/bootstrap.min');
		//set breadcrumb
		$this->load->library('breadcrumb');
		$this->breadcrumb->add('about us', 'about_us');
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
            'label'					=> 'About Us',
            'content_profile' 		=> $this->db->get_where('content', ["contentId" => "2"])->row()->contentDesc,
        );

		//set view
		$this->stencil->paint('pensil/index',$data);
	}

}

/* End of file About_us.php */
/* Location: ./application/modules/frontend/controllers/About_us.php */