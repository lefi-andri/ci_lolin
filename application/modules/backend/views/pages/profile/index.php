<div class="card">
  <div class="card-header text-white bg-secondary">
    Halaman ini digunakan untuk mengelola profile admin
  </div>
  <div class="card-body">
    <form>
    <div class="form-group">
      <label for="">Nama Depan</label>
      <input type="text" class="form-control" id="" value="<?php echo $user->nama_lengkap; ?>" disabled="disabled">
    </div>
    <div class="form-group">
      <label for="">Email</label>
      <input type="text" class="form-control" id="" value="<?php echo $user->email; ?>" disabled="disabled">
    </div>
    <div class="form-group">
      <?php echo anchor('url', 'Perbarui Akun', array('class' => 'btn btn-primary btn-sm')); ?>
    </div>
  </form>

  </div>
</div>