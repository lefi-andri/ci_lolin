<div class="card">
  <div class="card-header text-white bg-secondary">
    Halaman ini digunakan untuk mengelola foto event
  </div>
  <div class="card-body">
    <div align="right">
      <?php echo anchor($this->session->userdata('lolin_urlback_backend'), '<i class="fa fa-refresh"></i> Refresh Data', array('class' => 'btn btn-default btn-sm' )); ?>
      <?php echo anchor('admin/event', '<span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span> Kembali ke list event', ['class' => 'btn btn-warning btn-sm']); ?>
      <?php echo anchor("admin/event/picture/add/files/$eventsId",'<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambahkan Gambar', array('title'=>'' , 'class'=>'btn btn-dark btn-sm')); ?>
    </div>

    <?php echo $table; ?>
  </div>
</div>