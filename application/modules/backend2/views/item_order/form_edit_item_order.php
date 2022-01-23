<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Edit <small>Order Item</small></h2>
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
          
        </p>
        
        <?php #echo form_open($form_action); ?>
        <?php echo form_open(base_url('backend/item_order/update_diskon')); ?>
        <?php #echo $table; ?>

        <?php #print_r($edit_data); ?>

    <table class="table table-striped">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Kode Produk</th>
                  <th>Nama Produk</th>
                  <th>Harga</th>  
                  <th>Jumlah Pembelian</th>   
                </tr>
              </thead>
              <tbody>
                <td>1.</td>
                <td><?php echo $edit_data->prodsKode; ?></td>
                <td><?php echo $edit_data->prodsName; ?></td>
                <td><?php echo $edit_data->prodsPrice; ?></td>
                <td>
                  <input type="hidden" name="order_id" value="<?php echo $edit_data->order_id; ?>">
                  <input type="hidden" name="prodsId" value="<?php echo $edit_data->prodsId; ?>">
                  <input type="number" name="jumlah" class="form-control" value="<?php echo $edit_data->order_quantity; ?>" required="required" />
                </td>
              </tbody>
    </table>



        <?php echo form_submit('submit', 'Next', array('class'=>'btn btn-dark btn-block')); ?>
        <?php echo anchor($this->session->userdata('lolin_urlback_backend'), 'Batal', array('class' => 'btn btn-default btn-block' )); ?>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>