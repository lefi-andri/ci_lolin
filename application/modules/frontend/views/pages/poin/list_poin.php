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
          <h3>Poin</h3>
          <div class="alert alert-primary alert-dismissible fade show text-center margin-bottom-1x">
              <i class="fa fa-dollar"></i></i> Poin aktif anda saat ini adalah <?php echo $poin_saat_ini; ?>
            </div>
          <div class="row">
            
          </div>
          <h3>Rekapitulasi Poin</h3>
          <div class="row">
          	<?php echo $table; ?>
          </div>
      </div>

    </div>
  </div>
</div>