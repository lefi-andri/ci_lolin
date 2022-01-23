<div class="card">
  <div class="card-header text-white bg-secondary">
    Halaman ini digunakan untuk menampilkan pertanyaan dari website
  </div>
  <div class="card-body">
    <div align="right">
      <?php echo anchor($this->session->userdata('lolin_urlback_backend'), '<i class="fa fa-refresh"></i> Refresh Data', array('class' => 'btn btn-default btn-sm' )); ?>
    </div>

    <?php echo $table; ?>
  </div>
</div>