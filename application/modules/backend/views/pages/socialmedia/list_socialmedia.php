<div class="card">
  <div class="card-header text-white bg-secondary">
    Halaman ini mengatur mengenai sosial media website
  </div>
  <div class="card-body">
    <div align="right">
      <?php echo anchor($this->session->userdata('lolin_urlback_backend'), '<i class="fa fa-refresh"></i> Refresh Data', array('class' => 'btn btn-default btn-sm' )); ?>
    </div>

    <table id="socialmedia" class="table table-hover">
      <thead>
        <tr>
        <th>No.</th>
        <th>Social Name</th>
        <th>Social Value</th>
        <th>Ditampilkan</th>
        <th></th>             
        </tr>
      </thead>
    </table>
  </div>
</div>