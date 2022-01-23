<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shipping_billing extends Frontend_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->library('form_validation');
		$this->load->library(array('cart'));
		$this->load->helper(array('url','form'));

		//load stencil
		$this->stencil->slice(array('head','categori_menu_extend','mobile_menu_extend','top_bar_extend','navbar_extend','modal','breadcrumb','navbar','site_footer_extend','footer'));
		//load model
		$this->load->model('shipping_billing_model', 'models');

		if (empty($this->cart->contents())) {
			redirect(base_url().'product','refresh');
		}
	}

	public function index()
	{
		if ($this->session->userdata('total_order')) {
			$this->session->unset_userdata('total_order');
		}

		//cek user login
		if (!$this->ion_auth->logged_in()){
			redirect('your_account','refresh');
		}

		// Cek JUmlah Order Untuk Reseller Atau Distributor
		if ($this->ion_auth->logged_in())
		{
			if (!empty($this->cart->contents())) {
			
				foreach ($this->cart->contents() as $items_check) {
					$this->db->select('MIN(jumlah_unit) AS min_qty');
					$this->db->from('diskon_harga');
					$this->db->where('produk_id', $items_check['id']);
					$this->db->where('jumlah_unit !=', 0);
					$get_min = $this->db->get()->row();

					#echo $get_min->min_qty;

					if ($items_check['qty'] < $get_min->min_qty) {

						$this->session->set_flashdata('message_success', 'Silahkan mengisi quantity.');
						$url = $this->session->userdata('lolin_urlback_frontend');
						redirect($url);
					}
					
				}
			}
		}
		
		//set title
		$this->stencil->title('Shipping and billing');
		//set layout
		$this->stencil->layout('frontend_layout');
		//set css
		//$this->stencil->css('bootstrap/bootstrap.min');
		//set js
		//$this->stencil->js('bootstrap/bootstrap.min');
		//set breadcrumb
		$this->load->library('breadcrumb');
		$this->breadcrumb->add('shipping & billing', 'ship_bill');
		//set metadata
		$this->stencil->meta(array(
            'description' 	=> 'Lolin merupakan produk perawatan khusus anak dengan varian Shampoo, Conditioner, Facial Wash, dan Body Lotion.',
            'keywords' 		=> 'lolin, lolin kids care product, perawatan anak sejak dini, perawatan anak, produk anak, shampoo anak, conditioner anak, facial wash anak, body lotion anak',
            'author' 		=> 'Lolin Kids Care Product',
        ));

        // Buat Tabel
		$this->load->library('table');
		$no = 1;
		$berat_pembelian = 0;
		foreach ($this->cart->contents() as $items) {

			$this->db->select('*');
			$this->db->from('product');
			$this->db->where('prodsId', $items['id']);
			$data_produk = $this->db->get()->row();

			$this->table->add_row(
				anchor(base_url().'product/'.$data_produk->prodsSlug, '<img src="'.base_url().'assets/images/product/front_of_product/middle_'.$data_produk->prodsFrontPic.'" alt="" width="200px">', array('' => '')),
				anchor(base_url().'product/'.$data_produk->prodsSlug, "<div align='left'><b>".$data_produk->prodsName."</b></div>", array('style' => 'text-decoration:none; color:#606975;')),
				"Qty ".$items['qty'],
				"Rp. ".number_format($items['subtotal'], 0, ".", ".")
			);
			$berat_pembelian += ($data_produk->prodsWeight * $items['qty']);
			$no++;
		}

		$template = array(
		        'table_open'            => '<table class="table" style="font-size: 12px;">',

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

		//get meta data
		$meta = frontend_controller::get_meta(2);
		//set data
		$data = array(
            'label'					=> 'Shipping and billing',
            'form_action' 			=> 'frontend/shipping_billing/proses_shipping_billing',
			'table'					=> $this->table->generate(),
			'berat_pembelian'		=> $berat_pembelian,
        );

		//set url back
        $url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_frontend', $url);

		//set view
		$this->stencil->paint('shipping_billing/list_shipping_billing',$data);
		
		/*
		# BREACRUMB
		$this->load->library('breadcrumb');
		$this->breadcrumb->add('shipping & billing', 'ship_bill');

		// Buat Tabel
		$this->load->library('table');
		$no = 1;
		$berat_pembelian = 0;
		foreach ($this->cart->contents() as $items) {

			$this->db->select('*');
			$this->db->from('product');
			$this->db->where('prodsId', $items['id']);
			$data_produk = $this->db->get()->row();

			$this->table->add_row(
				anchor(base_url().'product/'.$data_produk->prodsSlug, '<img src="'.base_url().'assets/images/product/front_of_product/middle_'.$data_produk->prodsFrontPic.'" alt="" width="200px">', array('' => '')),
				anchor(base_url().'product/'.$data_produk->prodsSlug, "<div align='left'><b>".$data_produk->prodsName."</b></div>", array('style' => 'text-decoration:none; color:#606975;')),
				"Qty ".$items['qty'],
				"Rp. ".number_format($items['subtotal'], 0, ".", ".")
			);
			$berat_pembelian += ($data_produk->prodsWeight * $items['qty']);
			$no++;
		}

		$template = array(
		        'table_open'            => '<table class="table" style="font-size: 12px;">',

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
           	'title' 				=> "Shipping & Billing",
            'description'			=> $meta->deskripsi_seo,
            'keyword'				=> $meta->keyword_seo,

            'label'					=> 'Shipping & Billing',
            'main_view'				=> 'shipping_billing/list_shipping_billing',
            'stylesheet_source'		=> 'include/stylesheet/pagecontent/pagecontent_stylesheet',
			'javascript_source'		=> 'include/javascript/pagecontent/pagecontent_javascript',

			#'form_action' 			=> 'payment',
			'form_action' 			=> 'frontend/shipping_billing/proses_shipping_billing',

			'table'					=> $this->table->generate(),
			'berat_pembelian'		=> $berat_pembelian,
        );

		$url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_frontend', $url);

		$this->load->view('include/template/main', $this->data);
		*/
	}

	public function user_not_register(){
		//set title
		$this->stencil->title('Register Now');
		//set layout
		$this->stencil->layout('frontend_layout');
		//set css
		//$this->stencil->css('bootstrap/bootstrap.min');
		//set js
		//$this->stencil->js('bootstrap/bootstrap.min');
		//set breadcrumb
		$this->load->library('breadcrumb');
		$this->breadcrumb->add('your account', 'your_account');
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
            'label'					=> '',
            
        );

		//set view
		$this->stencil->paint('shipping_billing/user_not_register',$data);
	}

	public function city()
   	{
      $prov = $this->input->post('prov', TRUE);

      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => "http://api.rajaongkir.com/starter/city?province=$prov",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
          "key:ff115172b7a842920e60a6eb2d6fe34a"
        ),
      ));

      $response = curl_exec($curl);
      $err = curl_error($curl);

      curl_close($curl);

      if ($err) {
        echo "cURL Error #:" . $err;
      } else {
         $data = json_decode($response, TRUE);

         echo '<option value="" selected disabled>Kota / Kabupaten</option>';

         for ($i=0; $i < count($data['rajaongkir']['results']); $i++) {
            echo '<option value="'.$data['rajaongkir']['results'][$i]['city_id'].','.$data['rajaongkir']['results'][$i]['city_name'].'">'.$data['rajaongkir']['results'][$i]['city_name'].'</option>';
         }
      }
   }

	public function dapatkan_harga()
	{
		echo $this->input->post('kurir', TRUE);
	}

	public function getcost()
	{
		// 444 = surabaya

		#echo $this->input->post('kurir', TRUE);
		
		#$asal = 305; // nganjuk
		

		$asal = 444;
		$dest = $this->input->post('dest', TRUE);
		$kurir = $this->input->post('kurir', TRUE);
		$berat = $this->input->post('berat', TRUE);
		#$berat = 100;

		// cari beratnya terlebih dahulu
		/*foreach ($this->cart->contents() as $key) {
			$berat += ($key['weight'] * $key['qty']);
		}*/

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "http://api.rajaongkir.com/starter/cost",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "origin=".$asal."&destination=".$dest."&weight=".$berat."&courier=".$kurir."",
		  CURLOPT_HTTPHEADER => array(
		    "content-type: application/x-www-form-urlencoded",
		    "key:ff115172b7a842920e60a6eb2d6fe34a"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		  $data = json_decode($response, TRUE);

		  echo '<option value="" selected disabled>Available</option>';

		  for ($i=0; $i < count($data['rajaongkir']['results']); $i++) {

				for ($l=0; $l < count($data['rajaongkir']['results'][$i]['costs']); $l++) {

					echo '<option value="'.$data['rajaongkir']['results'][$i]['costs'][$l]['cost'][0]['value'].','.$data['rajaongkir']['results'][$i]['costs'][$l]['service'].'('.$data['rajaongkir']['results'][$i]['costs'][$l]['description'].')">';
					echo $data['rajaongkir']['results'][$i]['costs'][$l]['service'].'('.$data['rajaongkir']['results'][$i]['costs'][$l]['description'].')</option>';

				}

		  }
		}


	}

	public function cost()
	{
		#$contoh_cart = 5000;

		$contoh_cart =  $this->cart->total();

		$biaya = explode(',', $this->input->post('layanan', TRUE));
		#$total = $this->cart->total() + $biaya[0];

		$total = $contoh_cart + $biaya[0];

		echo $biaya[0].','.$total;
		
	}

	public function proses_shipping_billing(){

		if ($this->ion_auth->logged_in())
		{
			$id_member_order = $this->session->userdata('user_id');
			$user = $this->ion_auth->get_user();
			$group_member = $user->group;

			if (($group_member == "reseller_pribadi") or ($group_member == "reseller_organisasi")) {

				$newdata = array(
					'provinsi'  => $this->input->post('prov'),
				    'kota'  => $this->input->post('kota'),
				    'alamat'  => $this->input->post('alamat'),
				    'kode_pos'  => $this->input->post('kode_pos'),
				    'kurir'  => $this->input->post('kurir'),
				    'layanan'  => $this->input->post('layanan'),
				    'subtotal_order'  => $this->input->post('subtotal_order'),
				    'berat_order'  => $this->input->post('berat_order'),
				    'ongkir_order'  => $this->input->post('ongkir_order'),
				    'total_order'  => $this->input->post('total_order'),
				);
			}
		}else{

			$newdata = array(
			    'nama_lengkap_order'  => $this->input->post('nama_lengkap'),
			    'telepon_order'  => $this->input->post('telepon'),
			    'email_order'  => $this->input->post('email'),
			    'provinsi'  => $this->input->post('prov'),
			    'kota'  => $this->input->post('kota'),
			    'alamat'  => $this->input->post('alamat'),
			    'kode_pos'  => $this->input->post('kode_pos'),
			    'kurir'  => $this->input->post('kurir'),
			    'layanan'  => $this->input->post('layanan'),
			    'subtotal_order'  => $this->input->post('subtotal_order'),
			    'berat_order'  => $this->input->post('berat_order'),
			    'ongkir_order'  => $this->input->post('ongkir_order'),
			    'total_order'  => $this->input->post('total_order'),
			);

			
		}

		$this->session->set_userdata($newdata);


		redirect(base_url().'payment','refresh');
	}

}

/* End of file Shipping_billing.php */
/* Location: ./application/modules/frontend/controllers/Shipping_billing.php */