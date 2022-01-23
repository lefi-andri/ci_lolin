<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Input Diskon Order</small></h2>
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


<?php echo form_open(base_url('backend/order_pending_reseller_pribadi/simpan_order_pending')); ?>

<table id="datatable" class="table table-striped table-bordered">
  <thead>
    <tr>
      <th>No.</th>
      <th>Nama Produk</th>
      <th>Quantity</th>
      <th>Harga Normal Satuan</th>
      <th>Harga Diskon</th>
    </tr>
  </thead>
  <tbody>
<?php
$no = 1;
foreach ($data_temporary->result() as $key_produk => $value) {
  $produk = $this->db->get_where('product', array('prodsId'=>$value->produk_id_temporary))->row();

  $quantity = $this->db->get_where('diskon_harga', array('diskon_id'=>$value->order_quantity_temporary))->row();
?>
    <tr>
      <td><?php echo $no; ?></td>
      <?php echo form_hidden('reseller_id[]', $value->reseller_id); ?>
      <?php echo form_hidden('order_date_temporary[]', $value->order_date_temporary); ?>

      <td><?php echo $produk->prodsName; ?></td>
      <?php echo form_hidden('prodsId[]', $produk->prodsId); ?>

      <td><?php echo $quantity->jumlah_unit; ?></td>
      <?php echo form_hidden('jumlah[]', $value->order_quantity_temporary); ?>

      <td>Rp. <?php echo $produk->prodsPrice; ?></td>
      <td>
        <label style='color:red;'><input type="radio" name="diskon<?php echo $key_produk ?>" required="required" value="0" /> Rp. <?php echo $produk->prodsPrice; ?> Harga Normal</label><br>
        <?php  
        $diskon = $this->db->get_where('diskon_harga', array('produk_id'=>$produk->prodsId, 'jumlah_unit !='=>'0'));
        foreach ($diskon->result() as $key => $value) {
          echo '<label><input type="radio" name="diskon'.$key_produk.'" value="'.$value->diskon_id.'" required="required" /> '.$value->jumlah_unit.'  Pcs    Rp. '.$value->harga_jumlah_unit."</label><br>";
        }
        ?>
      </td>
    </tr>
<?php
$no++;
}
?>
  </tbody>
</table>

<?php echo form_submit('submit', 'Simpan Order', array('class' => 'btn btn-dark btn-block')); ?>
<?php echo anchor(base_url('backend/order_pending_reseller_pribadi/index'), 'Batal', array('class' => 'btn btn-default btn-block')); ?>
<?php echo form_close(); ?>


      </div>
    </div>
  </div>
</div>
