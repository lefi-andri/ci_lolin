<div align="center">
	<h4><?php echo $content->prodsName; ?></h4>
	<img src="<?php echo base_url(); ?>assets/images/product/base_of_product/<?php echo $content->prodsBasePic; ?>" alt="" width="200px">
	<br>
	<h5>Anda dapat membeli produk ini melalui :</h5>
	<?php
	if ($content->merchant) {
		$merchant = unserialize($content->merchant);
		foreach ($merchant as $value) {
			$get = $this->db->get_where('merchant', array('id_merchant'=>$value))->row();
			echo '<a href="'.$get->link_merchant.'" title="" target="_blank" rel="nofollow"><img src="'.base_url().'assets/images/merchant/'.$get->gambar_logo_merchant.'" alt=""></a> ';
		}
	}else{
		echo "Not Available";
	}
	
	?>
</div>
<hr class="margin-bottom-1x padding-top-1x">
<div style="padding: 2px; background: linear-gradient(to left , #EF7E31,#D5337C);">
	<div class="row">
		<div class="col-md-6" align="center">
			<h5 class="text-normal padding-top-1x" style="color: #FFFFFF;">Harga eksklusif untuk reseller.</h5>
		</div>
		<div class="col-md-6" align="right">
			<?php echo anchor(base_url('reseller'), 'Login', array('class'=>'btn btn-white')); ?>
			<?php echo anchor(base_url('reseller'), 'Mendaftar', array('class'=>'btn btn-outline-white')); ?>	
		</div>
	</div>
</div>