              <a href="<?php echo base_url().'cart'; ?>"></a>
                <i class="icon-bag"></i><span class="count"><?php echo $this->cart->total_items(); ?></span><span class="subtotal">Rp. <?php echo ($this->session->userdata('total_order')) ? number_format($this->session->userdata('total_order'), 0, ".", ".") : number_format($this->cart->total(), 0, ".", "."); ?></span>
                  
                  <div class="toolbar-dropdown">

<?php
$no = 1;
foreach ($this->cart->contents() as $items) {
  $this->db->select('*');
  $this->db->from('product');
  $this->db->where('prodsId', $items['id']);
  $data_produk = $this->db->get()->row();
?>
<div class="dropdown-product-item">
  <span class="dropdown-product-remove"><i class="icon-cross"></i></span>
  <a class="dropdown-product-thumb" href="<?php echo base_url(); ?>product/<?php echo $data_produk->prodsSlug; ?>"><img src="<?php echo base_url(); ?>assets/images/product/front_of_product/small_<?php echo $data_produk->prodsFrontPic; ?>" alt="Product"></a>
  <div class="dropdown-product-info">
    <a class="dropdown-product-title" href="<?php echo base_url(); ?>product/<?php echo $data_produk->prodsSlug; ?>"><?php echo $data_produk->prodsName; ?></a>
    <span class="dropdown-product-details"><?php echo $items['qty']; ?> x Rp. <?php echo $data_produk->prodsPrice; ?></span></div>
</div>
<?php
}
?>

<hr>
<div class="toolbar-dropdown-group">
  <div class="column"><span class="text-lg">Subtotal:</span></div>
  <div class="column text-right"><span class="text-lg text-medium">Rp. <?php echo number_format($this->cart->total(), 0, ".", "."); ?>&nbsp;</span></div>
</div>

<div class="toolbar-dropdown-group">
  <div class="column"><a class="btn btn-sm btn-block btn-secondary" href="<?php echo base_url().'cart' ?>">Your Cart</a></div>
  <div class="column"><a class="btn btn-sm btn-block btn-success" href="<?php echo base_url().'ship_bill' ?>">Checkout</a></div>
</div>

                  </div>