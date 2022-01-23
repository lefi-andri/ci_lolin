<div class="card">
  <div class="card-header text-white bg-secondary">
    Halaman ini digunakan untuk mengelola blog
  </div>
  <div class="card-body">
    <div align="right">
      <?php echo anchor($this->session->userdata('lolin_urlback_backend'), '<i class="fa fa-refresh"></i> Refresh Data', array('class' => 'btn btn-default btn-sm' )); ?>
      <?php echo anchor('backend/blog/add', '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah Blog', array('class' => 'btn btn-dark btn-sm' )); ?>
    </div>

    <?php echo $table; ?>
  </div>
</div>