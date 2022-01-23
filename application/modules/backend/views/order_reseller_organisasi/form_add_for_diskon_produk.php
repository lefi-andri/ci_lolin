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