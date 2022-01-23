<!-- Page Content-->
<div class="container padding-bottom-3x mb-2">
<?php $this->load->view('include/template/message'); ?>
  <div class="row">
    <div class="col-lg-4">
      <?php echo $user_info_menu; ?>
    </div>
    <div class="col-lg-8">
      <div class="padding-top-2x mt-2 hidden-lg-up"></div>
      <h3>Ordered</h3>
      <?php echo $table_sudah_dikonfirmasi; ?>
      
      <br><hr><br>
      
      <h3>Pending</h3>
      <?php echo $table_belum_dikonfirmasi; ?>

        <!--h3>Order</h3>
        <p>Anda dapat melakukan order, silahkan lengkapi form berikut ini.</p>

        <div class="card bg-secondary text-center mb-3">
          <div class="card-header text-lg">Pilih Produk dan Quantity</div>
          <div class="card-body">

          </div>
        </div-->
        
    </div>
  </div>
</div>