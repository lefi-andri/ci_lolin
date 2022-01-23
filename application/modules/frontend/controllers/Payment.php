<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends Frontend_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->library('form_validation');
		$this->load->library(array('cart'));
		$this->load->helper(array('url','form'));
		//load stencil
		$this->stencil->slice(array('head','categori_menu_extend','mobile_menu_extend','top_bar_extend','navbar_extend','modal','breadcrumb','navbar','site_footer_extend','footer'));
		//load model
		$this->load->model('payment_model', 'models');
	}

	public function index()
	{
		if (empty($this->cart->contents())) {
			$this->session->set_flashdata('message_warning', 'Silahkan melakukan pembelian.');
			redirect('product','refresh');
		}

		if ($this->session->userdata('subtotal_order') != $this->cart->total()) {
			$array_items = array(
				'nama_lengkap_order', 
				'telepon_order',
				'email_order',
				'provinsi',
				'kota',
				'alamat',
				'kode_pos',
				'kurir',
				'layanan',
				'subtotal_order',
				'berat_order',
				'ongkir_order',
				'total_order'
			);
			$this->session->unset_userdata($array_items);

			redirect(base_url('cart'),'refresh');
		}

		//set title
		$this->stencil->title('Payment');
		//set layout
		$this->stencil->layout('frontend_layout');
		//set css
		//$this->stencil->css('bootstrap/bootstrap.min');
		//set js
		//$this->stencil->js('bootstrap/bootstrap.min');
		//set breadcrumb
		$this->load->library('breadcrumb');
		$this->breadcrumb->add('payment method', 'payment');
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
			$berat_pembelian += ($data_produk->prodsNetto * $items['qty']);
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
            'label'					=> 'Payment',
            'form_action' 			=> 'frontend/payment/proses_payment',
			'table'					=> $this->table->generate(),
			'berat_pembelian'		=> $berat_pembelian,
			'id_tes'				=> frontend_controller::create_purchase_order_reseller_code(),
        );

        //set url back
        $url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_frontend', $url);

		//set view
		$this->stencil->paint('payment/list_payment',$data);

		/*
		# BREACRUMB
		$this->load->library('breadcrumb');
		$this->breadcrumb->add('payment method', 'payment');

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
			$berat_pembelian += ($data_produk->prodsNetto * $items['qty']);
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
           	'title' 				=> "Payment Method",
            'description'			=> $meta->deskripsi_seo,
            'keyword'				=> $meta->keyword_seo,

            'label'					=> 'Payment Method',
            'main_view'				=> 'payment/list_payment',
            'stylesheet_source'		=> 'include/stylesheet/pagecontent/pagecontent_stylesheet',
			'javascript_source'		=> 'include/javascript/pagecontent/pagecontent_javascript',

			'form_action' 			=> 'frontend/payment/proses_payment',

			'table'					=> $this->table->generate(),
			'berat_pembelian'		=> $berat_pembelian,
			'id_tes'				=> frontend_controller::create_purchase_order_reseller_code(),
        );

		$url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_frontend', $url);

		$this->load->view('include/template/main', $this->data);
		*/
	}

	public function proses_payment(){

		#echo $this->input->post('payment_method');

		if (isset($_POST['submit'])) {

			$this->session->set_userdata('payment_method', $this->input->post('payment_method'));

			$is_produk = array();
			$is_qty = array();
			foreach ($this->cart->contents() as $items) {
				$is_produk[] = $items['id'];
				$is_qty[] = $items['qty'];
			}

			// Data Order Start
			$kota = $this->session->userdata('kota');
	    	$provinsi = $this->session->userdata('provinsi');
	    	$get_kota = explode(',', $kota); 
	    	$get_provinsi = explode(',', $provinsi);
	    	$ambil_alamat = ($this->session->userdata('alamat')) ? $this->session->userdata('alamat') : '';
	    	$ambil_kota = ($this->session->userdata('kota')) ? $get_kota[1] : '';
	    	$ambil_provinsi = ($this->session->userdata('provinsi')) ? $get_provinsi[1] : '';
	    	$ambil_kode_pos = ($this->session->userdata('kode_pos')) ? $this->session->userdata('kode_pos') : '';
	    	$ambil_kurir = strtoupper($this->session->userdata('kurir'));
	    	$get_layanan = explode(',', $this->session->userdata('layanan'));
	    	$ambil_layanan = $get_layanan[1];
	    	$ambil_ongkos_kirim = ($this->session->userdata('ongkir_order')) ? $this->session->userdata('ongkir_order') : '';
	    	$ambil_total_order = ($this->session->userdata('total_order')) ? $this->session->userdata('total_order') : '';
	    	// Data Order End

			date_default_timezone_get('Asia/Jakarta');
			$tanggal_sekarang = date('Y-m-d');
			$jam_sekarang = date('h:i:s');
			$penambahan_tanggal = date('Y-m-d', strtotime('+1 days', strtotime($tanggal_sekarang))).' '.$jam_sekarang;

			$waktu_order = date("Y-m-d h:i:s");

			$order_code_reseller = frontend_controller::create_purchase_order_reseller_code();
			$order_code_non_reseller = frontend_controller::create_purchase_order_non_reseller_code();
			// buat session id order non rseller
			$this->session->set_userdata('order_code_non_reseller', $order_code_non_reseller);
			$this->session->set_userdata('order_code_reseller', $order_code_reseller);

			if ($this->ion_auth->logged_in()){
				$id_member_order = $this->session->userdata('user_id');
				$user = $this->ion_auth->get_user();
				$group_member = $user->group;

				if (($group_member == "reseller_pribadi") or ($group_member == "reseller_organisasi")) {

					$object = array(
						'produk_id' => serialize($is_produk),
						'quantity' => serialize($is_qty),					
						'reseller_id' => $id_member_order,
					    'provinsi'  => $this->session->userdata('provinsi'),
					    'kota'  => $this->session->userdata('kota'),
					    'alamat_order'  => $this->session->userdata('alamat'),
					    'kode_pos'  => $this->session->userdata('kode_pos'),
					    'kurir'  => $this->session->userdata('kurir'),
					    'layanan'  => $this->session->userdata('layanan'),
					    'subtotal_order'  => $this->session->userdata('subtotal_order'),
					    'berat_order'  => $this->session->userdata('berat_order'),
					    'ongkos_kirim'  => $this->session->userdata('ongkir_order'),
					    'total_order'  => $this->session->userdata('total_order'),
					    'payment_method' => $this->session->userdata('payment_method'),
					    'order_date' => $waktu_order,
					    'order_date_experied' => $penambahan_tanggal,
					    'status_konfirmasi' => 0,
					    'konfirmasi_email' => 0,
					    'is_temporary_order' => 1,
					    'order_code_reseller' => $order_code_reseller,
					);

					$insert = $this->db->insert('purchase_order_reseller', $object);
				
				}

			}else{
				$object = array(
					'produk_id' => serialize($is_produk),
					'quantity' => serialize($is_qty),
					'nama_lengkap_order'  => $this->session->userdata('nama_lengkap_order'),
				    'telepon_order'  => $this->session->userdata('telepon_order'),
				    'email_order'  => $this->session->userdata('email_order'),
				    'provinsi'  => $this->session->userdata('provinsi'),
				    'kota'  => $this->session->userdata('kota'),
				    'alamat_order'  => $this->session->userdata('alamat'),
				    'kode_pos'  => $this->session->userdata('kode_pos'),
				    'kurir'  => $this->session->userdata('kurir'),
				    'layanan'  => $this->session->userdata('layanan'),
				    'subtotal_order'  => $this->session->userdata('subtotal_order'),
				    'berat_order'  => $this->session->userdata('berat_order'),
				    'ongkos_kirim'  => $this->session->userdata('ongkir_order'),
				    'total_order'  => $this->session->userdata('total_order'),
				    'payment_method' => $this->session->userdata('payment_method'),
				    'order_date' => $waktu_order,
				    'order_date_experied' => $penambahan_tanggal,
				    'status_konfirmasi' => 0,
				    'konfirmasi_email' => 0,
				    'is_temporary_order' => 1,
				    'order_code_non_reseller' => $order_code_non_reseller,
				);

				$insert = $this->db->insert('purchase_order_non_reseller', $object);
			}

			if ($insert) {

				//simpan ke log
				$user_id = $this->session->userdata('user_id');
				$insert_id = $this->db->insert_id();
				$object = array(
					'tipe_transaksi_id' => 1,
					'reseller_id' => $user_id,
					'related_id' => $order_code_reseller,
					'tanggal_log' => date("Y-m-d h:i:s"),
				);
				$this->db->insert('log_transaksi', $object);

				if ($this->ion_auth->logged_in()){

					#$id_member_order = $this->session->userdata('user_id');
					$user = $this->ion_auth->get_user();
					$group_member = $user->group;
					$email_member = $user->email;
					$alamat_reseller_member = $user->alamat_reseller;
					$nama_lengkap_member = $user->nama_lengkap;
					$nomor_telepon_reseller_member = $user->nomor_telepon_reseller;
					$nama_organisasi_member = $user->nama_organisasi;
					$alamat_organisasi_member = $user->alamat_organisasi;
					$nomor_telepon_organisasi_member = $user->nomor_telepon_organisasi;

					if (($group_member == "reseller_pribadi") or ($group_member == "reseller_organisasi")) {

						// INI JIKA MEMBER
						$pengaturan_email = frontend_controller::get_pengaturan_email();
						if ($pengaturan_email == 1) {

							$email_to = $email_member;
							$email_template = "template_email_order"; // Samakan dengan nama method template
							$subjek = "Order Member Lolin Kids Care Product";

							$email_konten = "<h4>Permintaan order telah terkirim,</h4>";
							$email_konten .= "Dear ".$nama_lengkap_member.",<br>";
							$email_konten .= 'Anda baru saja melakukan order produk Lolin Kids Care Product dengan detail sebagai berikut :';
							$email_konten .= "<br>";
							
							$email_konten .= "<table width='100%' border='1'><tr><th>Nama Produk</th><th>Qty</th><th>Subtotal</th></tr>";
							$no = 1;
							$berat_pembelian = 0;
							foreach ($this->cart->contents() as $items) {
								$this->db->select('*');
								$this->db->from('product');
								$this->db->where('prodsId', $items['id']);
								$data_produk = $this->db->get()->row();

								$email_konten .= "<tr><td><i>".$data_produk->prodsName."</i></td><td>".$items['qty']."</td><td>Rp. ".$items['subtotal']."</td></tr>";

								$berat_pembelian += ($data_produk->prodsNetto * $items['qty']);
								$no++;
							}
							$email_konten .= "
							  <tr>
							    <td colspan='2'> <b>Alamat pengiriman pesanan :</b> </td>
							    <td>".$ambil_alamat.", ".$ambil_kota.", ".$ambil_provinsi." - ".$ambil_kode_pos."</td>
							  </tr>
							  <tr>
							    <td colspan='2'> <b>Paket Pengiriman :</b> </td>
							    <td>".$ambil_kurir." - ".$ambil_layanan."</td>
							  </tr>
							  <tr>
							    <td colspan='2'> <b>Berat Total (gram) :</b> </td>
							    <td>".$berat_pembelian."</td>
							  </tr>
							  <tr>
							    <td colspan='2'> <b>Ongkos kirim :</b> </td>
							    <td>Rp. ".$ambil_ongkos_kirim."</td>
							  </tr>
							  <tr>
							    <td colspan='2'> <b>Total Order :</b> </td>
							    <td>Rp. ".$ambil_total_order."</td>
							  </tr>
							  <tr>
							    <td colspan='2'> <b>Metode Pembayaran :</b> </td>
							    <td>".$this->session->userdata('payment_method')."</td>
							  </tr>
							  <tr>
							    <td colspan='2'> <b>Waktu Order :</b> </td>
							    <td>".$waktu_order."</td>
							  </tr>
							</table>
							";

							$email_konten .= "<br>";

							if ($this->session->userdata('payment_method') == "transfer_bca") {
								$email_konten .= "
								<b>Langkah selanjutnya,</b><br>
								Lakukan pembayaran melalui transfer ke rekening BCA
								<table width='100%' border='1'>
								  <tr>
								    <td><strong>Atas Nama</strong></td>
								    <td>:</td>
								    <td>PT Lolin Berjaya Mulia</td>
								  </tr>
								  <tr>
								    <td><strong>Nomor Rekening BCA</strong></td>
								    <td>:</td>
								    <td>2135077788</td>
								  </tr>
								</table>
								";
							}

							if ($this->session->userdata('payment_method') == "transfer_doku") {
								$email_konten .= "
								<b>Langkah selanjutnya,</b><br>
								Lakukan pembayaran melalui transfer ke rekening DOKU
								<table width='100%' border='1'>
								  <tr>
								    <td><strong>Atas Nama</strong></td>
								    <td>:</td>
								    <td>PT Lolin Berjaya Mulia</td>
								  </tr>
								  <tr>
								    <td><strong>Nomor Rekening Doku</strong></td>
								    <td>:</td>
								    <td></td>
								  </tr>
								</table>
								";
							}

							if ($this->session->userdata('payment_method') == "transfer_finpay") {
								$email_konten .= "
								<b>Langkah selanjutnya,</b><br>
								Lakukan pembayaran melalui transfer ke rekening Finpay
								<table width='100%' border='1'>
								  <tr>
								    <td><strong>Atas Nama</strong></td>
								    <td>:</td>
								    <td>PT Lolin Berjaya Mulia</td>
								  </tr>
								  <tr>
								    <td><strong>Nomor Rekening Finpay</strong></td>
								    <td>:</td>
								    <td></td>
								  </tr>
								</table>
								";
							}

							
							$email_konten .= "<br>";
							$email_konten .= "Kami akan segera mengkonfirmasi order anda. Terima Kasih.<br>";
							$email_konten .= "Mengalami kesulitan ? Hubungi kami melalui, Email info@lolin.co.id  WhatsApp 085604848140.";
							// Kirim email ke peng order
							$kirim = frontend_controller::buat_email($email_to, $subjek, $email_konten, $email_template);

							if ($kirim) {
								#INFO
								$email_to = email_fordward(); //email_fordward lihat di config lolin
								$email_template = "template_email_order_info"; // Samakan dengan nama method template
								$subjek = "Reseller Order";
								$email_konten = "Baru-baru ini pengunjung website Lolin Kids Care yang melakukan order dengan detail :";
								$email_konten .= "<br><br>";

								if ($group_member == "reseller_pribadi") {
									$email_konten .= "
										<table width='100%' border='1'>
										  <tr>
										    <td><strong>Nama</strong></td>
										    <td>:</td>
										    <td>".$nama_lengkap_member."</td>
										  </tr>
										  <tr>
										    <td><strong>Handphone</strong></td>
										    <td>:</td>
										    <td>".$nomor_telepon_reseller_member."</td>
										  </tr>
										  <tr>
										    <td><strong>Email</strong></td>
										    <td>:</td>
										    <td>".$email_member."</td>
										  </tr>
										  <tr>
										    <td><strong>Alamat</strong></td>
										    <td>:</td>
										    <td>".$alamat_reseller_member."</td>
										  </tr>
										  <tr>
										    <td><strong>Jenis Member</strong></td>
										    <td>:</td>
										    <td>".$group_member."</td>
										  </tr>
										</table>
									";
								}

								if ($group_member == "reseller_organisasi") {
									$email_konten .= "
										<table width='100%' border='1'>
										  <tr>
										    <td><strong>Nama Distributor</strong></td>
										    <td>:</td>
										    <td>".$nama_organisasi_member."</td>
										  </tr>
										  <tr>
										    <td><strong>Nomor Telepon Distributor</strong></td>
										    <td>:</td>
										    <td>".$nomor_telepon_organisasi_member."</td>
										  </tr>
										  <tr>
										    <td><strong>Email</strong></td>
										    <td>:</td>
										    <td>".$email_member."</td>
										  </tr>
										  <tr>
										    <td><strong>Alamat </strong></td>
										    <td>:</td>
										    <td>".$alamat_organisasi_member."</td>
										  </tr>
										  <tr>
										    <td><strong>Nama Perwakilan</strong></td>
										    <td>:</td>
										    <td>".$nama_lengkap_member."</td>
										  </tr>
										  <tr>
										    <td><strong>Jenis Member</strong></td>
										    <td>:</td>
										    <td>".$group_member."</td>
										  </tr>
										</table>
									";
								}

								

								$email_konten .= "<br>";
								$email_konten .= "Produk order : <br><br><table width='100%' border='1'><tr><th>Nama Produk</th><th>Qty</th><th>Subtotal</th></tr>";
								$no = 1;
								$berat_pembelian = 0;
								foreach ($this->cart->contents() as $items) {
									$this->db->select('*');
									$this->db->from('product');
									$this->db->where('prodsId', $items['id']);
									$data_produk = $this->db->get()->row();

									$email_konten .= "<tr><td><i>".$data_produk->prodsName."</i></td><td>".$items['qty']."</td><td>Rp. ".$items['subtotal']."</td></tr>";

									$berat_pembelian += ($data_produk->prodsNetto * $items['qty']);
									$no++;
								}

								$email_konten .= "
								  <tr>
								    <td colspan='2'> <b>Alamat pengiriman pesanan :</b> </td>
								    <td>".$ambil_alamat.", ".$ambil_kota.", ".$ambil_provinsi." - ".$ambil_kode_pos."</td>
								  </tr>
								  <tr>
								    <td colspan='2'> <b>Paket Pengiriman :</b> </td>
								    <td>".$ambil_kurir." - ".$ambil_layanan."</td>
								  </tr>
								  <tr>
								    <td colspan='2'> <b>Berat Total (gram) :</b> </td>
								    <td>".$berat_pembelian."</td>
								  </tr>
								  <tr>
								    <td colspan='2'> <b>Ongkos kirim :</b> </td>
								    <td>Rp. ".$ambil_ongkos_kirim."</td>
								  </tr>
								  <tr>
								    <td colspan='2'> <b>Total Order :</b> </td>
								    <td>Rp. ".$ambil_total_order."</td>
								  </tr>
								  <tr>
								    <td colspan='2'> <b>Metode Pembayaran :</b> </td>
								    <td>".$this->session->userdata('payment_method')."</td>
								  </tr>
								  <tr>
								    <td colspan='2'> <b>Waktu Order :</b> </td>
								    <td>".$waktu_order."</td>
								  </tr>
								</table>
								";
								
								$email_konten .= "<br>";
								$email_konten .= "<br><br>Dimohon untuk ditinjau melalui panel admin <a href='http://www.lolin.co.id/login'>Login</a>.";
								// Kirim email ke admin
								frontend_controller::buat_email($email_to, $subjek, $email_konten, $email_template);
							}

							$array_items = array(
								'provinsi',
								'kota',
								'alamat',
								'kode_pos',
								'kurir',
								'layanan',
								'subtotal_order',
								'berat_order',
								'ongkir_order',
								'total_order',
								'payment_method',
							);
							$this->session->unset_userdata($array_items);



						}else{

							$array_items = array(
								'provinsi',
								'kota',
								'alamat',
								'kode_pos',
								'kurir',
								'layanan',
								'subtotal_order',
								'berat_order',
								'ongkir_order',
								'total_order',
								'payment_method',
							);
							$this->session->unset_userdata($array_items);
						}
						

					}

				}else{
					// Cek pengaturan email
					$pengaturan_email = frontend_controller::get_pengaturan_email();
					if ($pengaturan_email == 1) {
						
						$email_to = $this->session->userdata('email_order');
						$email_template = "template_email_order"; // Samakan dengan nama method template
						$subjek = "Order Lolin Kids Care Product";

						$email_konten = "<h4>Permintaan order telah terkirim,</h4>";
						$email_konten .= "Dear ".$this->session->userdata('nama_lengkap_order').",<br>";
						$email_konten .= 'Anda baru saja melakukan order produk Lolin Kids Care Product dengan detail sebagai berikut :';
						$email_konten .= "<br>";
						
						$email_konten .= "<table width='100%' border='1'><tr><th>Nama Produk</th><th>Qty</th><th>Subtotal</th></tr>";
						$no = 1;
						$berat_pembelian = 0;
						foreach ($this->cart->contents() as $items) {
							$this->db->select('*');
							$this->db->from('product');
							$this->db->where('prodsId', $items['id']);
							$data_produk = $this->db->get()->row();

							$email_konten .= "<tr><td><i>".$data_produk->prodsName."</i></td><td>".$items['qty']."</td><td>Rp. ".$items['subtotal']."</td></tr>";

							$berat_pembelian += ($data_produk->prodsNetto * $items['qty']);
							$no++;
						}

						$email_konten .= "
						  <tr>
						    <td colspan='2'> <b>Alamat pengiriman pesanan :</b> </td>
						    <td>".$ambil_alamat.", ".$ambil_kota.", ".$ambil_provinsi." - ".$ambil_kode_pos."</td>
						  </tr>
						  <tr>
						    <td colspan='2'> <b>Paket Pengiriman :</b> </td>
						    <td>".$ambil_kurir." - ".$ambil_layanan."</td>
						  </tr>
						  <tr>
						    <td colspan='2'> <b>Berat Total (gram) :</b> </td>
						    <td>".$berat_pembelian."</td>
						  </tr>
						  <tr>
						    <td colspan='2'> <b>Ongkos kirim :</b> </td>
						    <td>Rp. ".$ambil_ongkos_kirim."</td>
						  </tr>
						  <tr>
						    <td colspan='2'> <b>Total Order :</b> </td>
						    <td>Rp. ".$ambil_total_order."</td>
						  </tr>
						  <tr>
						    <td colspan='2'> <b>Metode Pembayaran :</b> </td>
						    <td>".$this->session->userdata('payment_method')."</td>
						  </tr>
						  <tr>
						    <td colspan='2'> <b>Waktu Order :</b> </td>
						    <td>".$waktu_order."</td>
						  </tr>
						</table>
						";

						$email_konten .= "<br>";

						if ($this->session->userdata('payment_method') == "transfer_bca") {
							$email_konten .= "
							<b>Langkah selanjutnya,</b><br>
							Lakukan pembayaran melalui transfer ke rekening BCA
							<table width='100%' border='1'>
							  <tr>
							    <td><strong>Atas Nama</strong></td>
							    <td>:</td>
							    <td>PT Lolin Berjaya Mulia</td>
							  </tr>
							  <tr>
							    <td><strong>Nomor Rekening BCA</strong></td>
							    <td>:</td>
							    <td>2135077788</td>
							  </tr>
							</table>
							";
						}

						if ($this->session->userdata('payment_method') == "transfer_doku") {
							$email_konten .= "
							<b>Langkah selanjutnya,</b><br>
							Lakukan pembayaran melalui transfer ke rekening DOKU
							<table width='100%' border='1'>
							  <tr>
							    <td><strong>Atas Nama</strong></td>
							    <td>:</td>
							    <td>PT Lolin Berjaya Mulia</td>
							  </tr>
							  <tr>
							    <td><strong>Nomor Rekening Doku</strong></td>
							    <td>:</td>
							    <td></td>
							  </tr>
							</table>
							";
						}

						if ($this->session->userdata('payment_method') == "transfer_finpay") {
							$email_konten .= "
							<b>Langkah selanjutnya,</b><br>
							Lakukan pembayaran melalui transfer ke rekening Finpay
							<table width='100%' border='1'>
							  <tr>
							    <td><strong>Atas Nama</strong></td>
							    <td>:</td>
							    <td>PT Lolin Berjaya Mulia</td>
							  </tr>
							  <tr>
							    <td><strong>Nomor Rekening Finpay</strong></td>
							    <td>:</td>
							    <td></td>
							  </tr>
							</table>
							";
						}

						$email_konten .= "<br>";

						$email_konten .= "Kami akan segera mengkonfirmasi order anda. Terima Kasih.<br>";
						$email_konten .= "Mengalami kesulitan ? Hubungi kami melalui, Email info@lolin.co.id  WhatsApp 085604848140.";
						#$email_konten .= "<br>";
						#$email_konten .= "<i>Jika anda tidak melakukan ini, abaikan pesan ini.</i>";

						// Kirim email ke peng order
						$kirim = frontend_controller::buat_email($email_to, $subjek, $email_konten, $email_template);

						if ($kirim) {
							#INFO
							$email_to = email_fordward(); //email_fordward lihat di config lolin
							$email_template = "template_email_order_info"; // Samakan dengan nama method template
							$subjek = "Reseller Order";
							$email_konten = "Baru-baru ini pengunjung website Lolin Kids Care yang melakukan order dengan detail :";
							$email_konten .= "<br><br>";
							$email_konten .= "
								<table width='100%' border='1'>
								  <tr>
								    <td><strong>Nama</strong></td>
								    <td>:</td>
								    <td>".$this->session->userdata('nama_lengkap_order')."</td>
								  </tr>
								  <tr>
								    <td><strong>Handphone</strong></td>
								    <td>:</td>
								    <td>".$this->session->userdata('telepon_order')."</td>
								  </tr>
								  <tr>
								    <td><strong>Email</strong></td>
								    <td>:</td>
								    <td>".$this->session->userdata('email_order')."</td>
								  </tr>
								  <tr>
								    <td><strong>Alamat</strong></td>
								    <td>:</td>
								    <td>".$ambil_alamat.", ".$ambil_kota.", ".$ambil_provinsi." - ".$ambil_kode_pos."</td>
								  </tr>
								</table>
							";

							$email_konten .= "<br>";
							$email_konten .= "Produk order : <br><br><table width='100%' border='1'><tr><th>Nama Produk</th><th>Qty</th><th>Subtotal</th></tr>";
							$no = 1;
							$berat_pembelian = 0;
							foreach ($this->cart->contents() as $items) {
								$this->db->select('*');
								$this->db->from('product');
								$this->db->where('prodsId', $items['id']);
								$data_produk = $this->db->get()->row();

								$email_konten .= "<tr><td><i>".$data_produk->prodsName."</i></td><td>".$items['qty']."</td><td>Rp. ".$items['subtotal']."</td></tr>";

								$berat_pembelian += ($data_produk->prodsNetto * $items['qty']);
								$no++;
							}

							$email_konten .= "
							  <tr>
							    <td colspan='2'> <b>Paket Pengiriman :</b> </td>
							    <td>".$ambil_kurir." - ".$ambil_layanan."</td>
							  </tr>
							  <tr>
							    <td colspan='2'> <b>Berat Total (gram) :</b> </td>
							    <td>".$berat_pembelian."</td>
							  </tr>
							  <tr>
							    <td colspan='2'> <b>Ongkos kirim :</b> </td>
							    <td>Rp. ".$ambil_ongkos_kirim."</td>
							  </tr>
							  <tr>
							    <td colspan='2'> <b>Total Order :</b> </td>
							    <td>Rp. ".$ambil_total_order."</td>
							  </tr>
							  <tr>
							    <td colspan='2'> <b>Metode Pembayaran :</b> </td>
							    <td>".$this->session->userdata('payment_method')."</td>
							  </tr>
							  <tr>
							    <td colspan='2'> <b>Waktu Order :</b> </td>
							    <td>".$waktu_order."</td>
							  </tr>
							</table>
							";
							
							$email_konten .= "<br>";
							$email_konten .= "<br><br>Dimohon untuk ditinjau melalui panel admin <a href='http://www.lolin.co.id/login'>Login</a>.";
							// Kirim email ke admin
							frontend_controller::buat_email($email_to, $subjek, $email_konten, $email_template);
						}

						$array_items = array(
							'nama_lengkap_order', 
							'telepon_order',
							'email_order',
							'provinsi',
							'kota',
							'alamat',
							'kode_pos',
							'kurir',
							'layanan',
							'subtotal_order',
							'berat_order',
							'ongkir_order',
							'total_order',
							'payment_method',
						);
						$this->session->unset_userdata($array_items);

					}else{

						$array_items = array(
							'nama_lengkap_order', 
							'telepon_order',
							'email_order',
							'provinsi',
							'kota',
							'alamat',
							'kode_pos',
							'kurir',
							'layanan',
							'subtotal_order',
							'berat_order',
							'ongkir_order',
							'total_order',
							'payment_method',
						);
						$this->session->unset_userdata($array_items);
					}
				}
										


				$this->cart->destroy();

				$this->session->set_flashdata('message_success', 'Order sukses.');
				redirect('checkout_complete','refresh');
			}

		}
	}

	public function checkout_complete(){

		if (empty($this->session->userdata('order_code_non_reseller'))) {
			$this->session->set_flashdata('message_info', 'Silahkan melakukan order.');
			redirect('product','refresh');
		}

		if (empty($this->session->userdata('order_code_reseller'))) {
			$this->session->set_flashdata('message_info', 'Silahkan melakukan order.');
			redirect('product','refresh');
		}

		//set title
		$this->stencil->title('Checkout Complete');
		//set layout
		$this->stencil->layout('frontend_layout');
		//set css
		//$this->stencil->css('bootstrap/bootstrap.min');
		//set js
		//$this->stencil->js('bootstrap/bootstrap.min');
		//set breadcrumb
		$this->load->library('breadcrumb');
		$this->breadcrumb->add('checkout complete', 'checkout_complete');
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
            'label'					=> 'Checkout Complete',
            
        );

		//set url back
        $url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_frontend', $url);

		//set view
		$this->stencil->paint('payment/list_checkout_complete',$data);

		/*
		# BREACRUMB
		$this->load->library('breadcrumb');
		$this->breadcrumb->add('checkout complete', 'checkout_complete');

		# META
		$meta = frontend_controller::get_meta(3);
		
		$this->data = array(
           	'title' 				=> "Checkout Complete",
            'description'			=> $meta->deskripsi_seo,
            'keyword'				=> $meta->keyword_seo,

            'label'					=> 'Checkout Complete',
            'main_view'				=> 'payment/list_checkout_complete',
            'stylesheet_source'		=> 'include/stylesheet/pagecontent/pagecontent_stylesheet',
			'javascript_source'		=> 'include/javascript/pagecontent/pagecontent_javascript',
        );

		$url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_frontend', $url);

		$this->load->view('include/template/main', $this->data);
		*/
	}

}

/* End of file Payment.php */
/* Location: ./application/modules/frontend/controllers/Payment.php */