<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kode_model extends CI_Model {

	# INI UNTUK BUAT KODE ID RESELLER
	public function create_reseller_code($tipe){
		date_default_timezone_set('Asia/Jakarta');
        $today = date("dmY");
        $sql = "SELECT MAX(id_reseller) AS maxCode FROM users";
        $query = $this->db->query($sql);        
        $date_id = (int) substr($query->row()->maxCode, 4, 10);
        if ($date_id == $today) {
            $noUrut = (int) substr($query->row()->maxCode, 13, 10);
            $noUrut++;
        }else{
            $noUrut=0;
            $noUrut++;
        }

        if ($tipe == 'reseller_pribadi') {
            $ekstensi = 'RSP';
        } elseif($tipe == 'reseller_organisasi'){
            $ekstensi = 'RSO';
        }

        $id_reseller = $ekstensi.'-'.$today."-".sprintf("%04s", $noUrut);
        return $id_reseller;
	}

    # BUAT KODE NOMOR INVOICE
    function create_invoice_order_code(){
        $today = date("dmY");
        $sql = "SELECT MAX(orderCode) AS maxCode FROM orders";
        $query = $this->db->query($sql);        
        $date_id = (int) substr($query->row()->maxCode, 3, 8);
        if ($date_id == $today) {
            $noUrut = (int) substr($query->row()->maxCode, 13, 10);
            $noUrut++;
        }else{
            $noUrut=0;
            $noUrut++;
        }
        $id_invoice_otomatis = "PM/".$today."/".sprintf("%04s", $noUrut); // PM : Pembelian Member

        return $id_invoice_otomatis;
    }

}

/* End of file Kode_model.php */
/* Location: ./application/modules/backend/models/Kode_model.php */