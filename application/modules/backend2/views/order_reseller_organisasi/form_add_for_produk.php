<?php echo form_open($form_action); ?>
<?php echo $table; ?>
<?php echo form_submit('submit', 'Next', array('class'=>'btn btn-dark btn-block')); ?>
<?php echo form_close(); ?>