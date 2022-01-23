<div class="card">
  <div class="card-header text-white bg-secondary">
    Halaman ini digunakan untuk mengelola kategori blog
  </div>
  <div class="card-body">
    <div align="right">
      <?php echo anchor($this->session->userdata('lolin_urlback_backend'), '<i class="fa fa-refresh"></i> Refresh Data', array('class' => 'btn btn-default btn-sm' )); ?>
      <?php echo anchor('backend/kategori_blog/add', '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah Kategori Blog', array('class' => 'btn btn-primary')); ?>
    </div>

    <?php echo $table; ?>

    <select class="form-control" name="kurir[]" id="kurir" required="required" multiple="multiple">
                    <option value="pos">POS</option>
                    <option value="jne">JNE</option>
                </select>
  </div>
</div>