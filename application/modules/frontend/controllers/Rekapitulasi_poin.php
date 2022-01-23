<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekapitulasi_poin extends Reseller_Controller {

	public function __construct()
	{
		parent::__construct();

		if (!$this->ion_auth->logged_in())
        {
        	$this->session->set_flashdata('message_warning', 'Anda harus login sebagai reseller.');
            redirect('reseller','refresh');
        }
		
		$this->load->model('rekapitulasi_poin_model', 'models');
	}

	public function index()
	{
		$this->load->helper('indonesiandate');

		#$url = $this->uri->uri_string();
		#$this->session->set_userdata('lolin_urlback_frontend', $url);

		$this->load->library('breadcrumb');
		$this->breadcrumb->add('reseller', 'reseller');
		$this->breadcrumb->add('rekapitulasi poin', 'reseller/order');

		$id_reseller = $this->session->userdata('user_id');

		$total_poin = reseller_controller::hitung_total_poin($id_reseller);
		$total_tukar_poin = reseller_controller::hitung_tukar_poin($id_reseller);

		$meta = reseller_controller::get_meta(2);


		$this->load->library('table');

		$this->table->set_heading('No.', 'Transaksi', 'Debit', 'Kredit', 'Saldo', 'Keterangan', 'Tanggal Rekap');

		$this->db->select('*');
		$this->db->from('log_transaksi');
		$this->db->join('tipe_transaksi', 'tipe_transaksi.id = log_transaksi.tipe_transaksi_id');
		$this->db->order_by('log_transaksi.tanggal_log', 'desc');
		$query = $this->db->get();



		$no = 1;
		foreach ($query->result() as $value) {

			list($tanggal, $waktu) = explode(' ', $value->tanggal_log);

			// Mencari Nilai Debit dan Experied Poin
			if($value->tipe_transaksi_id == 1){
				$this->db->select('*');
				$this->db->from('purchase_order');
				$this->db->where('purchase_order.order_code', $value->related_id);
				$this->db->group_by('purchase_order.order_code');
				$hasil_cari = $this->db->get()->row();
				$nilai_debit = $hasil_cari->experied_poin_period;
			}else{
				$nilai_debit = '0';
			}

			// General
			$this->db->select('*');
			$this->db->from('purchase_order');
			$this->db->where('purchase_order.order_code', $value->related_id);
			$this->db->group_by('purchase_order.order_code');
			$general = $this->db->get()->row();

			// Cari Jenis Grup Reseller
			$this->db->select('groups.id');
			$this->db->from('users');
			$this->db->join('groups', 'groups.id = users.group_id');
			$this->db->where('users.id', $general->reseller_id);
			$grup_reseller = $this->db->get()->row();
			$id_grup_reseller_order = $grup_reseller->id; //berisi id grup

			// Cari Nilai Poin
			$this->db->select('*');
			$this->db->from('purchase_order');
			$this->db->where('purchase_order.order_code', $value->related_id);
			$hasil_cari = $this->db->get();

			$num_jumil = 0;
			foreach ($hasil_cari->result() as $value_nilai) {

				// cari jumlah produk yg di order
				$jumorder = $this->db->get_where('diskon_harga', array('diskon_id'=>$value_nilai->diskon_id))->row()->jumlah_unit;



				// Cek masa kedaluwarsa
				date_default_timezone_get('Asia/Jakarta');
				$tanggal_kedaluwarsa = $value_nilai->experied_poin_period;//kedaluwarsa
				$tanggal_saat_ini = date('Y-m-d');//sekarang
				$tanggal_kedaluwarsa_split = explode("-", $tanggal_kedaluwarsa);
				$tanggal_saat_ini_split =  explode("-", $tanggal_saat_ini);
				$date1 =  mktime(0, 0, 0, $tanggal_kedaluwarsa_split[1],$tanggal_kedaluwarsa_split[2],$tanggal_kedaluwarsa_split[0]);
				$date2 =  mktime(0, 0, 0, $tanggal_saat_ini_split[1],$tanggal_saat_ini_split[2],$tanggal_saat_ini_split[0]);
				$interval_waktu_kedaluwarsa =($date2 - $date1)/(3600*24);

				// Jika sekarang kurang dari waktu experied maka akan diproses
				if ($interval_waktu_kedaluwarsa < 0) {
					// cari poin nilai per produk
					$this->db->select('poin.poinNilai');
					$this->db->from('product');
					$this->db->join('poin', 'poin.prodsId = product.prodsId');
					$this->db->where('product.prodsId', $value_nilai->produk_id);
					$this->db->where('poin.group_id', $id_grup_reseller_order);
					$jumil = $this->db->get()->row();

					$jumil_nilai = $jumil->poinNilai * $jumorder;

					$num_jumil += $jumil_nilai;
				}

				
			}

			$status_jumil = ($num_jumil == 0)? 'experied':$num_jumil.' poin';

			$debit = $general->order_code.' --- '.$status_jumil.' --- '.indonesian_date($nilai_debit);

			$this->table->add_row(
				$no,
				$value->alias,
				$debit,
				'',
				'',
				'',
				indonesian_date($tanggal).' --- '.$waktu
			);

			$no++;
		}
		
		$template = array(
		        'table_open'            => '<table class="table table-bordered">',

		        'thead_open'            => '<thead>',
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

		$this->table->set_template($template);


		
		$data = array(
            'title' 				=> $meta->judul,
            'description'			=> $meta->deskripsi_seo,
            'keyword'				=> $meta->keyword_seo,

            'label'					=> 'Rekapitulasi Poin',            
            'main_view'				=> 'rekapitulasi_poin/list_rekapitulasi',
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

}

/* End of file Rekapitulasi_poin.php */
/* Location: ./application/modules/frontend/controllers/Rekapitulasi_poin.php */