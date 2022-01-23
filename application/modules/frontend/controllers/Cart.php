<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends Frontend_Controller {

	public function __construct()
	{
		parent::__construct();
		
		//$this->load->library('form_validation');
		$this->load->library(array('cart'));
		$this->load->helper(array('url','form'));
		//load stencil
		$this->stencil->slice(array('head','categori_menu_extend','mobile_menu_extend','top_bar_extend','navbar_extend','modal','breadcrumb','navbar','site_footer_extend','footer'));
		//load model
		$this->load->model('cart_model', 'models');
	}

	public function index()
	{
		//cek session total order
		if ($this->session->userdata('total_order')) {
			$this->session->unset_userdata('total_order');
		}
		//set title
		$this->stencil->title('My Cart');
		//set layout
		$this->stencil->layout('frontend_layout');
		//set css
		//$this->stencil->css('bootstrap/bootstrap.min');
		//set js
		//$this->stencil->js('bootstrap/bootstrap.min');
		//set breadcrumb
		$this->load->library('breadcrumb');
		$this->breadcrumb->add('cart', 'cart');
		//get meta
		$meta = frontend_controller::get_meta(3);
		//set metadata
		$this->stencil->meta(array(
            'description' 	=> $meta->deskripsi_seo,
            'keywords' 		=> $meta->keyword_seo,
            'author' 		=> 'Lolin Kids Care Product',
        ));

        $this->load->library('table');

		$this->table->set_heading('PRODUCT', '', 'DETAILS', (!$this->ion_auth->logged_in()) ?'PRICE': '', ($this->ion_auth->logged_in()) ?'QTY - MEMBER PRICE': '', 'QTY', 'QTY TOTAL', anchor(base_url().'index.php/frontend/product/empty_cart', 'Clear Cart', array('class'=>'btn btn-sm btn-outline-danger')));

		$no = 1;
		$berat_pembelian = 0;
		foreach ($this->cart->contents() as $items) {

			$item_id = $items['id'];

			$much_item = array();
			for ($i = 0; $i <= 5 ; $i++) {
				$much_item[] = $i;
			}
			

			$dropdown = $this->models->dropdown_diskonan($items['id']);
			if (!$this->ion_auth->logged_in())
			{
				$item_qty = form_dropdown('qty[]', $much_item, $items['qty'], array('onchange'=>'updating_cart('.$item_id.')', 'id' => 'updating_cart_item'.$item_id, 'class'=>'form-control', 'required'=>'required', 'style'=>'width: 100px;'));
			}else{
				$item_qty = form_dropdown('qty[]', $dropdown, $items['qty'], array('onchange'=>'updating_cart('.$item_id.')', 'id' => 'updating_cart_item'.$item_id, 'class'=>'form-control', 'required'=>'required', 'style'=>'width: 100px;'));
			}


			//Cari diskon harga
			$this->db->select('*');
			$this->db->where('jumlah_unit !=', 0);
			$this->db->where('produk_id', $items['id']);
			$get_bonus = $this->db->get('diskon_harga');

			$ret_jumlah_unit = array();
			$ret_harga_jumlah_unit = array();
			foreach ($get_bonus->result() as $value_bonus) {
				$ret_jumlah_unit[] = $value_bonus->jumlah_unit;
				$ret_harga_jumlah_unit[] = $value_bonus->harga_jumlah_unit;
			}

			$jumlah_bonus_ada = count($ret_harga_jumlah_unit);

			$retetan_bonus = array();
			for ($i=0; $i < $jumlah_bonus_ada; $i++) { 
				$retetan_bonus[] = $ret_jumlah_unit[$i]." - Rp. ".number_format($ret_harga_jumlah_unit[$i], 0, ".", ".");
			}
			$serial_retetan_bonus = serialize($retetan_bonus);
			$imp_retetan_bonus 		= implode("<br> ",unserialize($serial_retetan_bonus));
			


			$this->db->select('*');
			$this->db->from('product');
			$this->db->where('prodsId', $items['id']);
			$data_produk = $this->db->get()->row();

			$this->table->add_row(
				#$no.
				anchor(base_url().'product/'.$data_produk->prodsSlug, '<img src="'.base_url().'assets/images/product/front_of_product/middle_'.$data_produk->prodsFrontPic.'" alt="" width="200px">', array('' => '')).
				form_hidden('product_id[]', $items['id']).
				form_hidden('rowid[]', $items['rowid']).// id produk
				form_hidden('price[]', $items['price']),// price

				anchor(base_url().'product/'.$data_produk->prodsSlug, "<div align='left'><b>".$data_produk->prodsName."</b></div>", array('style' => 'text-decoration:none; color:#606975;')),
				"<div align='left'>Kode Produk : ".$data_produk->prodsKode."<br>Netto : ".$data_produk->prodsNetto." ml</div>",
				(!$this->ion_auth->logged_in()) ? 'Rp. '.number_format($items['price'], 0, ".", ".") : "",
				($this->ion_auth->logged_in()) ? $imp_retetan_bonus : '',
				$item_qty,
				'Rp. '.number_format($items['subtotal'], 0, ".", "."),
				anchor(base_url().'frontend/cart/remove_item/'.$items['rowid'], '<i class="icon-cross"></i>', array('class'=>''))
			);
			$berat_pembelian += $data_produk->prodsNetto;

			$no++;
		}


		$template = array(
		        'table_open'            => '<table class="table" style="">',
		        'thead_open'            => '<thead>',
		        'thead_close'           => '</thead>',
		        'heading_row_start'     => '<tr>',
		        'heading_row_end'       => '</tr>',
		        'heading_cell_start'    => '<th class="text-center">',
		        'heading_cell_end'      => '</th>',
		        'tbody_open'            => '<tbody>',
		        'tbody_close'           => '</tbody>',
		        'row_start'             => '<tr>',
		        'row_end'               => '</tr>',
		        'cell_start'            => '<td class="text-center">',
		        'cell_end'              => '</td>',
		        'row_alt_start'         => '<tr>',
		        'row_alt_end'           => '</tr>',
		        'cell_alt_start'        => '<td class="text-center">',
		        'cell_alt_end'          => '</td>',
		        'table_close'           => '</table>'
		);
		$this->table->set_template($template);

		//set data
		$this->data = array(
            'label'					=> 'Your Cart',
            'main_view'				=> 'cart/list_cart',
			'form_action' 			=> 'frontend/cart/pesan_sekarang',
			'table'					=> $this->table->generate(),
			'berat_pembelian'		=> $berat_pembelian,
        );

		// set url back
		$url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_frontend', $url);

		//set view
		$this->stencil->paint('cart/list_cart',$this->data);


		/*
		if ($this->session->userdata('total_order')) {
			$this->session->unset_userdata('total_order');
		}
		
		# BREACRUMB
		$this->load->library('breadcrumb');
		$this->breadcrumb->add('your cart', 'cart');
		
		$url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_frontend', $url);

		$this->load->library('table');

		$this->table->set_heading('PRODUCT', '', 'DETAILS', (!$this->ion_auth->logged_in()) ?'PRICE': '', ($this->ion_auth->logged_in()) ?'QTY - MEMBER PRICE': '', 'QTY', 'QTY TOTAL', anchor(base_url().'index.php/frontend/product/empty_cart', 'Clear Cart', array('class'=>'btn btn-sm btn-outline-danger')));

		$no = 1;
		$berat_pembelian = 0;
		foreach ($this->cart->contents() as $items) {

			$item_id = $items['id'];

			$much_item = array();
			for ($i = 0; $i <= 5 ; $i++) {
				$much_item[] = $i;
			}
			

			$dropdown = $this->models->dropdown_diskonan($items['id']);
			if (!$this->ion_auth->logged_in())
			{
				$item_qty = form_dropdown('qty[]', $much_item, $items['qty'], array('onchange'=>'updating_cart('.$item_id.')', 'id' => 'updating_cart_item'.$item_id, 'class'=>'form-control', 'required'=>'required', 'style'=>'width: 100px;'));
			}else{
				$item_qty = form_dropdown('qty[]', $dropdown, $items['qty'], array('onchange'=>'updating_cart('.$item_id.')', 'id' => 'updating_cart_item'.$item_id, 'class'=>'form-control', 'required'=>'required', 'style'=>'width: 100px;'));
			}


			//Cari diskon harga
			$this->db->select('*');
			$this->db->where('jumlah_unit !=', 0);
			$this->db->where('produk_id', $items['id']);
			$get_bonus = $this->db->get('diskon_harga');

			$ret_jumlah_unit = array();
			$ret_harga_jumlah_unit = array();
			foreach ($get_bonus->result() as $value_bonus) {
				$ret_jumlah_unit[] = $value_bonus->jumlah_unit;
				$ret_harga_jumlah_unit[] = $value_bonus->harga_jumlah_unit;
			}

			$jumlah_bonus_ada = count($ret_harga_jumlah_unit);

			$retetan_bonus = array();
			for ($i=0; $i < $jumlah_bonus_ada; $i++) { 
				$retetan_bonus[] = $ret_jumlah_unit[$i]." - Rp. ".number_format($ret_harga_jumlah_unit[$i], 0, ".", ".");
			}
			$serial_retetan_bonus = serialize($retetan_bonus);
			$imp_retetan_bonus 		= implode("<br> ",unserialize($serial_retetan_bonus));
			


			$this->db->select('*');
			$this->db->from('product');
			$this->db->where('prodsId', $items['id']);
			$data_produk = $this->db->get()->row();



			#($this->ion_auth->logged_in()) ? $price=form_hidden('price[]', $items['price']) : $price="";

			$this->table->add_row(
				#$no.
				
				
				anchor(base_url().'product/'.$data_produk->prodsSlug, '<img src="'.base_url().'assets/images/product/front_of_product/middle_'.$data_produk->prodsFrontPic.'" alt="" width="200px">', array('' => '')).
				form_hidden('product_id[]', $items['id']).
				form_hidden('rowid[]', $items['rowid']).// id produk
				form_hidden('price[]', $items['price']),// price

				anchor(base_url().'product/'.$data_produk->prodsSlug, "<div align='left'><b>".$data_produk->prodsName."</b></div>", array('style' => 'text-decoration:none; color:#606975;')),
				"<div align='left'>Kode Produk : ".$data_produk->prodsKode."<br>Netto : ".$data_produk->prodsNetto." ml</div>",
				(!$this->ion_auth->logged_in()) ? 'Rp. '.number_format($items['price'], 0, ".", ".") : "",
				($this->ion_auth->logged_in()) ? $imp_retetan_bonus : '',
				$item_qty,
				'Rp. '.number_format($items['subtotal'], 0, ".", "."),
				anchor(base_url().'frontend/cart/remove_item/'.$items['rowid'], '<i class="icon-cross"></i>', array('class'=>''))
			);
			$berat_pembelian += $data_produk->prodsNetto;

			$no++;
		}


		$template = array(
		        'table_open'            => '<table class="table" style="">',

		        'thead_open'            => '<thead>',
		        'thead_close'           => '</thead>',

		        'heading_row_start'     => '<tr>',
		        'heading_row_end'       => '</tr>',
		        'heading_cell_start'    => '<th class="text-center">',
		        'heading_cell_end'      => '</th>',

		        'tbody_open'            => '<tbody>',
		        'tbody_close'           => '</tbody>',

		        'row_start'             => '<tr>',
		        'row_end'               => '</tr>',
		        'cell_start'            => '<td class="text-center">',
		        'cell_end'              => '</td>',

		        'row_alt_start'         => '<tr>',
		        'row_alt_end'           => '</tr>',
		        'cell_alt_start'        => '<td class="text-center">',
		        'cell_alt_end'          => '</td>',

		        'table_close'           => '</table>'
		);

		$this->table->set_template($template);



		# META
		$meta = frontend_controller::get_meta(3);
		
		$this->data = array(
           	'title' 				=> "Your Cart",
            'description'			=> $meta->deskripsi_seo,
            'keyword'				=> $meta->keyword_seo,

            'label'					=> 'Your Cart',
            'main_view'				=> 'cart/list_cart',
            'stylesheet_source'		=> 'include/stylesheet/pagecontent/pagecontent_stylesheet',
			'javascript_source'		=> 'include/javascript/pagecontent/pagecontent_javascript',

			'form_action' 			=> 'frontend/cart/pesan_sekarang',

			'table'					=> $this->table->generate(),
			'berat_pembelian'		=> $berat_pembelian,
        );

		$url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_frontend', $url);

		$this->load->view('include/template/main', $this->data);
		*/
	}

	public function updating_cart()
    {
    	
        echo $id           =   $_GET['id'];
        $value_change =   $_GET['updating_cart_item'];

        /*$total = $this->cart->total_items();
		$jumlah = count($this->input->post('rowid'));
		$rowid = $this->input->post('rowid');
		$qty = $this->input->post('qty');

		for($i=0; $i < $jumlah; $i++)
		{
			$data = array(
			   'rowid' => $rowid[$i],
			   'qty'   => $qty[$i]
			);
			
			$this->cart->update($data);
		}*/

		#echo "<script>window.alert('Data berhasil diubah');</script>";
    }

	public function pesan_sekarang(){

		if (isset($_POST['submit'])) {

			$tanggal_sekarang = date("Y-m-d");

			$id_reseller = $this->session->userdata('user_id');
			$jumlah = count($this->input->post('rowid'));

			$id = $this->input->post('product_id');
			$qty = $this->input->post('qty');

			$kode_temporary = frontend_controller::buat_kode_temporary_order();

				$result = array();
		        foreach ($this->input->post('rowid') as $key=>$val) {
		        	$result[] = array(
		        		"reseller_id"					=> $id_reseller,
		        		"kode_temporary" 				=> $kode_temporary,
		        		"produk_id_temporary" 			=> $id[$key],
		        		"order_quantity_temporary" 		=> $qty[$key],
						"order_date_temporary"			=> date("Y-m-d h:i:s"),
						"order_date_experied"			=> date('Y-m-d', strtotime('+1 days', strtotime($tanggal_sekarang))),
						"status"						=> 1
		        	);
						
				}
				$data = $this->db->insert_batch('temporary_purchase_order', $result);

			$this->cart->destroy();
			redirect(base_url().'frontend/product');

		}

		if (isset($_POST['update_item'])) {

			$total = $this->cart->total_items();
			$jumlah = count($this->input->post('rowid'));
			$rowid = $this->input->post('rowid');
			$qty = $this->input->post('qty');
			$product_id = $this->input->post('product_id');
			$prices = $this->input->post('price');

			for($i=0; $i < $jumlah; $i++)
			{
				$this->db->select('harga_jumlah_unit');
				$this->db->where('produk_id', $product_id[$i]);
				$this->db->where('jumlah_unit', $qty[$i]);
				$sls_harga = $this->db->get('diskon_harga')->row();

				if($this->ion_auth->logged_in()) {
					$price=$sls_harga->harga_jumlah_unit;
				}else{
					$price=$prices[$i];
				}

				$data = array(
				   'rowid' => $rowid[$i],
				   'qty'   => $qty[$i],
				   'price'   => $price,
				);
				
				$this->cart->update($data);
			}

			redirect(base_url().'cart','refresh');

		}
	}

	public function update_item($id){

		
	}

	public function remove_item($id){
		$data = array(
		        'rowid' => $id,
		        'qty'   => 0
		);

		$this->cart->update($data);

		redirect(base_url().'cart','refresh');
	}

}

/* End of file Cart.php */
/* Location: ./application/modules/frontend/controllers/Cart.php */