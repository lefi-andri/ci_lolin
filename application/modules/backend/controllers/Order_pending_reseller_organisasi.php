<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_pending_reseller_organisasi extends Backend_Controller {

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
		
		$this->load->model('order_pending_reseller_organisasi_model', 'models');
	}

	public function index()
	{
		$this->load->library('breadcrumb');

		$url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_backend', $url);

		$data_order_pending = $this->models->ambil_data_order_pending();

		$this->load->library('table');

		$this->table->set_heading('No.', 'Id Reseller', 'Nama','Kode', 'Tanggal', '');

		$no = 1;
		foreach ($data_order_pending->result() as $key => $value) {
			$id = $value->kode_temporary;
			$this->table->add_row(
				$no,
				$value->reseller_id,
				$value->nama_lengkap,
				$value->kode_temporary,
				$value->order_date_temporary,
				anchor('backend/order_pending_reseller_organisasi/detail_order_pending/'.$id, 'Detail order', array('class'=>'btn btn-dark btn-xs')).' '.
				(($value->status == 1) ? anchor('backend/order_pending_reseller_organisasi/proses_order_pending/'.$id, 'Proses >>', array('class'=>'btn btn-danger btn-xs', 'title'=>'Proses data pending order', 'onclick' => "return confirm('Anda yakin ingin memproses data ?')")) : '').' '.
				anchor('backend/order_pending_reseller_organisasi/delete_order_pending/'.$id, 'Delete', array('class'=>'btn btn-danger btn-xs', 'title'=>'Proses data pending order', 'onclick' => "return confirm('Anda yakin ingin menghapus data ?')"))
			);
			$no++;
		}

		backend_controller::buat_tabel();

		$this->data = array(
			'main_view' => 'order_pending_reseller_organisasi/list_pending',
			'table' => $this->table->generate(),
		);

		$this->load->view('include/template', $this->data);
	}

	public function proses_order_pending($id = NULL){
		$this->session->set_userdata('id_sekarang', $id);

		$this->load->library('breadcrumb');
		$this->breadcrumb->add('Member Orders', 'adm_member_orders');
		
        $data = array(
        	'data_temporary' => $this->models->ambil_data_temporary_order($id),
            'main_view' => 'order_pending_reseller_organisasi/list_diskon_order_pending',
        );
                
        $this->load->view('include/template',$data);
	}

	public function simpan_order_pending()
	{
		if (!$this->input->post('reseller_id[]')) {
			$this->session->set_flashdata('Silahkan Masukkan Jumlah Pembelian.');
            redirect('backend/order_pending_reseller_organisasi/index');
        }else{
        	
        	$reseller_id = $this->input->post('reseller_id[]');
        	$id_produk = $this->input->post('prodsId[]');
        	$jumlah = $this->input->post('jumlah[]');
        	$order_date_temporary = $this->input->post('order_date_temporary[]');
        	$id_admin = $this->session->userdata('user_id');

        	#print_r($id_produk);
        	foreach ($id_produk as $key => $value) {
				$this->session->set_userdata('diskon'.$key, $_POST['diskon'.$key]);
			}

			date_default_timezone_get('Asia/Jakarta');
			$tanggal_sekarang = date('Y-m-d');
			$tambah_tanggal = date('Y-m-d', strtotime('+1 year', strtotime($tanggal_sekarang)));

        	$result = array();
	        foreach ($id_produk as $key=>$val) {
	        	$diskon_id = $this->session->userdata('diskon'.$key);
	        	$result[] = array(
	        		"reseller_id"			=> $reseller_id[$key],
	        		"order_code" 			=> core::buat_kode_order(),
	        		"produk_id" 			=> $id_produk[$key],
	        		"order_quantity" 		=> $jumlah[$key],
	        		"order_unit_price" 		=> $jumlah[$key],
	        		"order_date_temporary" 	=> $order_date_temporary[$key],
					"order_date"			=> date("Y-m-d h:i:s"),
					"order_status"			=> 'confirmed',
					"diskon_id"				=> $diskon_id,
					"experied_poin_period"	=> $tambah_tanggal,
					"order_admin_id"		=> $id_admin,
	        	);
					
			}
			$data = $this->db->insert_batch('purchase_order', $result);

			if ($data) {

				# Hapus Temporary
				$id_temp = $this->session->userdata('id_sekarang');
				$this->models->hapus_temporary($id_temp);

				$array_items = array('id_reseller', 'order_code', 'jumlah');
				$this->session->unset_userdata($array_items);

				$this->session->set_flashdata('message_success', 'Berhasil menambah data.');
				redirect('backend/order_pending_reseller_organisasi/index');
			}else{
				$this->breadcrumb->add('Banner', 'adm_banner');
				$this->breadcrumb->add('Tambah Banner', 'adm_banner/add_banner');

				$this->data['pesan_error'] = "Terjadi Kesalahan ";
				redirect('backend/order_pending_reseller_organisasi/index');
			}

        }
	}

	public function detail_order_pending($id){

		$this->load->library('breadcrumb');

		$this->db->select('*');
		$this->db->from('product');
		$this->db->join('temporary_purchase_order', 'temporary_purchase_order.produk_id_temporary = product.prodsId');
		$query = $this->db->get();

		$this->load->library('table');

		$this->table->set_heading('No.', 'Nama Produk', 'Quantity','Tanggal');

		$no = 1;
		foreach ($query->result() as $key => $value) {
			$id = $value->kode_temporary;
			$this->table->add_row(
				$no,
				$value->prodsName,
				$value->order_quantity_temporary,
				$value->order_date_temporary
			);
			$no++;
		}

		backend_controller::buat_tabel();

		$this->data = array(
			'main_view' => 'order_pending_reseller_organisasi/list_detail',
			'table' => $this->table->generate(),
		);

		$this->load->view('include/template', $this->data);

	}

	public function delete_order_pending($id = NULL){
		
		if (empty($id)) {
			$this->session->set_flashdata('message_warning', 'Tidak ditemukan data yang di dihapus.');
			$url = $this->session->userdata('lolin_urlback_backend');
			redirect($url);			
		} else {
			if ($this->models->hapus_order_pending($id) === TRUE) {
	
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

/* End of file Order_pending_reseller_organisasi.php */
/* Location: ./application/modules/backend/controllers/Order_pending_reseller_organisasi.php */