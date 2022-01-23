<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Core extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('core_model', 'model');
	}

	function buat_kode_reseller($tipe){
		return $this->model->create_reseller_code($tipe);
	}

	function buat_kode_order(){
		return $this->model->create_order_code();
	}

	function buat_kode_temporary_order(){
		return $this->model->create_temporary_order_code();
	}

	function buat_kode_tukar_poin($tipe){
		return $this->model->create_tukar_poin_code($tipe);
	}

	function buat_tabel(){
		$template = array(
	        'table_open'            => '<table id="datatable" class="table table-striped table-bordered">',

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

		return $this->table->set_template($template);
	}

	function buat_tabel_responsive(){
		$template = array(
	        'table_open'            => '<table id="datatable-responsive" class="table table-striped table-bordered">',

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

		return $this->table->set_template($template);
	}

	function ambil_tahun_sekarang(){
		$tahun_sekarang = $this->db->get('pengaturan')->row()->pengaturanTahun;
		return $tahun_sekarang;
	}

	function hitung_total_poin($id = NULL){
		return $this->model->hitung_total_poin($id);
	}

	function hitung_tukar_poin($id = NULL){
		return $this->model->hitung_tukar_poin($id);
	}

	function cek_poin_saat_ini($id1 = NULL, $id2 = NULL){
		return $this->model->cek_poin_saat_ini($id1, $id2);
	}

	# Fungsi penambahan 12 bulan
	function tambah_masa_poin($tanggal){
		date_default_timezone_get('Asia/Jakarta');
		$hasil = date('Y-m-d', strtotime('+12 month', strtotime($tanggal)));
		return $hasil;
	}

	# Fungsi cek tanggal kedaluwarsa poin
	function cek_selisih_tanggal_kedaluwarsa($tanggal_kedaluwarsa){
		date_default_timezone_get('Asia/Jakarta');
		$start_date = new DateTime(date('Y-m-d'));
		$end_date = new DateTime($tanggal_kedaluwarsa);
		$interval = $start_date->diff($end_date);
		$hasil = $interval->days;
		return $hasil;
	}

	function interval_days($CheckOut){
		date_default_timezone_get('Asia/Jakarta');
		$CheckIn = date('Y-m-d');

		$CheckInX = explode("-", $CheckIn);
		$CheckOutX =  explode("-", $CheckOut);
		$date1 =  mktime(0, 0, 0, $CheckInX[1],$CheckInX[2],$CheckInX[0]);
		$date2 =  mktime(0, 0, 0, $CheckOutX[1],$CheckOutX[2],$CheckOutX[0]);
		$interval =($date2 - $date1)/(3600*24);

		return  $interval ;
	}

	  public function get_pengaturan_email(){
	      $this->db->select('pengaturanEmail');
	      $query = $this->db->get('pengaturan')->row()->pengaturanEmail;

	      return $query;
	  }

	public function buat_email($email_to, $subjek, $email_konten, $email_template){

		$this->load->library('email');

        $ci = get_instance();        
        $config['protocol']     = "smtp";
        $config['smtp_host']    = email_host();
        $config['smtp_port']    = email_port();
        $config['smtp_user']    = email_username();
        $config['smtp_pass']    = email_password();
        $config['charset']      = "utf-8";
        $config['mailtype']     = "html";
        $config['newline']      = "\r\n";
        
        $html_konten = '';
        #$html_konten .= $this->$email_template($email_konten);
        $html_konten .= $email_konten;

        $ci->email->initialize($config);
        $ci->email->from(email_pengirim(), 'Lolin Kids Care Product');          
        $ci->email->to($email_to);
        $ci->email->subject($subjek);
        $ci->email->message($html_konten);

        if($this->email->send()){
			   return TRUE;
    		}else{
    			return FALSE;
    		}

    }

    public function create_table(){
		$template = array(
	        'table_open'            => '<table id="dt-opt" class="table table-lg table-hover">',

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

		return $this->table->set_template($template);
	}
}

/* End of file Core.php */
/* Location: ./application/core/Core.php */