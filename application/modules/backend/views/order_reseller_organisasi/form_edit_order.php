<div align="right">

<?php echo anchor(base_url()."backend/item_order_reseller_organisasi/add_item_order", 'Tambah Item', array('class'=>'btn btn-dar btn-sm')); ?>

	<?php echo anchor(base_url('backend/order_reseller_organisasi/index'), 'Kembali', array('class'=>'btn btn-warning btn-sm')); ?>
  <?php echo anchor($this->session->userdata('lolin_urlback_backend'), '<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Refresh Data', array('class' => 'btn btn-info btn-sm' )); ?>
</div>

<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Edit <small>Order</small></h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="#">Settings 1</a>
              </li>
              <li><a href="#">Settings 2</a>
              </li>
            </ul>
          </li>
          <li><a class="close-link"><i class="fa fa-close"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <p class="text-muted font-13 m-b-30">
          Menampilkan semua order
        </p>
        <?php echo $table; ?>
      </div>
    </div>
  </div>
</div>