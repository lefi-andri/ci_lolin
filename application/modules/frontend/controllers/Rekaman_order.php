<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekaman_order extends Reseller_Controller {

	public function __construct()
	{
		parent::__construct();

		if (!$this->ion_auth->logged_in())
        {
        	$this->session->set_flashdata('message_warning', 'Anda harus login sebagai reseller.');
            redirect('reseller','refresh');
        }
		
		$this->load->model('rekaman_order_model', 'models');
	}

	public function index()
	{
		$this->load->helper('indonesiandate');

		$url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_frontend', $url);

		$this->load->library('breadcrumb');
		$this->breadcrumb->add('reseller', 'reseller');
		$this->breadcrumb->add('order', 'reseller/order');
		$this->breadcrumb->add('history', 'reseller/order/rekaman');

		$id_reseller = $this->session->userdata('user_id');

		$this->load->library('table');

		$this->table->set_heading('No', 'Nomor Invoice', 'Tanggal', 'Detail');

		$data_purchase_order = reseller_controller::data_purchase_order_reseller($id_reseller);

		$no = 1;
		foreach ($data_purchase_order->result() as $key => $value) {

			$id = $value->order_code;

			list($tanggal, $waktu) = explode(' ', $value->order_date);

			$this->table->add_row(
				$no, 
				anchor(base_url().'frontend/rekaman_order/detail_per_order/'.$id, $value->order_code, array(''=>'')), 
				indonesian_date($tanggal).' --- '.$waktu,
				anchor(base_url().'frontend/rekaman_order/detail_per_order/'.$id, '<b>Detail</b>', array(''=>''))
			);
			$no++;
		}

		reseller_controller::buat_tabel();

		$total_poin = reseller_controller::hitung_total_poin($id_reseller);
		$total_tukar_poin = reseller_controller::hitung_tukar_poin($id_reseller);
		
		$meta = reseller_controller::get_meta(2);

		$data = array(
            'title' 				=> "History Order - Lolin Reseller or Distributor",
            'description'			=> $meta->deskripsi_seo,
            'keyword'				=> $meta->keyword_seo,

            'label'					=> 'History Order',            
            'main_view'				=> 'rekaman_order/list_rekaman_order',
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

	public function detail_per_order($id){

		$this->load->helper('indonesiandate');

		$this->load->library('breadcrumb');
		$this->breadcrumb->add('reseller', 'reseller');
		$this->breadcrumb->add('order', 'reseller/order');
		$this->breadcrumb->add('pending', 'reseller/order/pending');

		$id_reseller = $this->session->userdata('user_id');	
		
		#$tanggal_sekarang = date('Y-m-d');

		#$the_date =  date('Y-m-d', strtotime('+1 year', strtotime($tanggal_sekarang)));

		#list($tahun_exp, $bulan_exp, $tanggal_exp) = explode('-', $the_date);

		#$tahun_sekarang = date('Y');

		#$query = $this->db->query("SELECT *, DATEDIFF(DATE_ADD(order_date, INTERVAL 90 DAY), CURDATE()) as selisih, as tanggal_pe FROM purchase_order WHERE order_code='$id'")->row();

		#print_r($query);

		#echo $query->selisih;

		$this->db->select('*');
		$this->db->from('purchase_order');
		$this->db->join('product', 'product.prodsId = purchase_order.produk_id');
		$this->db->where('purchase_order.order_code', $id);
		$query = $this->db->get();

		$this->load->library('table');

		$this->table->set_heading('No.', 'Nama Produk', 'Quantity');



		$no = 1;
		foreach ($query->result() as $value) {

			$data_quantity = $this->db->get_where('diskon_harga', array('diskon_id'=>$value->order_quantity))->row();

			$this->table->add_row(
				$no, 
				$value->prodsName, 
				$data_quantity->jumlah_unit
			);
			$no++;
		}
		
		
		reseller_controller::buat_tabel();
		
		$total_poin = reseller_controller::hitung_total_poin($id_reseller);
		$total_tukar_poin = reseller_controller::hitung_tukar_poin($id_reseller);

		$meta = reseller_controller::get_meta(2);
		
		$data = array(
            'title' 				=> "Detail Order $id",
            'description'			=> $meta->deskripsi_seo,
            'keyword'				=> $meta->keyword_seo,
            
            'label'					=> 'Detail Order Pending Per Order',
            'main_view'				=> 'rekaman_order/list_detail_rekaman_per_order',
            'stylesheet_source'		=> 'include/stylesheet/pagecontent/pagecontent_stylesheet',
			'javascript_source'		=> 'include/javascript/pagecontent/pagecontent_javascript',

			'data_reseller'			=> $this->ion_auth->get_user(),
			'total_poin'			=> $total_poin,
			'total_tukar_poin'		=> $total_tukar_poin,
			'poin_saat_ini'			=> reseller_controller::cek_poin_saat_ini($total_poin, $total_tukar_poin),
			'banyak_order_reseller'	=> reseller_controller::banyak_order_reseller($id_reseller),

			'table'					=> $this->table->generate(),
			'foto'					=> $this->db->select('foto_profile')->where(array('user_id' => $id_reseller))->get('meta')->row()->foto_profile,
			'nomor_order'			=> $id,
        );
				
		$this->load->view('include/template/main', $data);

	}

	public function rekaman(){
		$this->load->helper('indonesiandate');
		
		$this->load->library('breadcrumb');
		$this->breadcrumb->add('reseller', 'reseller');
		$this->breadcrumb->add('order', 'reseller/order');
		$this->breadcrumb->add('history', 'reseller/order/rekaman');
		$this->breadcrumb->add('detail', 'reseller/order/rekaman/detail');

		$id_reseller = $this->session->userdata('user_id');

		$total_poin = reseller_controller::hitung_total_poin($id_reseller);
		$total_tukar_poin = reseller_controller::hitung_tukar_poin($id_reseller);

		$meta = reseller_controller::get_meta(2);
		
		$data = array(
            'title' 				=> "Detail History Order - Lolin Reseller or Distributor",
            'description'			=> $meta->deskripsi_seo,
            'keyword'				=> $meta->keyword_seo,

            'label'					=> 'Detail History Order',            
            'main_view'				=> 'rekaman_order/list_detail_rekaman_order',
            'stylesheet_source'		=> 'include/stylesheet/pagecontent/pagecontent_stylesheet',
			'javascript_source'		=> 'include/javascript/pagecontent/pagecontent_javascript',

			'data_reseller'			=> $this->ion_auth->get_user(),
			'total_poin'			=> $total_poin,
			'total_tukar_poin'		=> $total_tukar_poin,
			'poin_saat_ini'			=> reseller_controller::cek_poin_saat_ini($total_poin, $total_tukar_poin),
			'banyak_order_reseller'	=> reseller_controller::banyak_order_reseller($id_reseller),

			'data_rekaman'			=> reseller_controller::cari_rekaman_order_reseller($id_reseller),
			'reseller_id'			=> $id_reseller,
			'foto'					=> $this->db->select('foto_profile')->where(array('user_id' => $id_reseller))->get('meta')->row()->foto_profile,
        );
				
		$this->load->view('include/template/main', $data);
	}

	public function rekaman_belum_dikonfirmasi(){

		$this->load->helper('indonesiandate');

		$url = $this->uri->uri_string();
		$this->session->set_userdata('lolin_urlback_frontend', $url);

		$this->load->library('breadcrumb');
		$this->breadcrumb->add('reseller', 'reseller');
		$this->breadcrumb->add('order', 'reseller/order');
		$this->breadcrumb->add('pending', 'reseller/order/pending');

		$id_reseller = $this->session->userdata('user_id');		

		$this->load->library('table');

		$this->table->set_heading('No', 'Nomor Invoice Sementara', 'Tanggal', 'Status', '');

		$data_rekaman_pending = reseller_controller::cari_rekaman_belum_dikonfirmasi($id_reseller);

		$no = 1;
		foreach ($data_rekaman_pending->result() as $key => $value) {

			$id = $value->kode_temporary;

			list($tanggal, $waktu) = explode(' ', $value->order_date_temporary);

			$this->table->add_row(
				$no, 
				anchor(base_url().'frontend/rekaman_order/detail_rekaman_per_order/'.$id, $value->kode_temporary, array(''=>'')), 
				indonesian_date($tanggal).' --- '.$waktu,
				($value->status == 1) ? 'Belum dikonfirmasi' : 'Dibatalkan',
				anchor(base_url().'frontend/rekaman_order/detail_rekaman_per_order/'.$id, '<b>Detail</b>', array(''=>''))
			);
			$no++;
		}

		reseller_controller::buat_tabel();


		$total_poin = reseller_controller::hitung_total_poin($id_reseller);
		$total_tukar_poin = reseller_controller::hitung_tukar_poin($id_reseller);

		$meta = reseller_controller::get_meta(2);
		
		$data = array(
            'title' 				=> "Order Belum Dikonfirmasi",
            'description'			=> $meta->deskripsi_seo,
            'keyword'				=> $meta->keyword_seo,
            
            'label'					=> 'Order Pending',            
            'main_view'				=> 'rekaman_order/list_rekaman_belum_dikonfirmasi',
            'stylesheet_source'		=> 'include/stylesheet/pagecontent/pagecontent_stylesheet',
			'javascript_source'		=> 'include/javascript/pagecontent/pagecontent_javascript',

			'data_reseller'			=> $this->ion_auth->get_user(),#reseller_controller::ambil_data_reseller($id_reseller),
			'total_poin'			=> $total_poin,
			'total_tukar_poin'		=> $total_tukar_poin,
			'poin_saat_ini'			=> reseller_controller::cek_poin_saat_ini($total_poin, $total_tukar_poin),
			'banyak_order_reseller'	=> reseller_controller::banyak_order_reseller($id_reseller),

			#'data_rekaman_pending'	=> reseller_controller::cari_rekaman_belum_dikonfirmasi($id_reseller),
			'table'					=> $this->table->generate(),
			'foto'					=> $this->db->select('foto_profile')->where(array('user_id' => $id_reseller))->get('meta')->row()->foto_profile,
        );
				
		$this->load->view('include/template/main', $data);
	}

	public function detail_rekaman_per_order($id){

		$this->load->helper('indonesiandate');

		$this->load->library('breadcrumb');
		$this->breadcrumb->add('reseller', 'reseller');
		$this->breadcrumb->add('order', 'reseller/order');
		$this->breadcrumb->add('pending', 'reseller/order/pending');

		$id_reseller = $this->session->userdata('user_id');	
		
		$this->db->select('*');
		$this->db->from('temporary_purchase_order');
		$this->db->join('product', 'product.prodsId = temporary_purchase_order.produk_id_temporary');
		$this->db->where('temporary_purchase_order.kode_temporary', $id);
		$query = $this->db->get();

		$this->load->library('table');

		$this->table->set_heading('No.', 'Nama Produk', 'Quantity');



		$no = 1;
		foreach ($query->result() as $value) {

			$data_temporary = $this->db->get_where('diskon_harga', array('diskon_id'=>$value->order_quantity_temporary))->row();

			$this->table->add_row(
				$no, 
				$value->prodsName, 
				$data_temporary->jumlah_unit
			);
			$no++;
		}
		
		reseller_controller::buat_tabel();
		
		$total_poin = reseller_controller::hitung_total_poin($id_reseller);
		$total_tukar_poin = reseller_controller::hitung_tukar_poin($id_reseller);

		$meta = reseller_controller::get_meta(2);
		
		$data = array(
            'title' 				=> $meta->judul,
            'description'			=> $meta->deskripsi_seo,
            'keyword'				=> $meta->keyword_seo,
            
            'label'					=> 'Detail Order Pending Per Order',
            'main_view'				=> 'rekaman_order/list_detail_rekaman_per_order_belum_dikonfirmasi',
            'stylesheet_source'		=> 'include/stylesheet/pagecontent/pagecontent_stylesheet',
			'javascript_source'		=> 'include/javascript/pagecontent/pagecontent_javascript',

			'data_reseller'			=> $this->ion_auth->get_user(),
			'total_poin'			=> $total_poin,
			'total_tukar_poin'		=> $total_tukar_poin,
			'poin_saat_ini'			=> reseller_controller::cek_poin_saat_ini($total_poin, $total_tukar_poin),
			'banyak_order_reseller'	=> reseller_controller::banyak_order_reseller($id_reseller),

			'table'					=> $this->table->generate(),
			'foto'					=> $this->db->select('foto_profile')->where(array('user_id' => $id_reseller))->get('meta')->row()->foto_profile,
			'nomor_temporary'		=> $id,
        );
				
		$this->load->view('include/template/main', $data);
	}

}

/* End of file Rekaman_order.php */
/* Location: ./application/modules/frontend/controllers/Rekaman_order.php */