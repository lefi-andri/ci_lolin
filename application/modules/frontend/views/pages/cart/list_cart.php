<script>
function updating_cart(id)
{
	var row_id = $("#row"+id).val()
    var updating_cart_item=$("#updating_cart_item"+id).val();
    
    $.ajax({

	    url:"<?php echo base_url(); ?>frontend/cart/updating_cart",
	    //method: "POST",
	    data: "id="+id+"&updating_cart_item="+updating_cart_item ,
	    
	    success: function(html)
	    { 
	         $("#cart_result").html(html);
	    }
    });  
}
</script>
<div id="cart_result"></div>

<?php #print_r($_SESSION); ?>


<!-- Page Content-->
<div class="container padding-bottom-3x mb-1">

<?php if(!$this->cart->contents()):
?>

<div class="container padding-bottom-2x mb-2">
        <div class="row align-items-center padding-bottom-2x">
          <div class="col-md-5"><img class="d-block w-270 m-auto" src="<?php echo base_url(); ?>assets/themes/unishop/img/features/01.jpg" alt="Online Shopping"></div>
          <div class="col-md-7 text-md-left text-center">
            <div class="mt-30 hidden-md-up"></div>
            <h2>Your Shopping Cart is Empty !</h2>
            
            <a class="text-medium text-decoration-none" href="<?php echo base_url('shop'); ?>">Shop&nbsp;<i class="icon-arrow-right"></i></a>
          </div>
        </div>
</div>
<!--div align="center">
	<img src="<?php echo base_url(); ?>assets/images/template/empty_cart.jpg" alt="">
	<br>
	<br>
	<?php echo anchor(base_url('product'), 'Shop Now', array('class' => 'btn btn-primary')); ?>
</div-->
<?php
else:
?>

	<?php echo form_open($form_action); ?>

	<div class="row">
		<div class="col-xs-12 col-sm-12">

		<?php // PROSES CHECKOUT ?>
		<?php $this->load->view('include/template/extend/checkout_extend'); ?>

          <div class="table-responsive">

		  

			<div class="table-responsive shopping-cart">
		  		<?php echo $table; ?>
		  		<!--table class="table table-striped">
		  			<tr>
						<td colspan="3"><strong>Total</strong></td>
						<td>Rp. <?php echo $this->cart->format_number($this->cart->total()); ?></td>
					</tr>
		  		</table-->
		  	</div>

			

          </div>
		</div>

		<div class="col-xs-6 col-sm-8">
		
		</div>
		<div class="col-xs-6 col-sm-4">
		
			<div class="card text-white bg-secondary">
			  <div class="card-header">
			    <h5>SUBTOTAL</h5>
			  </div>
			  <div class="card-body">
				<div class="input-group">
                  <input class="form-control form-control-rounded form-control-lg" type="text" value="<?php echo number_format($this->cart->total(), 0, ".", "."); ?>" disabled="disabled">
                  <span class="input-group-addon"><b>Rp. </b></span>
                </div>

			    
			  </div>
			</div>

		</div>

		<div class="col-xs-12 col-sm-12">
			<!--div class="row">
				<div class="col">
				1 of 2
				</div>
				<div class="col">
				2 of 2
				</div>
			</div-->
			<br>
			<div class="shopping-cart-footer">
				<div class="column">
					<?php echo anchor(base_url('shop'), '<i class="icon-arrow-left"></i>&nbsp;Back to Shopping', array('class'=>'btn btn-outline-secondary btn-sm')); ?>
					
				</div>
				<div class="column">
					

					<?php echo form_submit('update_item', 'Update Cart', array('class'=>'btn btn-primary btn-sm')); ?>
					<?php echo anchor(base_url('ship_bill'), '<span class="glyphicon glyphicon-bookmark"></span> Checkout', array('class'=>'btn btn-success btn-sm')); ?>
					
				</div>
			</div>

		</div>

	</div>

	<?php echo form_close(); ?>

<?php 
endif;
?>

</div>