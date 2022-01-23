<div class="checkout-steps">
	<a href="">4. Successfully order</a>
	<a class="<?php echo ($this->uri->segment(1) == 'payment') ? 'active' : 'completed'; ?>" href=""><span class="angle"></span>3. Payment</a>
	<a class="<?php echo ($this->uri->segment(1) == 'ship_bill') ? 'active' : 'completed'; ?>" href=""><?php if(($this->uri->segment(1) != 'ship_bill')and(!empty($this->session->userdata('total_order')))) { echo '<span class="step-indicator icon-circle-check"></span>'; }else{ echo '';} ?><span class="angle"></span>2. Shipping</a>
	<a class="<?php echo ($this->uri->segment(1) == 'cart') ? 'active' : 'completed'; ?>" href=""><?php if(($this->uri->segment(1) != 'cart')) { echo '<span class="step-indicator icon-circle-check"></span>'; }else{ echo '';} ?><span class="angle"></span>1. Your Cart</a>
</div>