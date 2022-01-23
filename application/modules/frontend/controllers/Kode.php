<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kode extends CI_Controller {

	public function index()
	{
		/*

		# KODE LAMA

		date_default_timezone_set('Asia/Jakarta');
        $today = date("dmY");
        $sql = "SELECT MAX(reseller_id) AS maxCode FROM meta";
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

        $reseller_id = $ekstensi.'-'.$today."-".sprintf("%04s", $noUrut);
        return $reseller_id;

        */
        
      	# -----------------------------------------------------------------------------------------------

        /*$object = array(
        	'nomor_kode' => $id_invoice,
        );

        $this->db->insert('kode', $object);

        if ($this->db->affected_rows() > 0) {
        	echo "berhasil";
        }else{
        	echo "gagal";
        }*/

        # KODE BARU
        # ------------------------------------------------------------------------------------------------------------------------
        #  KODE PURCHASE ORDER

        /*
        date_default_timezone_set('Asia/Jakarta');

        $today = date("dmY");
        $sql = "SELECT MAX(order_id) AS max_code FROM purchase_order";
        $query = $this->db->query($sql);

        $maximal_id =  $query->row()->max_code;

        # mencari id terbesar

        $get_val = $this->db->get_where('purchase_order', array('order_id' => $maximal_id));

        if ($get_val->num_rows() > 0) {

        	$date_id = (int) substr($get_val->row()->order_code, 3, 8);

	        if ($date_id == $today) {
	            $no_urut = (int) substr($get_val->row()->order_code, 13, 10);
	            $no_urut++;
	        }else{
	            $no_urut=0;
	            $no_urut++;
	        }

	      	$id_invoice = "PO-".$today."-".sprintf("%04s", $no_urut); // PO : Purchase Order
        	
        }else{

        	$no_urut=1;
        	$id_invoice = "PO-".$today."-".sprintf("%04s", $no_urut); // PO : Purchase Order

        }

        echo $id_invoice;*/


        # ------------------------------------------------------------------------------------------------------------------------
        #  KODE RESELLER
        /*
        $tipe = 'reseller_pribadi';

        date_default_timezone_set('Asia/Jakarta');

        $today = date("dmY");
        $sql = "SELECT MAX(id) AS max_code FROM meta";
        $query = $this->db->query($sql);

        $maximal_id =  $query->row()->max_code;

        # mencari id terbesar

        $get_val = $this->db->get_where('meta', array('id' => $maximal_id));

        if ($get_val->num_rows() > 0) {

            $date_id = (int) substr($get_val->row()->reseller_id, 3, 8);

            $date_id = (int) substr($get_val->row()->reseller_id, 4, 10);
	        if ($date_id == $today) {
	            $no_urut = (int) substr($get_val->row()->reseller_id, 13, 10);
	            $no_urut++;
	        }else{
	            $no_urut=0;
	            $no_urut++;
	        }


            if ($tipe == 'reseller_pribadi') {
                $ekstensi = 'RSP';
            } elseif($tipe == 'reseller_organisasi'){
                $ekstensi = 'RSO';
            }

            $reseller_id = $ekstensi.'-'.$today."-".sprintf("%04s", $no_urut);
            
        }else{

            $no_urut=1;
            $reseller_id = $ekstensi.'-'.$today."-".sprintf("%04s", $no_urut);

        }

        echo $reseller_id;
        */

        # ------------------------------------------------------------------------------------------------------------------------
        #  KODE TEMPORARY ORDER

        /*
		date_default_timezone_set('Asia/Jakarta');

        $today = date("dmY");
        $sql = "SELECT MAX(id_temporary) AS max_code FROM temporary_purchase_order";
        $query = $this->db->query($sql);

        $maximal_id =  $query->row()->max_code;

        # mencari id terbesar

        $get_val = $this->db->get_where('temporary_purchase_order', array('id_temporary' => $maximal_id));

        if ($get_val->num_rows() > 0) {

            $date_id = (int) substr($get_val->row()->kode_temporary, 4, 10);

	        if ($date_id == $today) {
	            $no_urut = (int) substr($get_val->row()->kode_temporary, 13, 10);
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

        echo $kode_temporary;
        */

        # ------------------------------------------------------------------------------------------------------------------------
        #  KODE TUKAR POIN

        /*
        date_default_timezone_set('Asia/Jakarta');
        $today = date("dmY");
        $sql = "SELECT MAX(kode_tukar_poin) AS maxCode FROM tukar_poin";
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
            $ekstensi = 'TPP'; //TPP Tukar Poin Pribadi
        } elseif($tipe == 'reseller_organisasi'){
            $ekstensi = 'TPO'; //TPO Tukar Poin Organisasi
        }

        $kode_tukar_poin = $ekstensi.'-'.$today."-".sprintf("%04s", $noUrut);
        return $kode_tukar_poin;
        */

        $tipe = 'reseller_pribadi';

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

            $date_id = (int) substr($get_val->row()->kode_tukar_poin, 3, 8);

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

        echo $kode_tukar_poin;

	}

}

/* End of file Kode.php */
/* Location: ./application/modules/frontend/controllers/Kode.php */