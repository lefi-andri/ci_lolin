<div class="card">
  <div class="card-header text-white bg-secondary">
    Halaman ini digunakan untuk mengelola event
  </div>
  <div class="card-body">
    <div align="right">
      <?php echo anchor($this->session->userdata('lolin_urlback_backend'), '<i class="fa fa-refresh"></i> Refresh Data', array('class' => 'btn btn-default btn-sm' )); ?>
      <?php echo anchor('admin/event/add', '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah Events', array('class' => 'btn btn-primary btn-sm' )); ?>
    </div>

            <table id="events" class="table table-hover">
              <thead>
                <tr>
                <th>No.</th>
                <th>Foto Depan</th>
                <th>Nama Event</th>
                <th>Tanggal Event</th>
                <th>Tempat</th>
                <th>Ditampilkan</th>
                <th>Pengurutan Event</th>
                <th></th>
                </tr>
              </thead>
            </table>
  </div>
</div>