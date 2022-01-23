<!-- Page Content-->
<div class="container padding-bottom-3x mb-2">
<?php $this->load->view('include/template/message'); ?>
  <div class="row">
    <div class="col-lg-4">
      <?php echo $user_info_menu; ?>
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