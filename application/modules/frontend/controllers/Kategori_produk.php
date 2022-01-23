<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori_produk extends Frontend_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('kategori_produk_model');
	}

	public function index($id = NULL)
	{
		# BREACRUMB
		$this->load->library('breadcrumb');
		$this->breadcrumb->add('Product', 'product');

		# PAGINATION
		$this->load->library('pagination');
        
        $config['base_url'] = base_url().'product/page/';
        $config['total_rows'] = $this->kategori_produk_model->total_record();
        $config['per_page'] = 9;
        $config['uri_segment'] = 3;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);

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
		$config['first_url'] = site_url('product');

        $this->pagination->initialize($config); 
        
        $start = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data = $this->kategori_produk_model->get_product_list($config['per_page'], $start, $id);
        $pagination = $this->pagination->create_links();

        #echo $id;
        #print_r($data->result());

        # META
		$meta = frontend_controller::get_meta(2);
		
		$this->data = array(
            'title' 				=> $meta->judul,
            'description'			=> $meta->deskripsi_seo,
            'keyword'				=> $meta->keyword_seo,
            
            'label'							=> 'Produk Lolin',            
            'get_product_recomendation' 	=> $this->db->limit(20)->get('product'),
            'get_category_product_navbar'	=> $this->db->get('product_cat'),            
            'main_view'						=> 'kategori_produk/index',
            'stylesheet_source'				=> 'include/stylesheet/pagecontent/pagecontent_stylesheet',
			'javascript_source'				=> 'include/javascript/pagecontent/pagecontent_javascript',
			'tampil_produk'					=> $this->kategori_produk_model->tampil_produk(),
			'data' 							=> $data,
			'pagination' 					=> $pagination,
			'data_kategori_produk'			=> $this->kategori_produk_model->get_kategori_produk(),
			'iklan'							=> frontend_controller::get_iklan(3)->row(),
        );

		$url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_frontend', $url);

		$this->load->view('include/template/main', $this->data);
	}

}

/* End of file Kategori_produk.php */
/* Location: ./application/modules/frontend/controllers/Kategori_produk.php */