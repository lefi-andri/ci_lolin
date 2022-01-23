<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member_Controller extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		/*$this->load->library('form_validation');		
		if($this->session->userdata('session_login_member') == FALSE)
		{
			$this->session->set_flashdata('message', 'Haii pengunjung. Silahkan masuk kedalam akun Lolin kamu dahulu !');
			redirect('member');
		}*/
		$this->load->helper('security');
				
		$this->load->library(array('ion_auth', 'cart'));

		$this->load->helper(array('url', 'form'));
		
		$this->load->library(array('form_validation'));
		$this->form_validation->CI =& $this;
	}

	public function get_meta($meta_id){
	    $query = $this->db->get_where('konten_halaman', array('id' => $meta_id))->row();
	    return $query;
	}

	public function banyak_order_reseller($id){
		$this->db->select('*');
		$this->db->from('purchase_order_reseller');
		$this->db->join('users', 'users.id = purchase_order_reseller.reseller_id');
		$this->db->where('users.id', $id);
		$this->db->where('purchase_order_reseller.status_konfirmasi', 1);
		$this->db->where('purchase_order_reseller.is_temporary_order', 0);
		$this->db->group_by('purchase_order_reseller.order_code_reseller');
		$jumlah_purchase_order = $this->db->get()->num_rows();

		return $jumlah_purchase_order;
	}

	public function poin_member(){
		$this->db->select('*');
		$this->db->from('purchase_order_reseller');
		$this->db->join('users', 'users.id = purchase_order_reseller.reseller_id');
		$this->db->where('purchase_order_reseller.reseller_id', $this->session->userdata('user_id'));
		$this->db->where('purchase_order_reseller.status_konfirmasi', 1);
		$this->db->where('purchase_order_reseller.is_temporary_order', 0);
		$query_get_purchase = $this->db->get();

		$poin_seluruh_purchase = '';
		foreach ($query_get_purchase->result() as $value_purchase) {

			// Cek masa kedaluwarsa
            date_default_timezone_get('Asia/Jakarta');

            $tanggal_purchase = $value_purchase->order_date_experied;//kedaluwarsa
            //get tanggal dan jam
            $get_tanggal_jam 			= explode(" ", $tanggal_purchase);
            $tanggal_kedaluwarsa 		= $get_tanggal_jam[0];
            $tanggal_saat_ini 			= date('Y-m-d');//sekarang
            $tanggal_kedaluwarsa_split 	= explode("-", $tanggal_kedaluwarsa);
            $tanggal_saat_ini_split 	= explode("-", $tanggal_saat_ini);
            $date1 						= mktime(0, 0, 0, $tanggal_kedaluwarsa_split[1],$tanggal_kedaluwarsa_split[2],$tanggal_kedaluwarsa_split[0]);
            $date2 						= mktime(0, 0, 0, $tanggal_saat_ini_split[1],$tanggal_saat_ini_split[2],$tanggal_saat_ini_split[0]);
            $interval_waktu_kedaluwarsa = ($date2 - $date1)/(3600*24);

			$get_poin_per_purchase = '';

			$unserialize_purchase_product = unserialize($value_purchase->produk_id);
			$unserialize_purchase_quantity = unserialize($value_purchase->quantity);
			$get_jumlah_pembelian_produk = count($unserialize_purchase_product);
			
			// Jika sekarang kurang dari waktu experied maka akan diproses
            if ($interval_waktu_kedaluwarsa < 0) {
	            for ($i = 0; $i < $get_jumlah_pembelian_produk ; $i++) {
					$get_poin = $this->db->get_where('poin', array('prodsId' => $unserialize_purchase_product[$i], 'group_id' => $this->session->userdata('group_id')))->row();
					$get_poin_per_purchase += ($get_poin->poinNilai * $unserialize_purchase_quantity[$i]);
				}
            }
			
			#echo $get_poin_per_purchase;
			$poin_seluruh_purchase += $get_poin_per_purchase;
			
		}
		
		$this->db->select('*');
		$this->db->from('tukar_poin');
		$this->db->join('bonus_poin', 'bonus_poin.bonus_poin_id = tukar_poin.bonus_poin_id');
		$this->db->join('users', 'users.id = tukar_poin.reseller_id');
		$this->db->where('tukar_poin.reseller_id', $this->session->userdata('user_id'));
		$this->db->where('tukar_poin.acc_tukar_poin', 1);
		$data_penukaran = $this->db->get();
		$jumlah_tukar = "";
		foreach ($data_penukaran->result() as $key => $value) {
			$jumlah_tukar += $value->poin_bonus;
		}

		$get_semua_poin = $poin_seluruh_purchase - $jumlah_tukar;

		return $get_semua_poin;
	}

	public function buat_tabel(){
		$template = array(
	        'table_open'            => '<table class="table">',

	        'thead_open'            => '<thead class="thead-default">',
	        'thead_close'           => '</thead>',

	        'heading_row_start'     => '<tr>',
	        'heading_row_end'       => '</tr>',
	        'heading_cell_start'    => '<th>',
	        'heading_cell_end'      => '</th>',

	        'tbody_open'            => '<tbody>',
	        'tbody_close'           => '</tbody>',

	        'row_start'             => '<tr>',
	        'row_end'               => '</tr>',
	        'cell_start'            => '<td>',
	        'cell_end'              => '</td>',

	        'row_alt_start'         => '<tr>',
	        'row_alt_end'           => '</tr>',
	        'cell_alt_start'        => '<td>',
	        'cell_alt_end'          => '</td>',

	        'table_close'           => '</table>'
		);

		return $this->table->set_template($template);
	}

}

/* End of file Member_Controller.php */
/* Location: ./application/core/Member_Controller.php */