<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Core_model extends CI_Model {

    // Kustomisasi kode : reseller, kode order, temporary order, tukar poin

	# INI UNTUK BUAT KODE ID RESELLER
	public function create_reseller_code($tipe){

        if ($tipe == 'reseller_pribadi') {
            $ekstensi = 'RSP';
        } elseif($tipe == 'reseller_organisasi'){
            $ekstensi = 'RSO';
        }

        $this->db->select('MAX(meta.id) AS max_code');
        $this->db->from('meta');
        $this->db->join('users', 'users.id = meta.user_id');
        $this->db->like('meta.reseller_id', $ekstensi);
        $this->db->where('users.group_id >', '2');
        $query = $this->db->get()->row();

        $maximal_id =  $query->max_code;

        # mencari id terbesar
        $this->db->select('reseller_id');
        $this->db->select('SUBSTRING(meta.reseller_id, 1, 3) AS kode_depan');
        $this->db->select('SUBSTRING(meta.reseller_id, 5, 8) AS tanggal_dari_data_terakhir');
        $this->db->select('SUBSTRING(meta.reseller_id, 14, 4) AS nomor_urut_dari_data_terakhir');
        $this->db->from('meta');
        $this->db->join('users', 'users.id = meta.user_id');
        $this->db->where('users.group_id >', '2');
        $this->db->where('users.id', $maximal_id);
        $get_val = $this->db->get();

        date_default_timezone_set('Asia/Jakarta');
        $today = date("dmY"); // Tanpa pemisah
        $id_reseller = $get_val->row()->reseller_id;
        $kode_depan = $get_val->row()->kode_depan;
        $tanggal_dari_data_terakhir = $get_val->row()->tanggal_dari_data_terakhir;
        $nomor_urut_dari_data_terakhir = $get_val->row()->nomor_urut_dari_data_terakhir;

        if ($get_val->num_rows() > 0) {

            #$tanggal_dari_data_terakhir = substr($id_reseller, 4, 8); //4 kosong dari depan, 8 nilai yang diambil
            #$nomor_urut_dari_data_terakhir = substr($id_reseller, 13, 4); // 13 kosong dari depan, 4 nilai yang diambil

            if (($today == $tanggal_dari_data_terakhir) && ($kode_depan == $ekstensi)) {
                $no_urut = $nomor_urut_dari_data_terakhir;
                $no_urut++;
            }else{
                $no_urut=0;
                $no_urut++;
            }

            $reseller_id = $ekstensi.'-'.$today."-".sprintf("%04s", $no_urut);
            
        }else{

            $no_urut=1;
            $reseller_id = $ekstensi.'-'.$today."-".sprintf("%04s", $no_urut);

        }

        return $reseller_id;
	}

    public function create_order_code(){
       
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

        return $id_invoice;
    }

    # INI UNTUK BUAT KODE ID TEMPORARY ORDER
    public function create_temporary_order_code(){

        /*date_default_timezone_set('Asia/Jakarta');

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
        $get_val = $this->db->get();

        date_default_timezone_set('Asia/Jakarta');
        $today = date("dmY"); // Tanpa pemisah
        $id_reseller = $get_val->row()->kode_temporary;
        $kode_depan = $get_val->row()->kode_depan;
        $tanggal_dari_data_terakhir = $get_val->row()->tanggal_dari_data_terakhir;
        $nomor_urut_dari_data_terakhir = $get_val->row()->nomor_urut_dari_data_terakhir;

        if ($get_val->num_rows() > 0) {

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

        return $kode_tukar_poin;
    }


    # AMBIL NILAI TOTAL POIN RESELLER ID->id(users)
    public function hitung_total_poin($id){

        $this->db->select('*');
        $this->db->from('purchase_order');
        $this->db->join('users', 'users.id = purchase_order.reseller_id');
        $this->db->where('purchase_order.reseller_id', $id);
        $this->db->group_by('purchase_order.order_code');
        $data_rekaman = $this->db->get();

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

            }//end interval_waktu_kedaluwarsa

            
        }

        return $total_semua_poin;
    }

    # HITUNG NILAI TUKAR POIN
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

    # JUMLAHKAN SEMUA POIN
    public function cek_poin_saat_ini($id1, $id2){
        return $hasil = $id1 - $id2;
    }


    

}

/* End of file Core_model.php */
/* Location: ./application/models/Core_model.php */