<div class="card">
  <div class="card-header text-white bg-secondary">
    Halaman ini digunakan untuk mengelola testimoni
  </div>
  <div class="card-body">
    <div align="right">
      <?php echo anchor($this->session->userdata('lolin_urlback_backend'), '<i class="fa fa-refresh"></i> Refresh Data', array('class' => 'btn btn-default btn-sm' )); ?>
      <?php echo anchor('backend/testimoni/add', '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah Testimoni', array('class' => 'btn btn-primary btn-sm' )); ?>
    </div>

    <?php echo $table; ?>
  </div>
</div>