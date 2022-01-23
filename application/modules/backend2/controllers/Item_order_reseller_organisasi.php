<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item_order_reseller_organisasi extends Backend_Controller {

	public function __construct()
	{
		parent::__construct();

		if (!$this->ion_auth->logged_in())
        {
        	$this->session->set_flashdata('message_warning', 'You must be an admin to view this page');
            redirect('login/auth/index','refresh');
        }

        if (!$this->ion_auth->is_admin())
        {
           $this->session->set_flashdata('message_warning', 'You must be an admin to view this page');
           redirect('login/auth/index','refresh');
        }
		
		$this->load->model('item_order_reseller_organisasi_model', 'models');
	}

	public function index()
	{
		
	}

	public function add_item_order()
	{
		$this->load->helper('security');
		$this->load->library('breadcrumb');

		$this->load->library('table');

		$this->table->set_heading(array('No.', 'Nama Produk', 'Kode Produk', ''));

		$data_produk = $this->db->get('product');

		$no = 1;
		foreach ($data_produk->result() as $value) {
			$this->table->add_row(array(
				$no, 
				$value->prodsName, 
				$value->prodsKode,
				'<label><input type="checkbox" class="flat" name="product[]" value="'.$value->prodsId.'"> Pilih</label>'
			));
			$no++;
		}

		core:: buat_tabel();

		$this->data = array(
			'main_view' => 'item_order_reseller_organisasi/form_add_item_order',
			'table' => $this->table->generate(),
		);

		$this->load->view('include/template', $this->data);
	}

	public function check_orders()
	{
		if (count($_POST['product']) == 0) {
		  	$this->session->set_flashdata('Silahkan Check Produk Terlebih Dahulu.');
            $url = $this->session->userdata('lolin_urlback_backend');
			redirect($url);
		 }else{

		 	$this->load->library('breadcrumb');
			$this->breadcrumb->add('Member Orders', 'adm_member_orders');

			$reseller_id = $this->session->userdata('reseller_id');

			#check nama organisasi atau reseller
			$cek_nama_perusahaan = $this->db->get_where('meta', array('user_id'=>$reseller_id))->row();
			if ($cek_nama_perusahaan->nama_organisasi == "") {
				$nama_pembeli = $cek_nama_perusahaan->nama_lengkap;
			}else{
				$nama_pembeli = $cek_nama_perusahaan->nama_organisasi." (".$cek_nama_perusahaan->nama_lengkap.")";
			}

	        $data = array(
	        	'nama_reseller'		=> $nama_pembeli,
	        	'reseller_id'		=> $reseller_id,
	            'product'           => $this->input->post('product[]'),
	            'main_view'         => 'item_order_reseller_organisasi/list_input_jumlah_pembelian',
	        );
	                
	        $this->load->view('include/template',$data);
		}		
	}

	# FUNGSI CEK HARGA
	function cek_harga($id_produk, $harga_produk, $jumlah_order){

		$data_produk = $this->db->get_where('diskon_harga', array('produk_id'=>$id_produk, 'jumlah_unit <=' => $jumlah_order))->row();
		
		return $data_produk->harga_jumlah_unit;
		
	}

	public function confirmation_order(){

		if ($this->input->post('prodsId[]') == "") {
			$this->session->set_flashdata('Silahkan Masukkan Jumlah Pembelian.');
            redirect('backend/order_reseller_organisasi/index');
        }else{
        	
	        $this->load->library('breadcrumb');
			$this->breadcrumb->add('Member Orders', 'adm_member_orders');

			$newdata = array(
		        'prodsId'     	=> $this->input->post('prodsId[]'),
		        'jumlah' 		=> $this->input->post('jumlah[]'),
			);

			$this->session->set_userdata($newdata);
			
	        $data = array(
	            'main_view'         => 'item_order_reseller_organisasi/list_order_confirmation',
	        );
	                
	        $this->load->view('include/template',$data);
        }
	}

	public function simpan_order()
	{
		if (!$this->session->userdata('reseller_id')) {
			$this->session->set_flashdata('Silahkan Masukkan Jumlah Pembelian.');
            redirect('backend/order_reseller_organisasi/index');
        }else{

        	$order_code = $this->session->userdata('order_code');
        	$id_reseller = $this->session->userdata('reseller_id');
        	
        	$id_produk = $this->session->userdata('prodsId');
        	$jumlah = $this->session->userdata('jumlah');
        	$id_admin = $this->session->userdata('user_id');

        	foreach ($id_produk as $key => $value) {
				$this->session->set_userdata('diskon'.$key, $_POST['diskon'.$key]);
			}

        	$result = array();
	        foreach ($this->session->userdata('prodsId') as $key=>$val) {
	        	$result[] = array(
	        		"reseller_id"			=> $id_reseller,
	        		"order_code" 			=> $order_code,
	        		"produk_id" 			=> $id_produk[$key],
	        		"order_quantity" 		=> $jumlah[$key],
	        		"order_unit_price" 		=> $jumlah[$key],
					"order_date"			=> date("Y-m-d h:i:s"),
					"order_status"			=> 'confirmed',
					"diskon_id"				=> $diskon_id,
					"order_admin_id"		=> $id_admin,
	        	);
					
			}
			$data = $this->db->insert_batch('purchase_order', $result);

			if ($data) {
				
				foreach ($id_produk as $key => $value) {
					$this->session->unset_userdata('diskon'.$key, $_POST['diskon'.$key]);
				}

				$array_items = array('reseller_id', 'order_code', 'jumlah', 'prodsId');
				$this->session->unset_userdata($array_items);

				$this->session->set_flashdata('message_success', 'Berhasil menambah data.');
				redirect('backend/order_reseller_organisasi/index');
			}else{
				$this->breadcrumb->add('Banner', 'adm_banner');
				$this->breadcrumb->add('Tambah Banner', 'adm_banner/add_banner');

				$this->data['pesan_error'] = "Terjadi Kesalahan ";
				redirect('backend/order_reseller_organisasi/index');
			}


        }
	}

	public function edit_item_order($id)
	{
		$this->load->helper('security');
		$this->load->library('breadcrumb');

		$this->data = array(
			'main_view' 		=> 'item_order_reseller_organisasi/form_edit_item_order',
		);

		if (empty($id)) {
			$url = $this->session->userdata('lolin_urlback_backend');
			redirect($url);
		}else{

			$search = $this->models->search_item_order($id);

			if ($search) {
				foreach ($search as $key => $value) {
					$this->data['form_value'][$key] = $value;
				}
				$this->session->set_userdata('id_sekarang', $search->order_id);

				$this->data['edit_data'] = $search;


				$this->load->view('include/template', $this->data);
			}else{
				$this->session->set_flashdata('message_warning', 'Tidak ditemukan data yang di edit.');
				$url = $this->session->userdata('lolin_urlback_backend');
				redirect($url);
			}
		}
	}

	public function update_diskon(){

		$this->load->library('breadcrumb');

		$newdata = array(
	        'prodsId'     	=> $this->input->post('prodsId'),
	        'order_id'     	=> $this->input->post('order_id'),
	        'jumlah' 		=> $this->input->post('jumlah'),
	        
		);

		$this->session->set_userdata($newdata);

		$this->data = array(
			'main_view' 		=> 'item_order_reseller_organisasi/list_edit_order_confirmation',
		);

		$this->load->view('include/template',$this->data);

	}

	public function simpan_update(){

		if (isset($_POST['submit'])) {

				$id = $this->session->userdata('order_id');

				$input = array(
					'order_quantity'	=> $this->session->userdata('jumlah'),
					'diskon_id'			=> $this->input->post('diskon'),
				);

				$update = $this->models->update_item_order($input, $id);
				
				if ($update === TRUE) {

					$array_items = array('prodsId', 'jumlah', 'diskon_id');
					$this->session->unset_userdata($array_items);

					$this->session->set_flashdata('message_success', 'Berhasil menyimpan data.');
					$url = $this->session->userdata('lolin_urlback_backend');
					redirect($url);
				}else{

					$this->data['pesan_error'] = 'Gagal melakukan perubahan.';
					$this->load->view('include/template', $this->data);
				}

			}else{

				redirect(base_url('backend/order_reseller_organisasi/index'),'refresh');

			}
	}

	public function delete_item_order($id = NULL)
	{
		if (empty($id)) {
			$url = $this->session->userdata('lolin_urlback_backend');
			redirect($url);			
		}else{

			if ($this->models->remove_item_order($id) === TRUE) {
				$this->session->set_flashdata('message_success', 'Proses hapus data berhasil.');
				$url = $this->session->userdata('lolin_urlback_backend');
				redirect($url);
			}else{
				$this->session->set_flashdata('message_error', 'Gagal menghapus data!');
				$url = $this->session->userdata('lolin_urlback_backend');
				redirect($url);
			}
		}
	}

}

/* End of file Item_order_reseller_organisasi.php */
/* Location: ./application/modules/backend/controllers/Item_order_reseller_organisasi.php */