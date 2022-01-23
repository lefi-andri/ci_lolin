<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends Frontend_Controller {

	public function __construct()
	{
		parent::__construct();
		//load stencil
		$this->stencil->slice(array('head','categori_menu_extend','mobile_menu_extend','top_bar_extend','navbar_extend','modal','breadcrumb','navbar','site_footer_extend','footer'));
		//load model
		$this->load->model('product_model');

		#$this->load->library('form_validation');
		$this->load->library(array('cart'));
		$this->load->helper(array('url','form'));
	}

	public function index()
	{
		//set title
		$this->stencil->title('Shop');
		//set layout
		$this->stencil->layout('frontend_layout');
		//set css
		//$this->stencil->css('bootstrap/bootstrap.min');
		//set js
		//$this->stencil->js('bootstrap/bootstrap.min');
		//set breadcrumb
		$this->load->library('breadcrumb');
		$this->breadcrumb->add('shop', 'product');
		//get meta data
		$meta = frontend_controller::get_meta(3);
		//set metadata
		$this->stencil->meta(array(
			'description'	=> $meta->deskripsi_seo,
            'keywords'		=> $meta->keyword_seo,
            'author' 		=> 'Lolin Kids Care Product',
        ));

		$this->load->library('pagination');
        
        $config['base_url'] = base_url().'product/page/';
        $config['total_rows'] = $this->product_model->total_record();
        $config['per_page'] = 15;
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
        $data = $this->product_model->get_product_list($config['per_page'], $start);
        $pagination = $this->pagination->create_links();

		//set data
		$data = array(
            'label'							=> 'Shop',
            'get_product_recomendation' 	=> $this->db->limit(20)->get('product'),
            'get_category_product_navbar'	=> $this->db->get('product_cat'),            
            'main_view'						=> 'product/index',
            'stylesheet_source'				=> 'include/stylesheet/pagecontent/pagecontent_stylesheet',
			'javascript_source'				=> 'include/javascript/pagecontent/pagecontent_javascript',
			'tampil_produk'					=> $this->product_model->tampil_produk(),
			'data' 							=> $data,
			'pagination' 					=> $pagination,
			'data_kategori_produk'			=> $this->product_model->get_kategori_produk(),
			'iklan'							=> frontend_controller::get_iklan(3)->row(),
        );
		//url back
        $url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_frontend', $url);

		//set view
		$this->stencil->paint('product/index',$data);
	}

	public function showProduk($id)
	{
		$getId 			= $this->db->get_where('product',array('prodsSlug'=>$id))->row();
		$getResult 		= $this->db->get_where('product',array('prodsSlug'=>$id))->num_rows();

		if ($getResult > 0) {

			$this->load->library('breadcrumb');				
			
			
			$this->db->select('
			    a.prodsId,
			    a.prodsName,
			    a.catprodsId,
			    a.prodsSlug,
			    a.prodsFrontPic,
			    a.prodsBackPic,
			    a.prodsDesc,
			    a.prodsKode,
			    a.prodsNetto,
			    a.prodsDirections,
			    a.prodsIngredients,
			    a.prodsPrice,
			    a.nomor_bpom,
			    b.directDirect, 
			    c.ingredValue,
			');
			$this->db->from('product a');
			$this->db->join('product_directions b', 'a.prodsId = b.prodsId', 'left');
			$this->db->join('product_ingredients c', 'a.prodsId = c.prodsId', 'left');		
			$this->db->where('a.prodsId', $getId->prodsId);
			$query = $this->db->get();

			//get meta data
			$meta = frontend_controller::get_meta(3);
			//get judul
			$get_judul = $this->product_model->get_judul($id)->row()->prodsName;
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
			$this->breadcrumb->add('product', 'product');
			$this->breadcrumb->add(strtolower($getId->prodsName), strtolower($getId->prodsSlug));
			//set metadata
			$this->stencil->meta(array(

	            'description' 	=> $meta->deskripsi_seo,
	            'keywords' 		=> $get_judul.', '.$meta->keyword_seo,
	            'author' 		=> 'Lolin Kids Care Product',
	        ));
			
			//set data
			$data = array(
	            'label'							=> 'Produk Lolin',           
	            'description_of_product' 		=> $query,
	            'get_category_product_navbar'	=> $this->db->get('product_cat'),
	            'get_product_recomendation'		=> $this->db->limit(6)->get('product'),
	            'slug_produk'					=> $id,
	        );

	        //url back
	        $url = $this->session->userdata('lolin_urlback_frontend');
			$this->data['lolin_urlback_frontend'] = $url;
			//set view
			$this->stencil->paint('product/product_view',$data);

		}else{

			$this->session->set_flashdata('message_info', 'Produk tidak tersedia');
			$url = $this->session->userdata('lolin_urlback_frontend');
			redirect($url);
		}
	}

	public function looks()
	{
		$get_id_product = $_POST['rowid'];

		if (!$get_id_product) {
			$this->session->set_flashdata('message_info', 'Produk tidak tersedia');
			$url = $this->session->userdata('lolin_urlback_frontend');
			redirect($url);
		}else{
			$this->data = array(
				'id' 		=> $get_id_product, 
				'content' 	=> $this->product_model->modal_ambil_data_produk($get_id_product),
			);
		}

		$this->load->view('product/modal_detail_produk', $this->data);
	}

	public function tambah() {

		$id = $this->input->post('product_id');
		$price = $this->input->post('price');
		$name = $this->input->post('product_name');


		$konten = array();
		foreach ($this->cart->contents() as $items) {
			$konten[] = $items['id'];
		}


		if (in_array($id, $konten))
		{
			$jumlah_unit = 0;
		}
		else
		{
			$jumlah_unit = 1;
		}


		$this->db->where('prodsId', $id);
		$query = $this->db->get('product', 1);

		if ($query->num_rows() > 0) {

			foreach ($query->result() as $row)
			{

				$this->db->select('MIN(diskon_id) AS min_diskon_id, jumlah_unit, diskon_id');
		        $this->db->from('diskon_harga');
		        $this->db->where('produk_id', $id);
		        $this->db->where('harga_jumlah_unit !=', 0);
		        $disc_hrg = $this->db->get()->row();

				$data = array(
					'id'      => $id,
					#'qty'     => $disc_hrg->jumlah_unit,
					'qty'     => $jumlah_unit,
					'price'   => $row->prodsPrice,
					'name'    => $row->prodsName
				);

				$this->cart->insert($data);
				
			}
			
		}
	}

	public function tes_keranjang(){
		$data = array(
		        'id'      => 'sku_123ABC',
		        'qty'     => 1,
		        'price'   => 39.95,
		        'name'    => 'T-Shirt',
		        'options' => array('Size' => 'L', 'Color' => 'Red')
		);

		$this->cart->insert($data);

		redirect(base_url().'frontend/product');
	}
	
	public function update_cart(){
		$total = $this->cart->total_items();
		$item = $this->input->post('rowid');
		$qty = $this->input->post('qty');

		for($i=0;$i < $total;$i++)
		{
			$data = array(
			   'rowid' => $item[$i],
			   'qty'   => $qty[$i]
			);
			
			$this->cart->update($data);
		}
		redirect('cart');
	}

	public function show_cart() {
		$this->load->view('product/list_cart');
	}
		
	public function empty_cart() {
		$this->cart->destroy();
		redirect(base_url().'frontend/product');
	}

	public function total_cart() {
		$data['total'] = $this->cart->total_items();
		$this->load->view('product/total',$data);
	}

	public function total_all_cart() {
		
		$produk = $this->session->userdata('order_produk_dipilih');
		$diskon_id = $this->session->userdata('jumlah_order_reseller');

		$jumlah_data = count($produk);
		$no = 1;
		$total_semua_unit = 0;
		for ($i=0; $i < $jumlah_data; $i++) {
			
			$get_jumlah = $this->db->get_where('diskon_harga', array('diskon_id'=>$diskon_id[$i]))->row();

			$total_semua_unit += $get_jumlah->jumlah_unit;

		}

		echo $total_semua_unit.' Item';
	}

	//Sintak Untuk Menimpan ke database
	public function pesanSekarang() {
		$this->form_validation->set_rules('IDpesanan[]', 'kode_pesanan', 'required|trim|xss_clean');
		$this->form_validation->set_rules('qty[]', 'qty', 'required|trim|xss_clean');
		$this->form_validation->set_rules('produk[]', 'produk', 'required|trim|xss_clean');
		$this->form_validation->set_rules('harga_satuan[]', 'hrg_satuan', 'required|trim|xss_clean');
		
		if ($this->form_validation->run() == FALSE){
			echo validation_errors(); // tampilkan apabila ada error
		}else{
			
			$kp = $this->input->post('IDpesanan');
			$tg = date('Y-m-d H-i-s');
			$result = array();
			foreach($kp AS $key => $val){
				$result[] = array(
					"kode_pesanan" 	=> $_POST['IDpesanan'][$key],
					"qty"          	=> $_POST['qty'][$key],
					"produk"       	=> $_POST['produk'][$key],
					"hrg_satuan"        => $_POST['harga_satuan'][$key],
					"tgl" 			=> $tg,
					"status" 		=> 'Baru'
				);
			}            
			
			$res = $this->db->insert_batch('pesanan', $result); // fungsi dari codeigniter untuk menyimpan multi array
			
			if($res){
				echo "Barang Sudah Dipesan";
				redirect('cart');
			}else{
				echo "gagal di input";
			}
		}
	}


	public function my_cart(){
		if(count($this->cart->contents()) != 0){
			//set view
         	$this->load->view('pages/product/my_cart_not_empty');
        }else{
           	//set view
          	$this->load->view('pages/product/my_cart_empty');
        }
	}

}

/* End of file Product.php */
/* Location: ./application/modules/frontend/controllers/Product.php */