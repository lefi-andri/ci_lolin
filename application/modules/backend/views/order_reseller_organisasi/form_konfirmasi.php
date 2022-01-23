<h4><?php echo $this->session->userdata('reseller_id'); ?></h4>
<?php echo form_open($form_action); ?>
<?php echo $table; ?>
<?php echo form_submit('submit', 'Simpan', array('class'=>'btn btn-dark btn-block')); ?>
<?php echo form_close(); ?>