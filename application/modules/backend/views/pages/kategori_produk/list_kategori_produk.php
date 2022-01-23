<div class="card">
  <div class="card-header text-white bg-secondary">
    Halaman ini digunakan untuk mengelola kategori produk
  </div>
  <div class="card-body">
    <div align="right">
      <?php echo anchor($this->session->userdata('lolin_urlback_backend'), '<i class="fa fa-refresh"></i> Refresh Data', array('class' => 'btn btn-default btn-sm' )); ?>
      <?php echo anchor('admin/product/kategori/add', '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah Kategori Produk', array('class' => 'btn btn-primary btn-sm' )); ?>
    </div>

    <table id="kategori_produk" class="table table-hover">
      <thead>
        <tr>
          <th>No.</th>
          <th>Gambar Navbar Kategori</th>
          <th>Nama Kategori</th>              
          <th>Pengurutan Kategori</th>
          <th>Kategori Ditampilkan</th>
          <th></th>
        </tr>
      </thead>
    </table>
  </div>
</div>