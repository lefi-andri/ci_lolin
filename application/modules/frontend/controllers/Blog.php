<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends Frontend_Controller {

	public function __construct()
	{
		parent::__construct();
		//load stencil
		$this->stencil->slice(array('head','categori_menu_extend','mobile_menu_extend','top_bar_extend','navbar_extend','modal','breadcrumb','navbar','site_footer_extend','footer'));
		//load model
		$this->load->model('blog_model', 'models');
		//load helper
		$this->load->helper('indonesiandate');
	}

	public function index()
	{
		//set title
		$this->stencil->title('Blog');
		//set layout
		$this->stencil->layout('frontend_layout');
		//set css
		//$this->stencil->css('bootstrap/bootstrap.min');
		//set js
		//$this->stencil->js('bootstrap/bootstrap.min');
		//set breadcrumb
		$this->load->library('breadcrumb');
		$this->breadcrumb->add('artikel', 'blog');
		//set url back
		$url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_frontend', $url);

		$this->load->library('pagination');
        
        $config['base_url'] = base_url().'blogs/page/';
        $config['total_rows'] = $this->models->total_record();
        $config['per_page'] = 4;
        $config['uri_segment'] = 3;
        $config['query_string_segment'] = 'start';
		$config['full_tag_open'] = '<nav class="pagination"><div class="column"><ul class="pages">';
		$config['full_tag_close'] = '</ul></div></nav>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = 'Next';
		$config['next_tag_open'] = '<span class="column text-right hidden-xs-down"><span class="btn btn-outline-secondary btn-sm">';
		$config['next_tag_close'] = '<i class="icon-arrow-right"></i></span></span>';
		$config['prev_link'] = 'Prev';
		$config['prev_tag_open'] = '<span class="column text-left hidden-xs-down"><span class="btn btn-outline-secondary btn-sm"><i class="icon-arrow-left"></i>';
		$config['prev_tag_close'] = '</span></span>';
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['first_url'] = site_url('blog');
		#$config['use_page_numbers'] = TRUE;

        $this->pagination->initialize($config); 
        
        $start = $this->uri->segment(3, 0);
        $rows = $this->models->user_limit($config['per_page'],$start)->result();

        //get meta data
		$meta = frontend_controller::get_meta(10);
		//set metadata
		$this->stencil->meta(array(
            'description' 	=> $meta->deskripsi_seo,
            'keywords' 		=> $meta->keyword_seo,
            'author' 		=> 'Lolin Kids Care Product',
        ));
		//set data
		$this->data = array(
			'label'					=> 'Artikel',
			'rows' 					=> $rows,
			'pagination' 			=> $this->pagination->create_links(),
			'kategori_blog'			=> $this->models->get_kategori_blog(),
			'random_post'			=> $this->models->get_random_post(),
			'tags'					=> $this->models->get_tags(),
			'iklan'					=> frontend_controller::get_iklan(27)->row(),
        );

		//set view
		$this->stencil->paint('blog/list_blog',$this->data);
	}

	public function baca_blog($id = NULL)
	{
		$query = $this->models->check_artikel($id);
		if ($query->num_rows() == 0) {
			$this->session->set_flashdata('message_warning', 'Tidak ditemukan artikel.');
			$url = $this->session->userdata('lolin_urlback_frontend');
			redirect($url);
		}

		$this->load->library('breadcrumb');
		$this->breadcrumb->add('artikel', 'blog');
		$this->breadcrumb->add(strtolower($query->row()->judul), $query->row()->slug);

		$link_previous = $this->models->link_previous($id);
		if ($link_previous === FALSE) {
			$true_link_prev = "";
		}else{
			$true_link_prev = "<a class='btn btn-outline-secondary btn-sm' href='".$link_previous->row()->slug."'><i class='icon-arrow-left'></i>&nbsp;Prev</a>";
		}

		$link_next = $this->models->link_next($id);
		if ($link_next === FALSE) {
			$true_link_next = "";
		}else{
			$true_link_next = "<a class='btn btn-outline-secondary btn-sm' href='".$link_next->row()->slug."'>Next&nbsp;<i class='icon-arrow-right'></i></a>";
		}

		//get meta data
		$meta = frontend_controller::get_meta(10);
		//get judul blog
		$get_judul = $this->models->get_judul($id)->row()->judul;
		//set title
		$this->stencil->title($get_judul.' - '.$meta->judul);
		//set layout
		$this->stencil->layout('frontend_layout');
		//set css
		//$this->stencil->css('bootstrap/bootstrap.min');
		//set js
		//$this->stencil->js('bootstrap/bootstrap.min');
		//set breadcrumb
		$this->load->library('breadcrumb');
		$this->breadcrumb->add('faq', 'faq');
		
		//set metadata
		$this->stencil->meta(array(
            'description' 	=> $meta->deskripsi_seo,
            'keywords' 		=> $get_judul.', '.$meta->keyword_seo,
            'author' 		=> 'Lolin Kids Care Product',
        ));
		//set data
		$this->data = array(
            'label'			=> 'Artikel',            
            'content_title'	=> $this->db->order_by('id', 'desc')->get('blog')->result(),
            'content'		=> $query->result(),
            'main_view'		=> 'blog/baca_blog',

            'link_home'		=> base_url('blog'),
            'link_prev'		=> $true_link_prev,
            'link_next'		=> $true_link_next,
            'random_post'	=> $this->models->get_random_post_read_blog(),
        );        
		//set view
		$this->stencil->paint('blog/baca_blog',$this->data);
	}

	public function hasil_pencarian()
	{
		$this->load->helper(array('antiinjection','antisymbol','security'));
		
		//set title
		$this->stencil->title('Search Result');
		//set layout
		$this->stencil->layout('frontend_layout');
		//set css
		//$this->stencil->css('bootstrap/bootstrap.min');
		//set js
		//$this->stencil->js('bootstrap/bootstrap.min');
		//set breadcrumb
		$this->load->library('breadcrumb');
		$this->breadcrumb->add(strtolower('search result'), strtolower('home'));
		//get meta data
		$meta = frontend_controller::get_meta(10);
		//set metadata
		$this->stencil->meta(array(
            'description' 	=> $meta->deskripsi_seo,
            'keywords' 		=> $meta->keyword_seo,
            'author' 		=> 'Lolin Kids Care Product',
        ));
        //set data
		$this->data = array(
			'label'					=> 'Hasil Pencarian',
            'meta_deskripsi'     	=> $meta->deskripsi,
			'myClass' 				=> $this,
			'keyword'				=> $this->input->GET('keyword', TRUE),
		);

		$key = antisymbol(antiinjection($this->input->GET('keyword', TRUE)));

		if (!$this->input->GET('keyword', TRUE)) {			
			echo "<script>window.alert('Silahkan isi kotak pencarian !');window.location='".base_url('blog')."';</script>";			
		}

		$cari = $this->models->cari($key);

		$this->data['result'] = $cari;

		//set view
		$this->stencil->paint('blog/list_cari_blog',$this->data);
	}

}

/* End of file Blog.php */
/* Location: ./application/modules/frontend/controllers/Blog.php */