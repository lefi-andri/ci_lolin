<div class="card">
  <div class="card-header text-white bg-secondary">
    Halaman ini digunakan untuk mengelola produk
  </div>
  <div class="card-body">
    <div align="right">
      <?php echo anchor($this->session->userdata('lolin_urlback_backend'), '<i class="fa fa-refresh"></i> Refresh Data', array('class' => 'btn btn-default btn-sm' )); ?>
      <?php echo anchor('admin/product/add', '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah Produk', array('class' => 'btn btn-primary btn-sm' )); ?>
    </div>

    <table id="produk" class="table table-hover">
      <thead>
        <tr>
        <th>No.</th>  
        <th>Nama Produk</th>
        <th>Kategori Produk</th>
        <th>Gambar Dasar Produk</th>
        <th>Gambar Depan Produk</th>
        <th>Gambar Belakang Produk</th>
        <!--th>Nilai Poin</th-->
        <th>Pengurutan Produk</th>
        <th>Produk Ditampilkan</th>
        <th>Harga</th>
        <th></th>            
        </tr>
      </thead>
    </table>
  </div>
</div>