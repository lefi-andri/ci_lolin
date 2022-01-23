<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reseller_Controller extends MX_Controller {

	public function __construct()
	{
		parent::__construct();

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

	public function ambil_data_reseller($id){
	    $this->db->select('*');
	    $this->db->from('users_groups');
	    $this->db->join('users', 'users.id = users_groups.user_id');
	    $this->db->join('groups', 'groups.id = users_groups.group_id');
	    $this->db->where('users.id', $id);
	    $data_reseller = $this->db->get()->row();
	    return $data_reseller;
	}

	public function hitung_total_poin($id){

		$user = $this->ion_auth->get_user();

		$this->db->select('*');
		$this->db->from('purchase_order');
		$this->db->join('users', 'users.id = purchase_order.reseller_id');
		#$this->db->join('users_groups', 'users_groups.user_id = users.id');
		$this->db->where('purchase_order.reseller_id', $user->id);
		$this->db->group_by('purchase_order.order_code');
		$data_rekaman = $this->db->get();

		#return $data_rekaman;

		$total_semua_poin = "";
		foreach ($data_rekaman->result() as $key_purchase_order => $value_purchase_order) {

			// Cek masa kedaluwarsa
            date_default_timezone_get('Asia/Jakarta');
            $tanggal_kedaluwarsa = $value_purchase_order->experied_poin_period;//kedaluwarsa
            $tanggal_saat_ini = date('Y-m-d');//sekarang
            $tanggal_kedaluwarsa_split = explode("-", $tanggal_kedaluwarsa);
            $tanggal_saat_ini_split =  explode("-", $tanggal_saat_ini);
            $date1 =  mktime(0, 0, 0, $tanggal_kedaluwarsa_split[1],$tanggal_kedaluwarsa_split[2],$tanggal_kedaluwarsa_split[0]);
            $date2 =  mktime(0, 0, 0, $tanggal_saat_ini_split[1],$tanggal_saat_ini_split[2],$tanggal_saat_ini_split[0]);
            $interval_waktu_kedaluwarsa =($date2 - $date1)/(3600*24);

            // Jika sekarang kurang dari waktu experied maka akan diproses
            if ($interval_waktu_kedaluwarsa < 0) {
            	$data_kode_order = $this->db->get_where('purchase_order', array('order_code'=>$value_purchase_order->order_code));

				$total_poin = "";
				foreach ($data_kode_order->result() as $key_produk_order => $value_produk_order) {
					$this->db->select('*');
					$this->db->where(array('order_code'=>$value_produk_order->order_code,'produk_id'=>$value_produk_order->produk_id));
					$this->db->group_by('order_code');
					$data_produk_order = $this->db->get('purchase_order');

					foreach ($data_produk_order->result() as $key_produk => $value_produk) {
						$data_produk = $this->db->get_where('product', array('prodsId'=>$value_produk->produk_id))->row();
			
						# AMBIL NILAI POIN
						$this->db->select('*');
						$this->db->from('product');
						$this->db->join('poin', 'poin.prodsId = product.prodsId');
						$this->db->join('groups', 'groups.id = poin.group_id');
						$this->db->where('product.prodsId', $data_produk->prodsId);
						$this->db->where('groups.id', $value_purchase_order->group_id);
						$poin_grup = $this->db->get()->row();

						$quantity = $this->db->get_where('purchase_order', array('produk_id'=>$value_produk->produk_id, 'order_code'=>$value_purchase_order->order_code))->row();
						
						$get_diskon_harga = $this->db->get_where('diskon_harga', array('diskon_id'=>$quantity->order_quantity))->row();

	                    $hitung_poin = $poin_grup->poinNilai * $get_diskon_harga->jumlah_unit;
					}
					if ($data_kode_order->num_rows() > 0) {
			        	$this_tukar_total = 0;
				        foreach ($data_kode_order->result() as $data_tukar) {
				        	$this_tukar_total += $data_tukar->order_quantity;
				        }
			        } else {
			        	$this_tukar_total = 0;
			        }

			        # AMBIL TOTAL POIN
			        $total_poin += $hitung_poin;
				}
				$total_semua_poin += $total_poin;
            }
            
			
		}

		return $total_semua_poin;

	}

	public function hitung_tukar_poin($id){
		$this->db->select('*');
		$this->db->from('tukar_poin');
		$this->db->join('bonus_poin', 'bonus_poin.bonus_poin_id = tukar_poin.bonus_poin_id');
		$this->db->join('users', 'users.id = tukar_poin.reseller_id');
		$this->db->where('tukar_poin.reseller_id', $id);
		$this->db->where('tukar_poin.acc_tukar_poin', 1);
		$data_penukaran = $this->db->get();
		$jumlah_tukar = "";
		foreach ($data_penukaran->result() as $key => $value) {
			$jumlah_tukar += $value->poin_bonus;
		}
		return $jumlah_tukar;
	}

	public function cek_poin_saat_ini($id1, $id2){
		return $hasil = $id1 - $id2;
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

	function data_purchase_order_reseller($id){
		$this->db->select('*');
		$this->db->from('purchase_order');
		$this->db->join('users', 'users.id = purchase_order.reseller_id');
		$this->db->where('users.id', $id);
		$this->db->group_by('purchase_order.order_code');
		$this->db->order_by('purchase_order.order_code', 'desc');
		$data_purchase_order = $this->db->get();

		return $data_purchase_order;
	}

	function banyak_order_reseller($id){
		$this->db->select('*');
		$this->db->from('purchase_order');
		$this->db->join('users', 'users.id = purchase_order.reseller_id');
		$this->db->where('users.id', $id);
		$this->db->group_by('purchase_order.order_code');
		$jumlah_purchase_order = $this->db->get()->num_rows();

		return $jumlah_purchase_order;
	}

	function cari_rekaman_order_reseller($id){
    	$this->db->select('*');
		$this->db->from('purchase_order');
		$this->db->join('users', 'users.id = purchase_order.reseller_id');
		$this->db->join('meta', 'meta.user_id = users.id');
		#$this->db->join('users_groups', 'users_groups.user_id = users.id');
		$this->db->where('purchase_order.reseller_id', $id);
		$this->db->group_by('purchase_order.order_code');
		$this->db->order_by('purchase_order.order_code', 'desc');
		$query = $this->db->get();
		return $query;
    }

    function cari_penukaran_poin_reseller($id){
    	$this->db->select('*');
		$this->db->from('tukar_poin');
		$this->db->join('users', 'users.id = tukar_poin.reseller_id');
		$this->db->join('users_groups', 'users_groups.user_id = users.id');
		$this->db->join('groups', 'groups.id = users_groups.group_id');
		$this->db->join('bonus_poin', 'bonus_poin.bonus_poin_id = tukar_poin.bonus_poin_id');
		$this->db->where('tukar_poin.reseller_id', $id);
		$query = $this->db->get();
		return $query;
    }

    function cari_rekaman_belum_dikonfirmasi($id){
    	$this->db->select('*');
		$this->db->from('temporary_purchase_order');
		$this->db->where('reseller_id', $id);
		$this->db->group_by('kode_temporary');
		$this->db->order_by('id_temporary', 'desc');
		$query = $this->db->get();
		return $query;
    }

    public function buat_kode_temporary_order(){
        /*date_default_timezone_set('Asia/Jakarta');
        $today = date("dmY");
        $sql = "SELECT MAX(kode_temporary) AS maxCode FROM temporary_purchase_order";
        $query = $this->db->query($sql);        
        $date_id = (int) substr($query->row()->maxCode, 4, 10);
        if ($date_id == $today) {
            $noUrut = (int) substr($query->row()->maxCode, 13, 10);
            $noUrut++;
        }else{
            $noUrut=0;
            $noUrut++;
        }

        $kode_temporary = 'TMP-'.$today."-".sprintf("%04s", $noUrut);
        return $kode_temporary;*/

        $this->db->select('MAX(id_temporary) AS max_code');
        $this->db->from('temporary_purchase_order');
        $query = $this->db->get()->row();

        # maximal_id adalah id paling akhir
        $maximal_id =  $query->max_code;

        # mencari id terbesar
        $this->db->select('kode_temporary');
        $this->db->select('SUBSTRING(kode_temporary, 1, 3) AS kode_depan');
        $this->db->select('SUBSTRING(kode_temporary, 5, 8) AS tanggal_dari_data_terakhir');
        $this->db->select('SUBSTRING(kode_temporary, 14, 4) AS nomor_urut_dari_data_terakhir');
        $this->db->from('temporary_purchase_order');
        $this->db->where('id_temporary', $maximal_id);
        $this->db->group_by('kode_temporary');
        $get_val = $this->db->get();

        date_default_timezone_set('Asia/Jakarta');
        $today = date("dmY"); // Tanpa pemisah

        if ($get_val->num_rows() > 0) {

        	$kode_temporary = $get_val->row()->kode_temporary;
	        $kode_depan = $get_val->row()->kode_depan;
	        $tanggal_dari_data_terakhir = $get_val->row()->tanggal_dari_data_terakhir;
	        $nomor_urut_dari_data_terakhir = $get_val->row()->nomor_urut_dari_data_terakhir;

            if ($today == $tanggal_dari_data_terakhir) {
                $no_urut = $nomor_urut_dari_data_terakhir;
                $no_urut++;
            }else{
                $no_urut=0;
                $no_urut++;
            }

            $kode_temporary = 'TMP-'.$today."-".sprintf("%04s", $no_urut);
            
        }else{

            $no_urut=1;
            $kode_temporary = 'TMP-'.$today."-".sprintf("%04s", $no_urut);

        }
        return $kode_temporary;

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
        $html_konten .= $this->$email_template($email_konten);

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

    # UNTUK EMAIL ORDER
    function template_email_order($email_konten){
        $html_konten = $email_konten;
        return $html_konten;
    }
    # UNTUK INFO EMAIL ORDER
    function template_email_order_info($email_konten){
        $html_konten = $email_konten;
        return $html_konten;
    }

    # INI UNTUK BUAT KODE ID TUKAR POIN
    public function create_tukar_poin_code($tipe){

        if ($tipe == 'reseller_pribadi') {
            $ekstensi = 'TPP'; //TPP Tukar Poin Pribadi
        } elseif($tipe == 'reseller_organisasi'){
            $ekstensi = 'TPO'; //TPO Tukar Poin Organisasi
        }

        date_default_timezone_set('Asia/Jakarta');

        $today = date("dmY");
        $sql = "SELECT MAX(tukar_poin_id) AS max_code FROM tukar_poin";
        $query = $this->db->query($sql);

        $maximal_id =  $query->row()->max_code;

        # mencari id terbesar

        $get_val = $this->db->get_where('tukar_poin', array('tukar_poin_id' => $maximal_id));

        if ($get_val->num_rows() > 0) {

            #$date_id = (int) substr($get_val->row()->kode_tukar_poin, 3, 8);

            $date_id = (int) substr($get_val->row()->kode_tukar_poin, 4, 10);
            
            if ($date_id == $today) {
                $no_urut = (int) substr($get_val->row()->kode_tukar_poin, 13, 10);
                $no_urut++;
            }else{
                $no_urut=0;
                $no_urut++;
            }

            $kode_tukar_poin = $ekstensi.'-'.$today."-".sprintf("%04s", $no_urut);
            
        }else{

            $no_urut=1;
            $kode_tukar_poin = $ekstensi.'-'.$today."-".sprintf("%04s", $no_urut);

        }

        return $kode_tukar_poin;
    }

}

/* End of file Reseller_Controller.php */
/* Location: ./application/core/Reseller_Controller.php */