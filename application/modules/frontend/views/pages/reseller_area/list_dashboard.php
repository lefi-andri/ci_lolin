<?php  
$id = "51";
$this->db->select('*');
        $this->db->from('purchase_order');
        $this->db->join('users', 'users.id = purchase_order.reseller_id');
        $this->db->where('purchase_order.reseller_id', $id);
        $this->db->group_by('purchase_order.order_code');
        $data_rekaman = $this->db->get();

        $total_semua_poin = "";
        foreach ($data_rekaman->result() as $key_purchase_order => $value_purchase_order) {

          #echo $value_purchase_order->experied_poin_period."<br>";

            // Cek masa kedaluwarsa
            date_default_timezone_get('Asia/Jakarta');
            $tanggal_kedaluwarsa = $value_purchase_order->experied_poin_period;//kedaluwarsa
            $tanggal_saat_ini = date('Y-m-d');//sekarang
            $tanggal_kedaluwarsa_split = explode("-", $tanggal_kedaluwarsa);
            $tanggal_saat_ini_split =  explode("-", $tanggal_saat_ini);
            $date1 =  mktime(0, 0, 0, $tanggal_kedaluwarsa_split[1],$tanggal_kedaluwarsa_split[2],$tanggal_kedaluwarsa_split[0]);
            $date2 =  mktime(0, 0, 0, $tanggal_saat_ini_split[1],$tanggal_saat_ini_split[2],$tanggal_saat_ini_split[0]);
            $interval_waktu_kedaluwarsa =($date2 - $date1)/(3600*24);

            #echo $interval_waktu_kedaluwarsa.'<br>';

            

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

        //echo $total_semua_poin;
?>



<!-- Page Content-->
<div class="container padding-bottom-3x mb-2">
<?php $this->load->view('include/template/message'); ?>
  <div class="row">
    <div class="col-lg-4">
      <?php $this->load->view('reseller_area/user_info_menu'); ?>
    </div>
    <div class="col-lg-8">
      <div class="padding-top-2x mt-2 hidden-lg-up"></div>


      <div class="col-md-12">
          <h3>Dashboard</h3>
          <div class="row">

            <div class="col-lg-4 margin-bottom-1x">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Profile</h4>
                  <p class="card-text">Informasi mengenai data diri reseller, informasi akun dan informasi rekening.</p>
                  <a class="btn btn-outline-primary btn-sm" href="<?php echo base_url('reseller/profile'); ?>">Edit</a>
                </div>
              </div>
            </div>
            
            <div class="col-lg-4 margin-bottom-1x">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Jumlah Order</h4>
                  <p class="card-text">Menghitung berapa kali reseller melakukan order.</p>
                  <a class="btn btn-primary btn-sm" href="<?php echo base_url('reseller/dashboard'); ?>"><?php echo $banyak_order_reseller; ?> Order</a>
                </div>
              </div>
            </div>

            <div class="col-lg-4 margin-bottom-1x">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">History Order</h4>
                  <p class="card-text">Rekaman reseller selama melakukan order.</p>
                  <a class="btn btn-outline-primary btn-sm" href="<?php echo base_url('reseller/order/rekaman'); ?>">Lihat</a>
                </div>
              </div>
            </div>

            <div class="col-lg-4 margin-bottom-1x">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">List Order Pending</h4>
                  <p class="card-text">Order reseller yang bersatus belum dikonfirmasi oleh admin.</p>
                  <a class="btn btn-outline-primary btn-sm" href="<?php echo base_url('reseller/order/pending'); ?>">Lihat</a>
                </div>
              </div>
            </div>

            <div class="col-lg-4 margin-bottom-1x">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Penukaran Poin</h4>
                  <p class="card-text">Hadiah yang dapat ditukar dengan poin yang diperoleh reseller.</p>
                  <a class="btn btn-outline-primary btn-sm" href="<?php echo base_url('reseller/penukaran_poin'); ?>">Lihat</a>
                </div>
              </div>
            </div>

            <div class="col-lg-4 margin-bottom-1x">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Poin</h4>
                  <p class="card-text">Jumlah poin yang anda dapatkan selama melakukan order.</p>
                  <a class="btn btn-primary btn-sm" href="<?php echo base_url('reseller/dashboard'); ?>"><?php echo $poin_saat_ini; ?> points</a>
                </div>
              </div>
            </div>

            <div class="col-lg-4 margin-bottom-1x">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Batas Penukaran Poin</h4>
                  <p class="card-text">Batas akhir penukaran poin untuk ditukar adalah 12 bulan dimulai sejak tanggal anda order.</p>
                </div>
              </div>
            </div>

            <div class="col-lg-4 margin-bottom-1x">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">History Penukaran Poin</h4>
                  <p class="card-text">Rekaman reseller selama melakukan penukaran poin.</p>
                  <a class="btn btn-outline-primary btn-sm" href="<?php echo base_url('reseller/penukaran_poin/rekaman'); ?>">Lihat</a>
                </div>
              </div>
            </div>

          </div>
          
      </div>

    </div>
  </div>
</div>