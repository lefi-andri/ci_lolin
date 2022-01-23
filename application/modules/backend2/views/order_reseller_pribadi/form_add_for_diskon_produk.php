<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Order</small></h2>
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

<?php echo form_open($form_action); ?>

<table id="datatable" class="table table-striped table-bordered">
  <thead>
    <tr>
      <th>No.</th>
      <th>Nama Produk</th>
      <th>Jumlah Order</th>
      <th>Harga Satuan</th>
      <th>Harga Diskon</th>
    </tr>
  </thead>
  <tbody>
<?php
$data_produk = $this->session->userdata('produk_id');
$data_quantity = $this->session->userdata('quantity');
$no = 1;
foreach ($data_produk as $key_produk => $value) {
  $produk = $this->db->get_where('product', array('prodsId'=>$value))->row();
?>
    <tr>
      <td><?php echo $no; ?></td>
      <td><?php echo $produk->prodsName; ?></td>
      <td><?php echo $data_quantity[$key_produk]; ?></td>
      <td><?php echo $produk->prodsPrice; ?></td>
      <td>
        <label><input type="radio" class="flat" name="diskon<?php echo $key_produk ?>" required="required" value="0" /> Rp. <?php echo $produk->prodsPrice; ?> Harga Normal</label><br>
        <?php  
        $diskon = $this->db->get_where('diskon_harga', array('produk_id'=>$produk->prodsId, 'jumlah_unit !='=>'0'));
        foreach ($diskon->result() as $key => $value) {
          echo '<label><input type="radio" class="flat" name="diskon'.$key_produk.'" value="'.$value->diskon_id.'" required="required" /> '.$value->jumlah_unit.'  Pcs    Rp. '.$value->harga_jumlah_unit."</label><br>";
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

<?php echo form_submit('submit', 'Next', array('class'=>'btn btn-dark btn-block')); ?>
<?php echo form_close(); ?>


      </div>
    </div>
  </div>
</div>



