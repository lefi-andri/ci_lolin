<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Konfirmasi Email</h2>
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










<h3>Informasi Order</h3>
<table class="table table-striped">
  <tr>
    <td><div align="center"><strong>No.</strong></div></td>
    <td><div align="center"><strong>Nama Produk</strong></div></td>
    <td><div align="center"><strong>Berat</strong></div></td>
    <td><div align="center"><strong>Quantity</strong></div></td>
    <td><div align="center"><strong>Harga Normal</strong></div></td>
    <td><div align="center"><strong>Harga Reseller</strong></div></td>
    <td><div align="center"><strong>Harga</strong></div></td>
  </tr>
<?php 
$kode_order = isset($form_value['order_code']) ? $form_value['order_code'] : '';

$data_order = $this->db->get_where('purchase_order', array('order_code'=>$kode_order));

$total_harga_semua_unit = 0;
$total_berat_semua_unit = 0;
$no = 1;
foreach ($data_order->result() as $value) {
	$order_quantity = $this->db->get_where('diskon_harga', array('diskon_id'=>$value->diskon_id))->row();
	$harga_kali_unit = $order_quantity->jumlah_unit * $order_quantity->harga_jumlah_unit;

	$info_produk = $this->db->get_where('product', array('prodsId'=>$order_quantity->produk_id))->row();
?>
  <tr>
    <td><div align="center"><?php echo $no; ?></div></td>
    <td><div align="center"><?php echo $info_produk->prodsName; ?></div></td>
    <td><div align="center"><?php echo $order_quantity->berat; ?></div></td>
    <td><div align="center"><?php echo $order_quantity->jumlah_unit; ?></div></td>
    <td><div align="center">Rp. <?php echo number_format($info_produk->prodsPrice, 0, ".", "."); ?></div></td>
    <td><div align="center">Rp. <?php echo number_format($order_quantity->harga_jumlah_unit, 0, ".", "."); ?></div></td>
    <td><div align="center" style="color:blue;">Rp. <?php echo number_format($harga_kali_unit, 0, ".", "."); ?></div></td>
  </tr>
<?php
	$total_harga_semua_unit += $harga_kali_unit;
	$total_berat_semua_unit += $order_quantity->berat;
	$no++;
}
?>
  <tr>
    <td colspan="5">&nbsp;</td>
    <td><div align="right"><strong>Total : </strong></div></td>
    <td><div align="center" style="color:red;">Rp. <?php echo number_format($total_harga_semua_unit, 0, ".", "."); ?></div></td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
    <td><div align="right"><strong>Berat Total : </strong></div></td>
    <td><div align="center"><?php echo $total_berat_semua_unit; ?></div></td>
  </tr>
</table>
 
<br>
<h3>Input Konfirmasi Email</h3>

        <?php echo form_open($form_action, array('class' => 'form-horizontal', 'name'=>'autoSumForm')); ?>
<script>
function startCalc(){
interval = setInterval("calc()",1);}
function calc(){
one = document.autoSumForm.harga_pembelian_produk.value;
two = document.autoSumForm.biaya_pengiriman.value; 
document.autoSumForm.konfirmasi_total_harga.value = (one * 1) + (two * 1);}
function stopCalc(){
clearInterval(interval);}
</script>
        

        <div class="form-group">
          <label for="inputEmail3" class="col-sm-2 control-label">Harga Pembelian Produk <b class="peringatan">*</b></label>
          <div class="col-sm-4">
            <span class="peringatan"><?php echo form_error('harga_pembelian_produk'); ?></span>
            <?php  
              $form = array(
                'harga_pembelian_produk' => array(
                  'name' => 'harga_pembelian_produk', 
                  'value'=>set_value('harga_pembelian_produk', isset($form_value['harga_pembelian_produk']) ? $form_value['harga_pembelian_produk'] : ''),
                  'class'=>'form-control',
                  'type' => 'number',
                  'onFocus' => "startCalc();",
                  'onBlur' => "stopCalc();",
                ),
              );
            ?>
            <?php echo form_input($form['harga_pembelian_produk']); ?>
          </div>
        </div>

        <div class="form-group">
          <label for="inputEmail3" class="col-sm-2 control-label">Biaya Pengiriman <b class="peringatan">*</b></label>
          <div class="col-sm-4">
            <span class="peringatan"><?php echo form_error('biaya_pengiriman'); ?></span>
            <?php  
              $form = array(
                'biaya_pengiriman' => array(
                  'name' => 'biaya_pengiriman', 
                  'value'=>set_value('biaya_pengiriman', isset($form_value['biaya_pengiriman']) ? $form_value['biaya_pengiriman'] : ''),
                  'class'=>'form-control',
                  'type' => 'number',
                  'onFocus' => "startCalc();",
                  'onBlur' => "stopCalc();",
                ),
              );
            ?>
            <?php echo form_input($form['biaya_pengiriman']); ?>
          </div>
        </div>

        <div class="form-group">
          <label for="inputEmail3" class="col-sm-2 control-label">Konfirmasi Total Harga <b class="peringatan">*</b></label>
          <div class="col-sm-4">
            <span class="peringatan"><?php echo form_error('konfirmasi_total_harga'); ?></span>
            <?php  
              $form = array(
                'konfirmasi_total_harga' => array(
                  'name' => 'konfirmasi_total_harga', 
                  'value'=>set_value('konfirmasi_total_harga', isset($form_value['konfirmasi_total_harga']) ? $form_value['konfirmasi_total_harga'] : ''),
                  'class'=>'form-control',
                  'type' => 'number',
                  'onchange' => 'tryNumberFormat(this.form.thirdBox);'
                ),
              );
            ?>
            <?php echo form_input($form['konfirmasi_total_harga']); ?>
          </div>
        </div>

        <div class="form-group">
          <label for="inputEmail3" class="col-sm-2 control-label">Keterangan <b class="peringatan">*</b></label>
          <div class="col-sm-10">
            <span class="peringatan"><?php echo form_error('konfirmasi_email'); ?></span>
            <?php 
            $konten = set_value('konfirmasi_email', isset($form_value['konfirmasi_email']) ? $form_value['konfirmasi_email'] : '');
            ?>
            <textarea name="konfirmasi_email" class="form-control ckeditor" required="required"><?php echo $konten; ?></textarea>
          </div>
        </div>

        


        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <?php echo anchor($this->session->userdata('lolin_urlback_backend'), '<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Batal', array('class' => 'btn btn-warning btn-sm' )); ?>
            <?php echo form_submit('submit', 'Kirim', array('class'=>'btn btn-dark btn-sm')); ?>
          </div>
        </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>