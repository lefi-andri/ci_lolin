<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_reseller_organisasi extends Backend_Controller {

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
		
		$this->load->model('order_reseller_organisasi_model', 'models');
	}

	public function index()
	{
		$this->load->library('breadcrumb');

		$url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_backend', $url);

		$this->load->library('table');

		$this->table->set_heading('No', 'Nomor Pembelian', 'Tanggal Pembelian','Nama Organisasi','Perwakilan','Kode Reseller','');

		$this->db->select('*');
		$this->db->from('purchase_order');
        $this->db->join('users', 'users.id = purchase_order.reseller_id');
        $this->db->join('meta', 'meta.user_id = users.id');
        $this->db->like('meta.reseller_id', 'RSO');
        $this->db->group_by('purchase_order.order_code');
        $this->db->order_by('purchase_order.order_code', 'DESC');
		$query = $this->db->get();

		$no = 1;
		foreach ($query->result() as $value) {
			$id 	= $value->order_code;
			$nama 	= $value->order_code;
			$this->table->add_row(
				$no,
				$value->order_code,
				$value->order_date,
				$value->nama_organisasi,
				$value->nama_lengkap,
				$value->reseller_id,
				anchor("backend/order_reseller_organisasi/edit_order/$id", '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit', array('title'=>"Detail Order $nama" , 'class'=>'btn btn-dark btn-xs')).' '.
				anchor("backend/order_reseller_organisasi/delete_order/$id", '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete', array('title'=>"Detail Order $nama" , 'class'=>'btn btn-danger btn-xs','onclick' => "return confirm('Anda yakin ingin menghapus data $nama ?')"))
			);
			$no++;
		}
		
		core:: buat_tabel();

		$this->data = array(
			'main_view' 	=> 'order_reseller_organisasi/list_order_reseller_organisasi',
			'table' => $this->table->generate(),
		);

		$this->load->view('include/template', $this->data);
	}

	public function form_pilih_reseller(){
		$this->load->library('breadcrumb');

		$this->load->library('table');

		$this->table->set_heading('No', 'Nama', '');

		$group = 'reseller_organisasi';
		$users = $this->ion_auth->get_users($group);
		
		$no = 1;
		foreach ($users as $value) {

			$data = array(
		        'name'          => 'id_reseller_order',
		        'value'         => $value->id,
		        'checked'       => FALSE,
		        'class'         => 'flat',
		        'required'		=> 'required'
			);

			$this->table->add_row(
				$no,
				$value->nama_lengkap,
				'<label>'.form_radio($data).' Pilih</label>'
			);
			$no++;
		}

		core:: buat_tabel();

		$this->data = array(
			'form_action' => 'backend/order_reseller_organisasi/form_pilih_produk',
			'main_view' => 'order_reseller_organisasi/form_add_for_user',
			'table' => $this->table->generate()
		);

		$this->load->view('include/template', $this->data);
	}

	public function form_pilih_produk(){
		$this->session->set_userdata('reseller_id', $this->input->post('id_reseller_order'));
		
		$this->load->library('breadcrumb');

		$this->load->library('table');

		$this->table->set_heading('No', 'Nama', '');

		$query = $this->db->get_where('product', array('prodsShow'=>'1'));

		$no = 1;
		foreach ($query->result() as $value) {

			$data = array(
		        'name'          => 'data_id_produk[]',
		        'value'         => $value->prodsId,
		        'checked'       => FALSE,
		        'class'         => 'flat',
		        #'required'		=> 'required'
			);

			$this->table->add_row(
				$no,
				$value->prodsName,
				'<label>'.form_checkbox($data).' Pilih</label>'
			);
			$no++;
		}

		core:: buat_tabel();

		$this->data = array(
			'form_action' => 'backend/order_reseller_organisasi/form_quantity_produk',
			'main_view' => 'order_reseller_organisasi/form_add_for_produk',
			'table' => $this->table->generate()
		);

		$this->load->view('include/template', $this->data);
	}

	public function form_quantity_produk(){

		if ($this->input->post('data_id_produk[]') == "") {
			$this->session->set_flashdata('Produk tidak boleh kosong.');
            redirect('backend/order_reseller_organisasi/index');
        }

		$this->session->set_userdata('produk_id', $this->input->post('data_id_produk[]'));

		$this->load->library('breadcrumb');

		$this->data = array(
			'form_action' => 'backend/order_reseller_organisasi/form_diskon_produk',
			'main_view' => 'order_reseller_organisasi/form_add_for_quantity_produk',
			'produk' => $this->input->post('data_id_produk[]'),
		);

		$this->load->view('include/template', $this->data);
		
	}

	public function form_diskon_produk(){

		$this->session->set_userdata('quantity', $this->input->post('quantity[]'));
		
		$this->load->library('breadcrumb');

		$this->data = array(
			'form_action' => 'backend/order_reseller_organisasi/form_konfirmasi',
			'main_view' => 'order_reseller_organisasi/form_add_for_diskon_produk',
		);

		$this->load->view('include/template', $this->data);
		
	}

	public function form_konfirmasi(){

		$this->load->library('breadcrumb');

		$reseller_id = $this->session->userdata('reseller_id');
		$produk_id = $this->session->userdata('produk_id');
		$quantity = $this->session->userdata('quantity');
		$admin_id = $this->session->userdata('user_id');

		foreach ($produk_id as $key => $value) {
			$this->session->set_userdata('diskon'.$key, $_POST['diskon'.$key]);
		}

		$this->load->library('table');

		$this->table->set_heading('No', 'Nama Produk', 'Jumlah Order', 'Harga Satuan', 'Harga Diskon');

		$no = 1;
		foreach ($produk_id as $key=>$val) {
			$diskon_id = $this->session->userdata('diskon'.$key);
			$this->table->add_row(
				$no,
				$produk_id[$key],
				'harga',
				$quantity[$key],
				$diskon_id
			);
		$no++;
		}

		core:: buat_tabel();

		$this->data = array(
			'form_action' => 'backend/order_reseller_organisasi/form_simpan',
			'main_view' => 'order_reseller_organisasi/form_konfirmasi',
			'table' => $this->table->generate(),
		);

		$this->load->view('include/template', $this->data);

	}

	public function form_simpan(){
		$reseller_id = $this->session->userdata('reseller_id');
		$produk_id = $this->session->userdata('produk_id');
		$quantity = $this->session->userdata('quantity');
		$admin_id = $this->session->userdata('user_id');

		$result = array();
        foreach ($produk_id as $key=>$val) {
        	$diskon_id = $this->session->userdata('diskon'.$key);
        	$result[] = array(
        		"reseller_id"			=> $reseller_id,
        		"order_code" 			=> core::buat_kode_order(),
        		"produk_id" 			=> $produk_id[$key],
        		"order_quantity" 		=> $quantity[$key],
        		"order_unit_price" 		=> $quantity[$key],
				"order_date"			=> date("Y-m-d h:i:s"),
				"order_status"			=> 'confirmed',
				"diskon_id"				=> $diskon_id,
				"order_admin_id"		=> $admin_id,
        	);
				
		}
		$data = $this->db->insert_batch('purchase_order', $result);

		if ($data) {

			$array_items = array('reseller_id', 'produk_id', 'quantity');
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

	public function edit_order($id)
	{
		$this->load->helper('security');
		$this->load->library('breadcrumb');

		$this->data = array(
			'main_view' 		=> 'order_reseller_organisasi/form_edit_order',
			'form_action' 		=> "backend/order_reseller_organisasi/edit_order/$id"#'admin/faqs/edit/'.$id
		);

		if (empty($id)) {
			$url = $this->session->userdata('lolin_urlback_backend');
			redirect($url);
		}else{

			$search = $this->models->search_order($id);
				
			if ($search) {
				
				$url = $this->uri->uri_string();
				$this->session->set_userdata('lolin_urlback_backend', $url);

				$this->load->library('table');

				$this->table->set_heading(array('No.','Name Produk', 'Jumlah Pembelian', 'Tanggal Order', ''));

				$no = 1;
				foreach ($search as $value) {
					$id = $value->order_id;
					$nama = $value->prodsName;

					$this->table->add_row(array(
						$no,
						$value->prodsName, 
						$value->order_quantity, 
						$value->order_date,
						anchor("backend/item_order_reseller_organisasi/edit_item_order/$id",'<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit', array('title'=>'judul', 'class'=>'btn btn-dark btn-xs'))." ".
						anchor("backend/item_order_reseller_organisasi/delete_item_order/$id",'<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete', array('title'=>'hapus data', 'class'=>'btn btn-dark btn-xs' ,'onclick' => "return confirm('Anda yakin ingin menghapus data $nama ?')")),
					));
				$no++;
				}

				core:: buat_tabel();

				$this->session->set_userdata('order_code', $value->order_code);
				$this->session->set_userdata('reseller_id', $value->reseller_id);

				$this->data['table'] = $this->table->generate();


				$this->breadcrumb->add('News', 'adm_news');
				$this->breadcrumb->add('Edit News Kategori', 'adm_news/edit_faq');

				$this->load->view('include/template', $this->data);
			}else{
				$this->session->set_flashdata('message_warning', 'Tidak ditemukan data yang di edit.');
				$url = $this->session->userdata('lolin_urlback_backend');
				redirect($url);
			}

		}
	}

	public function delete_order($id = NULL)
	{
		if (empty($id)) {
			$url = $this->session->userdata('lolin_urlback_backend');
			redirect($url);			
		}else{

			if ($this->models->remove_order($id) === TRUE) {
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

/* End of file Order_reseller_organisasi.php */
/* Location: ./application/modules/backend/controllers/Order_reseller_organisasi.php */