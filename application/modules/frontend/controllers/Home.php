<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Frontend_Controller {

	public function __construct()
	{
		parent::__construct();
		//load stencil
		$this->stencil->slice(array('head','categori_menu_extend','mobile_menu_extend','top_bar_extend','navbar_extend','modal','breadcrumb','navbar','site_footer_extend','footer'));
		//load model
		$this->load->model('home_model', 'models');		
	}

	public function index()
	{
		//set title
		$this->stencil->title('Home');
		//set layout
		$this->stencil->layout('frontend_layout');
		//set css
		//$this->stencil->css('bootstrap/bootstrap.min');
		//set js
		//$this->stencil->js('bootstrap/bootstrap.min');
		//set breadcrumb
		$this->load->library('breadcrumb');
		$this->breadcrumb->add('about us', 'about_us');
		//set metadata
		$this->stencil->meta(array(
            'description' 	=> 'Lolin merupakan produk perawatan khusus anak dengan varian Shampoo, Conditioner, Facial Wash, dan Body Lotion.',
            'keywords' 		=> 'lolin, lolin kids care product, perawatan anak sejak dini, perawatan anak, produk anak, shampoo anak, conditioner anak, facial wash anak, body lotion anak',
            'author' 		=> 'Lolin Kids Care Product',
        ));

		//get meta data
		$meta = frontend_controller::get_meta(2);
		//set data
		$data = array(
            'label'					=> 'Home',
            'introduction'			=> $this->models->get_introduction()->row(),
            'terdaftar'				=> $this->models->get_terdaftar()->row(),
            'bersertifikat'			=> $this->models->get_bersertifikat()->row(),
            'free_paraben'			=> $this->models->get_free_paraben()->row(),
            'no_allergents'			=> $this->models->get_no_allergents()->row(),

            'instagram'				=> $this->models->get_instagram(),
            'banner'				=> $this->models->get_banner(),
            'flyer' 				=> $this->models->get_flyer(),
            'tag_line'				=> $this->models->get_tag_line(),
            'produk_lolin'			=> $this->models->get_product(),
            'product_recomend' 		=> $this->db->limit(8)->get('product')->result_array(),
            'produk'				=> $this->models->get_top_product(),
            'blog'					=> $this->models->get_new_blog(),
            'event'					=> $this->models->get_best_event(),
            'iklan'					=> frontend_controller::get_iklan(1)->row(),
            'pengaturan_email'		=> frontend_controller::get_pengaturan_email(),
        );

		//set view
		$this->stencil->paint('home/index',$data);		
	}

	public function hasil_pencarian()
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
		$this->breadcrumb->add('search', 'search');
		//set metadata
		$this->stencil->meta(array(
            'description' 	=> 'Lolin merupakan produk perawatan khusus anak dengan varian Shampoo, Conditioner, Facial Wash, dan Body Lotion.',
            'keywords' 		=> 'lolin, lolin kids care product, perawatan anak sejak dini, perawatan anak, produk anak, shampoo anak, conditioner anak, facial wash anak, body lotion anak',
            'author' 		=> 'Lolin Kids Care Product',
        ));

        //load library
        $this->load->helper(array('antiinjection','antisymbol'));

		//get meta data
		$meta = frontend_controller::get_meta(2);
		//set data
		$this->data = array(
            'label'					=> 'Search',
            
            'label'					=> 'Hasil Pencarian',
			'myClass' 				=> $this,
			'keyword'				=> $this->input->GET('keyword', TRUE),
        );

        $key = antisymbol(antiinjection($this->input->GET('keyword', TRUE)));

		if (!$this->input->GET('keyword', TRUE)) {			
			echo "<script>window.alert('Silahkan isi kotak pencarian !');window.location='".base_url()."';</script>";			
		}

		$cari = $this->models->cari($key);

		$this->data['result'] = $cari;

		//set view
		$this->stencil->paint('home/list_search', $this->data);
	}

}

/* End of file Home.php */
/* Location: ./application/modules/frontend/controllers/Home.php */