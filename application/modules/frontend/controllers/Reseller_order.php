<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reseller_order extends Reseller_Controller {

	public function __construct()
	{
		parent::__construct();

		if (!$this->ion_auth->logged_in())
        {
        	$this->session->set_flashdata('message_warning', 'Anda harus login sebagai reseller atau distributor.');
            redirect('reseller','refresh');
        }
		
		$this->load->model('reseller_order_model', 'models');
	}

	public function index()
	{
		if ($this->session->userdata('order_produk_dipilih')) {
			redirect(base_url().'frontend/reseller_order/checkout');
		}
		
		$url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_frontend', $url);

		$this->load->library('breadcrumb');
		$this->breadcrumb->add('reseller', 'reseller');
		$this->breadcrumb->add('order', 'reseller/order');

		$id_reseller = $this->session->userdata('user_id');

		$this->load->library('table');

		$this->table->set_heading('No', 'Nama Produk', 'Detail Harga','Kode Produk', 'Qty','');

		$data_produk = $this->models->ambil_data_produk();

		

		$no = 1;
		foreach ($data_produk->result() as $key => $value) {

			$dropdown = $this->models->dropdown_diskonan($value->prodsId);

			$item = array(
				'name'          => 'product[]',
				'id'            => 'ex-check-'.$no,
				'value'         => $value->prodsId,
				'checked'       => FALSE,
				'class'         => 'custom-control-input',
				'onclick'		=> "enable_text_form".$no."(this.checked)",
			);

			$this->table->add_row(
				$no, 
				$value->prodsName,
				anchor("#order_of_product", "<b>detail</b>", array('class'=>'','data-toggle'=>'tooltip', 'title'=>$value->prodsName, 'data-target'=>'#order_of_product', 'data-toggle'=>'modal', 'data-id'=>$value->prodsId, 'style'=>'text-decoration:none')),
				$value->prodsKode,
				form_dropdown('jumlah_order_reseller[]', $dropdown, '1', array('class'=>'form-control', 'disabled'=>'disabled', 'id'=>'other_text'.$no.'', 'required'=>'required')),
				'<div class="custom-control custom-checkbox">'.form_checkbox($item).'<label class="custom-control-label" for="ex-check-'.$no.'"> <b>Pilih</b></label></div>'
			);
			$no++;
		}

		reseller_controller::buat_tabel();

		$total_poin = reseller_controller::hitung_total_poin($id_reseller);
		$total_tukar_poin = reseller_controller::hitung_tukar_poin($id_reseller);

		$meta = reseller_controller::get_meta(2);
		
		$data = array(
            'title' 				=> "Order - Lolin Reseller or Distributor",
            'description'			=> $meta->deskripsi_seo,
            'keyword'				=> $meta->keyword_seo,

            'label'					=> 'Order',            
            'main_view'				=> 'reseller_order/list_reseller_order',
            'stylesheet_source'		=> 'include/stylesheet/pagecontent/pagecontent_stylesheet',
			'javascript_source'		=> 'include/javascript/pagecontent/pagecontent_javascript',

			'data_reseller'			=> $this->ion_auth->get_user(),
			'total_poin'			=> $total_poin,
			'total_tukar_poin'		=> $total_tukar_poin,
			'poin_saat_ini'			=> reseller_controller::cek_poin_saat_ini($total_poin, $total_tukar_poin),
			'banyak_order_reseller'	=> reseller_controller::banyak_order_reseller($id_reseller),

			'table'					=> $this->table->generate(),
			'foto'					=> $this->db->select('foto_profile')->where(array('user_id' => $id_reseller))->get('meta')->row()->foto_profile,
        );
				
		$this->load->view('include/template/main', $data);
	}

	public function proses_order()
	{
		
		if (!$this->input->post('product[]')) {
			$this->session->set_flashdata('message_warning', 'Silahkan pilih produk dan quantity pembelian.');
			redirect('reseller/order');
		}
		if (!$this->input->post('jumlah_order_reseller[]')) {
			$this->session->set_flashdata('message_warning', 'Silahkan pilih quantity pembelian.');
			redirect('reseller/order');
		}

		$id_reseller = $this->session->userdata('user_id');

		$this->session->set_userdata('order_produk_dipilih', $this->input->post('product[]'));
		$this->session->set_userdata('jumlah_order_reseller', $this->input->post('jumlah_order_reseller[]'));

		redirect(base_url().'frontend/reseller_order/checkout','refresh');

	}

	public function data_belanja(){

		$this->load->library('breadcrumb');
		$this->breadcrumb->add('reseller', 'reseller');
		$this->breadcrumb->add('order', 'reseller/order');
		$this->breadcrumb->add('checkout', 'frontend/reseller_order/checkout');

		$produk = $this->session->userdata('order_produk_dipilih');
		$diskon_id = $this->session->userdata('jumlah_order_reseller');

		$this->load->library('table');

		$this->table->set_heading('Name', 'Color', 'Size');

		$this->table->add_row('Fred', 'Blue', 'Small');
		$this->table->add_row('Mary', 'Red', 'Large');
		$this->table->add_row('John', 'Green', 'Medium');
		

		reseller_controller::buat_tabel();



		$id_reseller = $this->session->userdata('user_id');

		$total_poin = reseller_controller::hitung_total_poin($id_reseller);
		$total_tukar_poin = reseller_controller::hitung_tukar_poin($id_reseller);

		$meta = reseller_controller::get_meta(2);
		
		$data = array(
            'title' 				=> 'Checkout',
            'description'			=> $meta->deskripsi_seo,
            'keyword'				=> $meta->keyword_seo,

            'label'					=> 'Checkout',            
            'main_view'				=> 'reseller_order/list_data_belanja',
            'stylesheet_source'		=> 'include/stylesheet/pagecontent/pagecontent_stylesheet',
			'javascript_source'		=> 'include/javascript/pagecontent/pagecontent_javascript',

			'data_reseller'			=> $this->ion_auth->get_user(),
			'total_poin'			=> $total_poin,
			'total_tukar_poin'		=> $total_tukar_poin,
			'poin_saat_ini'			=> reseller_controller::cek_poin_saat_ini($total_poin, $total_tukar_poin),
			'banyak_order_reseller'	=> reseller_controller::banyak_order_reseller($id_reseller),

			'table'					=> $this->table->generate(),
			'foto'					=> $this->db->select('foto_profile')->where(array('user_id' => $id_reseller))->get('meta')->row()->foto_profile,

			'dropdown_provinsi' 	=> $this->models->dropdown_provinsi(),
        );
				
		$this->load->view('include/template/main', $data);
	}



	public function city()
	{

      $prov = $this->input->post('prov', TRUE);

      #print_r($prov);

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

	public function getcost()
	{
		$asal = 305;
		$dest = $this->input->post('dest', TRUE);
		$kurir = $this->input->post('kurir', TRUE);
		$berat = 0;

		foreach ($this->cart->contents() as $key) {
			$berat += ($key['weight'] * $key['qty']);
		}

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "http://api.rajaongkir.com/starter/cost",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "origin=$asal&destination=$dest&weight=$berat&courier=$kurir",
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

		  echo '<option value="" selected disabled>Layanan yang tersedia</option>';

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
		$biaya = explode(',', $this->input->post('layanan', TRUE));
		$total = $this->cart->total() + $biaya[0];

		echo $biaya[0].','.$total;
	}






	public function checkout()
	{
		if (!$this->session->userdata('order_produk_dipilih')) {
			$this->session->set_flashdata('message_warning', 'Silahkan melakukan order terlebih dahulu.');
			redirect('reseller/order');
		}

		$this->load->library('breadcrumb');
		$this->breadcrumb->add('reseller', 'reseller');
		$this->breadcrumb->add('order', 'reseller/order');
		$this->breadcrumb->add('checkout', 'frontend/reseller_order/checkout');

		$produk = $this->session->userdata('order_produk_dipilih');
		$diskon_id = $this->session->userdata('jumlah_order_reseller');

		$this->load->library('table');

		$this->table->set_heading('#No', '#Nama Produk', '#Jumlah','#Harga Normal per Satuan', '#Harga Member', '#Berat (Kg)','#Sub Total Harga');

		$jumlah_data = count($produk);
		$no = 1;
		$total_harga_semua_unit = 0;
		$total_berat_semua_unit = 0;
		for ($i=0; $i < $jumlah_data; $i++) {

			# PRODUK
			$get_detail_produk = $this->db->get_where('product', array('prodsId'=>$produk[$i]))->row();

			# HARGA MEMBER
			$this->db->select('*');
			$this->db->from('product');
			$this->db->join('diskon_harga', 'diskon_harga.produk_id = product.prodsId');
			$this->db->where('product.prodsId', $produk[$i]);
			$this->db->where('diskon_harga.diskon_id', $diskon_id[$i]);
			$get_harga_member = $this->db->get()->row();

			$harga_kali_unit = $get_harga_member->jumlah_unit * $get_harga_member->harga_jumlah_unit;

			$this->table->add_row(
				$no, 
				$get_detail_produk->prodsName,
				$get_harga_member->jumlah_unit,
				'Rp. '.number_format($get_detail_produk->prodsPrice, 0, ".", "."),
				'Rp. '.number_format($get_harga_member->harga_jumlah_unit, 0, ".", "."),
				$get_harga_member->berat,
				'Rp. '.number_format($harga_kali_unit, 0, ".", ".")
			);
			$total_harga_semua_unit += $harga_kali_unit;
			$total_berat_semua_unit += $get_harga_member->berat;
			$no++;
		}
		

		reseller_controller::buat_tabel();



		$id_reseller = $this->session->userdata('user_id');

		$total_poin = reseller_controller::hitung_total_poin($id_reseller);
		$total_tukar_poin = reseller_controller::hitung_tukar_poin($id_reseller);

		$meta = reseller_controller::get_meta(2);
		
		$data = array(
            'title' 				=> 'Checkout',
            'description'			=> $meta->deskripsi_seo,
            'keyword'				=> $meta->keyword_seo,

            'label'					=> 'Checkout',            
            'main_view'				=> 'reseller_order/list_checkout',
            'stylesheet_source'		=> 'include/stylesheet/pagecontent/pagecontent_stylesheet',
			'javascript_source'		=> 'include/javascript/pagecontent/pagecontent_javascript',

			'data_reseller'			=> $this->ion_auth->get_user(),
			'total_poin'			=> $total_poin,
			'total_tukar_poin'		=> $total_tukar_poin,
			'poin_saat_ini'			=> reseller_controller::cek_poin_saat_ini($total_poin, $total_tukar_poin),
			'banyak_order_reseller'	=> reseller_controller::banyak_order_reseller($id_reseller),

			'table'					=> $this->table->generate(),
			'foto'					=> $this->db->select('foto_profile')->where(array('user_id' => $id_reseller))->get('meta')->row()->foto_profile,

			'total_harga_semua_unit' => $total_harga_semua_unit,
			'total_berat_semua_unit' => $total_berat_semua_unit,
        );
				
		$this->load->view('include/template/main', $data);
	}

	public function agree_and_process(){

		if (!$this->session->userdata('order_produk_dipilih')) {
			$this->session->set_flashdata('message_warning', 'Silahkan melakukan order terlebih dahulu.');
			redirect('reseller/order');
		}

			$id_reseller = $this->session->userdata('user_id');
			
			$kode_temporary = reseller_controller::buat_kode_temporary_order();
			$produk = $this->session->userdata('order_produk_dipilih');
			$jumlah = $this->session->userdata('jumlah_order_reseller');

			date_default_timezone_get('Asia/Jakarta');
			$tanggal_sekarang = date('Y-m-d');
			$penambahan_tanggal = date('Y-m-d', strtotime('+1 days', strtotime($tanggal_sekarang)));
								

			$result = array();
	        foreach ($produk as $key=>$val) {
	        	$result[] = array(
	        		"reseller_id"					=> $id_reseller,
	        		"kode_temporary" 				=> $kode_temporary,
	        		"produk_id_temporary" 			=> $produk[$key],
	        		"order_quantity_temporary" 		=> $jumlah[$key],
					"order_date_temporary"			=> date("Y-m-d h:i:s"),
					"order_date_experied"			=> $penambahan_tanggal,
					"status"						=> 1,
	        	);
					
			}

			$data = $this->db->insert_batch('temporary_purchase_order', $result);

			if ($data) {

				$pengaturan_email = frontend_controller::get_pengaturan_email();

				// Cek pengaturan email
				if ($pengaturan_email == 1) {

					# KIRIMKAN EMAIL PEMBERITAHUAN KE RESELLER
					$data_reseller = $this->models->get_data_reseller_on_mail($id_reseller);
					$email_to = $data_reseller->email;

					$email_konten = 'Anda baru saja melakukan order produk Lolin Kids Care Product, kami segera mengkonfirmasi order anda. Terima Kasih.';

					$email_template = "template_email_order"; // Samakan dengan nama method template
					$subjek = "Reseller Order";
					
					$kirim = frontend_controller::buat_email($email_to, $subjek, $email_konten, $email_template);

					if ($kirim) {
						#INFO
						$email_to = email_fordward();
						$email_konten = "Baru-baru ini ada reseller yang melakukan order dengan detail : <br>";
						$email_konten .= "Nama : '".$data_reseller->nama_lengkap_reseller."' '".$data_reseller->nama_organisasi."'<br>";
						$email_konten .= "email : '".$data_reseller->email."'<br>";
						$email_konten .= "<br><br>Dimohon untuk ditinjau lagi.";

						$email_template = "template_email_order_info"; // Samakan dengan nama method template
						$subjek = "Reseller Order";
						
						frontend_controller::buat_email($email_to, $subjek, $email_konten, $email_template);

						$array_items = array('order_produk_dipilih', 'jumlah_order_reseller');
						$this->session->unset_userdata($array_items);

						#$this->session->set_flashdata('message_success', 'Berhasil melakukan order, silahkan cek email anda.');
						#redirect('reseller/order');

						$this->session->set_flashdata('pesan', 'Sukses melakukan order.');
						redirect(base_url().'frontend/reseller_order/sukses_order');
					}

				}else{

					$array_items = array('order_produk_dipilih', 'jumlah_order_reseller');
					$this->session->unset_userdata($array_items);

					#$this->session->set_flashdata('message_success', 'Berhasil melakukan order, silahkan cek email anda.');
					#redirect('reseller/order');

					$this->session->set_flashdata('pesan', 'Sukses melakukan order.');
					redirect(base_url().'frontend/reseller_order/sukses_order');
					
				}

				
				
			}else{
				$this->session->set_flashdata('message_warning', 'Terjadi Kesalahan.');
				redirect('reseller/order');
			}
		
	}

	public function hapus_semua_order(){
		$array_items = array('order_produk_dipilih', 'jumlah_order_reseller');

		$this->session->unset_userdata($array_items);

		$this->session->set_flashdata('message_warning', 'Order dibatalkan.');
		redirect(base_url().'reseller/order');
	}

	public function sukses_order(){

		if ($this->session->flashdata('pesan')) {

			$this->load->library('breadcrumb');
			$this->breadcrumb->add('reseller', 'reseller');
			$this->breadcrumb->add('success order', 'reseller/order');

			$id_reseller = $this->session->userdata('user_id');

			$total_poin = reseller_controller::hitung_total_poin($id_reseller);
			$total_tukar_poin = reseller_controller::hitung_tukar_poin($id_reseller);

			$meta = reseller_controller::get_meta(2);

			$data = array(
	            'title' 				=> $meta->judul,
	            'description'			=> $meta->deskripsi_seo,
	            'keyword'				=> $meta->keyword_seo,

	            'label'					=> 'Sukses Order',            
	            'main_view'				=> 'reseller_order/sukses_order',
	            'stylesheet_source'		=> 'include/stylesheet/pagecontent/pagecontent_stylesheet',
				'javascript_source'		=> 'include/javascript/pagecontent/pagecontent_javascript',

				'data_reseller'			=> $this->ion_auth->get_user(),
				'total_poin'			=> $total_poin,
				'total_tukar_poin'		=> $total_tukar_poin,
				'poin_saat_ini'			=> reseller_controller::cek_poin_saat_ini($total_poin, $total_tukar_poin),
				'banyak_order_reseller'	=> reseller_controller::banyak_order_reseller($id_reseller),

				'foto'					=> $this->db->select('foto_profile')->where(array('user_id' => $id_reseller))->get('meta')->row()->foto_profile,
	        );
					
			$this->load->view('include/template/main', $data);

		}else{

			$this->session->set_flashdata('message_warning', 'Silahkan melakukan order terlebih dahulu.');
			redirect('reseller/order');

		}

			

	}



	// ---------------------------------------------------------------------------------------

	public function input_jumlah_order()
	{
		if (!$this->input->post('product[]')) {
			$this->session->set_flashdata('message_warning', 'Silahkan pilih produk.');
			redirect('reseller/order');
		}

		$this->session->set_userdata('order_produk_dipilih', $this->input->post('product[]'));

		$this->load->library('breadcrumb');
		$this->breadcrumb->add('reseller', 'reseller');
		$this->breadcrumb->add('order', 'reseller/order');

		$meta = reseller_controller::get_meta(2);

		$id_reseller = $this->session->userdata('user_id');

		$this->load->library('table');

		$this->table->set_heading('No', 'Nama Produk', 'Kode Produk', '');

		$data_produk = $this->models->ambil_data_produk();

		$options = array(
	        '6' => '6 pcs',
	        '12' => '12 pcs',
	        '36' => '36 pcs',
	        '72' => '72 pcs'
		);

		$no = 1;
		foreach ($data_produk->result() as $key => $value) {

			foreach ($this->session->userdata('order_produk_dipilih') as $value_selected) {

				if ($value_selected == $value->prodsId) {
					$this->table->add_row(
						$no, 
						#$value->prodsName, 
						anchor("#order_of_product", "<b>".$value->prodsName."</b>", array('title'=>$value->prodsName, 'data-target'=>'#order_of_product', 'data-toggle'=>'modal', 'data-id'=>$value->prodsId, 'style'=>'text-decoration:none')),
						$value->prodsKode,
						form_dropdown('jumlah_order_reseller[]', $options, '1', array('class'=>'form-control'))
					);
					$no++;
				}

				
			}
		}

		reseller_controller::buat_tabel();

		$total_poin = reseller_controller::hitung_total_poin($id_reseller);
		$total_tukar_poin = reseller_controller::hitung_tukar_poin($id_reseller);
		
		$data = array(
            'title' 				=> $meta->judul,
            'description'			=> $meta->deskripsi_seo,
            'keyword'				=> $meta->keyword_seo,

            'label'					=> 'Reseller Order',            
            'main_view'				=> 'reseller_order/form_input_jumlah_produk',
            'stylesheet_source'		=> 'include/stylesheet/pagecontent/pagecontent_stylesheet',
			'javascript_source'		=> 'include/javascript/pagecontent/pagecontent_javascript',

			'data_reseller'			=> $this->ion_auth->get_user(),#reseller_controller::ambil_data_reseller($id_reseller),
			'total_poin'			=> $total_poin,
			'total_tukar_poin'		=> $total_tukar_poin,
			'poin_saat_ini'			=> reseller_controller::cek_poin_saat_ini($total_poin, $total_tukar_poin),
			'banyak_order_reseller'	=> reseller_controller::banyak_order_reseller($id_reseller),

			'table'					=> $this->table->generate(),
			'foto'					=> $this->db->select('foto_profile')->where(array('user_id' => $id_reseller))->get('meta')->row()->foto_profile,
        );
				
		$this->load->view('include/template/main', $data);

	}




	public function simpan_order_reseller(){

		if (!$this->session->userdata('order_produk_dipilih')) {
			$this->session->set_flashdata('message_warning', 'Silahkan pilih produk.');
			redirect('reseller/order');
		}

		$id_reseller = $this->session->userdata('user_id');

		$this->session->set_userdata('jumlah_order_reseller', $this->input->post('jumlah_order_reseller[]'));

		if (isset($_POST['submit'])) {

			$kode_temporary = reseller_controller::buat_kode_temporary_order();
			$produk = $this->session->userdata('order_produk_dipilih');
			$jumlah = $this->session->userdata('jumlah_order_reseller');

			$result = array();
	        foreach ($produk as $key=>$val) {
	        	$result[] = array(
	        		"reseller_id"					=> $id_reseller,
	        		"kode_temporary" 				=> $kode_temporary,
	        		"produk_id_temporary" 			=> $produk[$key],
	        		"order_quantity_temporary" 		=> $jumlah[$key],
					"order_date_temporary"			=> date("Y-m-d h:i:s"),
	        	);
					
			}
			$data = $this->db->insert_batch('temporary_purchase_order', $result);

			if ($data) {

				$pengaturan_email = frontend_controller::get_pengaturan_email();

				// Cek pengaturan email
				if ($pengaturan_email == 1) {

					# KIRIMKAN EMAIL PEMBERITAHUAN KE RESELLER
					$data_reseller = $this->models->get_data_reseller_on_mail($id_reseller);
					$email_to = $data_reseller->email;

					$email_konten = 'Anda baru saja melakukan order produk Lolin Kids Care Product, kami segera mengkonfirmasi order anda. Terima Kasih.';

					$email_template = "template_email_order"; // Samakan dengan nama method template
					$subjek = "Reseller Order";
					
					$kirim = frontend_controller::buat_email($email_to, $subjek, $email_konten, $email_template);

					if ($kirim) {
						#INFO
						$email_to = email_fordward();
						$email_konten = "Baru-baru ini ada reseller yang melakukan order dengan detail : <br>";
						$email_konten .= "Nama : '".$data_reseller->nama_lengkap_reseller."' '".$data_reseller->nama_organisasi."'<br>";
						$email_konten .= "email : '".$data_reseller->email."'<br>";
						$email_konten .= "<br><br>Dimohon untuk ditinjau lagi.";

						$email_template = "template_email_order_info"; // Samakan dengan nama method template
						$subjek = "Reseller Order";
						
						frontend_controller::buat_email($email_to, $subjek, $email_konten, $email_template);

						$array_items = array('order_produk_dipilih', 'jumlah_order_reseller');
						$this->session->unset_userdata($array_items);

						$this->session->set_flashdata('message_success', 'Berhasil melakukan order, silahkan cek email anda.');
						redirect('reseller/order');
					}

				}else{

					$array_items = array('order_produk_dipilih', 'jumlah_order_reseller');
					$this->session->unset_userdata($array_items);

					$this->session->set_flashdata('message_success', 'Berhasil melakukan order, silahkan cek email anda.');
					redirect('reseller/order');
					
				}
				
			}else{
				$this->session->set_flashdata('message_warning', 'Terjadi Kesalahan.');
				redirect('reseller/order');
			}


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
				'content' 	=> $this->models->modal_ambil_data_produk($get_id_product),
			);
		}

		$this->load->view('reseller_order/modal_detail_produk', $this->data);
	}

}

/* End of file Reseller_order.php */
/* Location: ./application/modules/frontend/controllers/Reseller_order.php */