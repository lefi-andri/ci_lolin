<?php echo form_open(base_url('backend/order_pending_reseller_organisasi/simpan_order_pending')); ?>

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
$no = 1;
foreach ($data_temporary->result() as $key_produk => $value) {
  $produk = $this->db->get_where('product', array('prodsId'=>$value->produk_id_temporary))->row();
?>
    <tr>
      <td><?php echo $no; ?></td>
      <?php echo form_hidden('reseller_id[]', $value->reseller_id); ?>
      <?php echo form_hidden('order_date_temporary[]', $value->order_date_temporary); ?>

      <td><?php echo $produk->prodsName; ?></td>
      <?php echo form_hidden('prodsId[]', $produk->prodsId); ?>

      <td><?php echo $value->order_quantity_temporary; ?></td>
      <?php echo form_hidden('jumlah[]', $value->order_quantity_temporary); ?>

      <td><?php echo $produk->prodsPrice; ?></td>
      <td>
        <label><input type="radio" name="diskon<?php echo $key_produk ?>" required="required" value="0" /> Rp. <?php echo $produk->prodsPrice; ?> Harga Normal</label><br>
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
<?php echo anchor(base_url('backend/order_pending_reseller_organisasi/index'), 'Batal', array('class' => 'btn btn-default btn-block')); ?>
<?php echo form_close(); ?>