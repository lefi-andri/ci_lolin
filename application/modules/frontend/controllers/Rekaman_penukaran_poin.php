<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekaman_penukaran_poin extends Reseller_Controller {

	public function __construct()
	{
		parent::__construct();

		if (!$this->ion_auth->logged_in())
        {
        	$this->session->set_flashdata('message_warning', 'Anda harus login sebagai reseller.');
            redirect('reseller','refresh');
        }
		
		$this->load->model('rekaman_penukaran_poin_model', 'models');
	}

	public function index()
	{
		$this->load->helper('indonesiandate');

		$this->load->library('breadcrumb');
		$this->breadcrumb->add('reseller', 'reseller');
		$this->breadcrumb->add('penukaran poin', 'reseller/penukaran_poin');
		$this->breadcrumb->add('history', 'reseller/penukaran_poin/rekaman');

		$id_reseller = $this->session->userdata('user_id');

		$this->load->library('table');

		$this->table->set_heading('No', 'Nama Bonus', 'Nilai Bonus', 'Poin Tukar', 'Tanggal Penukaran', 'Id Penukaran','Status');

		$data_penukaran_poin = $this->models->ambil_data_item_penukaran($id_reseller);

		$no = 1;
		foreach ($data_penukaran_poin->result() as $key => $value) {

			list($tanggal, $waktu) = explode(' ', $value->tanggal_tukar_poin);
			
			$this->table->add_row(
				$no, 
				$value->nama_jenis_bonus, 
				'Rp. '.number_format($value->nilai_bonus, 0, ".", "."), 
				$value->poin_bonus." point",
				indonesian_date($tanggal).' --- '.$waktu,
				$value->kode_tukar_poin,
				($value->acc_tukar_poin == 1) ? 'Disetujui' : 'Belum disetujui'
			);
			$no++;
		}

		reseller_controller::buat_tabel();

		$total_poin = reseller_controller::hitung_total_poin($id_reseller);
		$total_tukar_poin = reseller_controller::hitung_tukar_poin($id_reseller);

		$meta = reseller_controller::get_meta(2);
		
		$data = array(
            'title' 				=> "Hitory Penukaran Poin - Lolin Reseller or Distributor",
            'description'			=> $meta->deskripsi_seo,
            'keyword'				=> $meta->keyword_seo,
            
            'label'					=> 'History Penukaran Poin',            
            'main_view'				=> 'rekaman_penukaran_poin/list_rekaman_penukaran_poin',
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

}

/* End of file Rekaman_penukaran_poin.php */
/* Location: ./application/modules/frontend/controllers/Rekaman_penukaran_poin.php */