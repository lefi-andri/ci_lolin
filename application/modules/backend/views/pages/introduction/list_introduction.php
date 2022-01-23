<div class="card">
  <div class="card-header text-white bg-secondary">
     Halaman ini digunakan untuk mengelola introduction
  </div>
  <div class="card-body">
    <div align="right">
      <?php echo anchor($this->session->userdata('lolin_urlback_backend'), '<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Refresh Data', array('class' => 'btn btn-primary btn-sm' )); ?>
      <?php #echo anchor('backend/introduction/add', '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah Introduction', array('class' => 'btn btn-dark btn-sm' )); ?>
    </div>

    <?php echo $table; ?>
  </div>
</div>