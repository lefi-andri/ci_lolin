<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>DISKON PEMBELIAN<small>Harga diskon</small></h2>
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

<?php echo form_open(base_url('backend/item_order_reseller_pribadi/simpan_update')); ?>




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
$produk = $this->db->get_where('product', array('prodsId'=>$this->session->userdata('prodsId')))->row();
?>
    <tr>
      <td>1.</td>
      <td><?php echo $produk->prodsName; ?></td>
      <td><?php echo $this->session->userdata('jumlah'); ?></td>
      <td><?php echo $produk->prodsPrice; ?></td>
      <td>
        <label><input type="radio" name="diskon" required="required" value="0" /> Rp. <?php echo $produk->prodsPrice; ?> Harga Normal</label><br>
        <?php  
        $diskon = $this->db->get_where('diskon_harga', array('produk_id'=>$produk->prodsId, 'jumlah_unit !='=>'0'));
        foreach ($diskon->result() as $key => $value) {
          echo '<label><input type="radio" name="diskon" value="'.$value->diskon_id.'" required="required" /> '.$value->jumlah_unit.'  Pcs    Rp. '.$value->harga_jumlah_unit."</label><br>";
        }
        ?>
      </td>
    </tr>


  </tbody>
</table>

<?php echo form_submit('submit', 'Simpan Order', array('class' => 'btn btn-dark btn-block')); ?>
<?php echo anchor(base_url('backend/order_reseller_pribadi/index'), 'Batal', array('class' => 'btn btn-default btn-block')); ?>
<?php echo form_close(); ?>


      </div>
    </div>
  </div>
</div>