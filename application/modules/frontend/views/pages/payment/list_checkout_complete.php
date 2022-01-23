<!-- Page Content-->
<div class="container padding-bottom-3x mb-2">
	<div class="card text-center">
	  <div class="card-body padding-top-2x">
	    <h3 class="card-title">Thank you for your order!</h3>
	    <p class="card-text">Your order has been placed and will be processed as soon as possible.</p>
	    <p class="card-text">Make sure you make note of your order number, which is 
	    	<span class="text-medium">
	    		<?php 
	    		if (!$this->ion_auth->logged_in())
				{
					echo ($this->session->userdata('order_code_non_reseller')) ? $this->session->userdata('order_code_non_reseller') : ''; 
				}else{
					echo ($this->session->userdata('order_code_reseller')) ? $this->session->userdata('order_code_reseller') : ''; 
				}
	    		?>
	    	</span>
	    </p>
	    <p class="card-text">You will be receiving an email shortly with confirmation of your order. 
	      <u>You can now:</u>
	    </p>
	    <div class="padding-top-1x padding-bottom-1x">
	    	<?php echo anchor(base_url('shop'), 'Go Back Shopping', array('class' => 'btn btn-outline-secondary btn-sm')); ?>
	    	<?php echo anchor(base_url('reseller'), '<i class="icon-location"></i>&nbsp;My Account', array('class' => 'btn btn-outline-primary btn-sm')); ?>
	    </div>
	  </div>
	</div>
</div>