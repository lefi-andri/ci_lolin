<script>
  $(document).ready(function(){
    $('.refreshCaptcha').on('click', function(){
      $.get('<?php echo base_url().'login/auth/refresh_captcha'; ?>', function(data){
        $('#captImg').html(data);
      });
    });      
  });
</script>

<?php echo form_open($form_action, array('class'=>'ng-pristine ng-valid')); ?>
<!--form class="ng-pristine ng-valid"-->


  <?php echo form_error('email'); ?>
  <?php echo form_error('password'); ?>
  <?php echo form_error('secutity_code'); ?>

    <div class="form-group">
        <!--input type="email" class="form-control" placeholder="User name"-->
        <?php echo form_input($email); ?>
    </div>
    <div class="form-group">
        <!--input type="password" class="form-control" placeholder="Password"-->
        <?php echo form_input($password); ?>
    </div>
    <div class="form-group">
	    <label for="">CAPTCHA <a href="javascript:void(0);" class="refreshCaptcha" title="Ubah Captcha"><i class="fa fa-refresh"></i></a></label>
	    <p id="captImg"><?php echo $gambar_captcha; ?></p>
	    <?php
	    $form = array(
	    'secutity_code' => array(
	      'name' => 'secutity_code',
	      'value'=>set_value('secutity_code', isset($form_value['secutity_code']) ? $form_value['secutity_code'] : ''),
	      'class'=>'form-control',
	      'placeholder' => 'Captcha',
	    )
	    );
	    ?>
	    <?php echo form_input($form['secutity_code']); ?>
	</div>
    <div class="checkbox font-size-13 inline-block no-mrg-vertical no-pdd-vertical">
        <input id="agreement" name="agreement" type="checkbox">
        <label for="agreement">Keep Me Signed In</label>
    </div>
    <div class="pull-right">
        <a href="#">Forgot Password?</a>
    </div>
    <div class="mrg-top-20 text-right">
    	  <?php echo form_submit('submit', 'Login', array('class' => 'btn btn-info')); ?>
    </div>
<?php echo form_close(); ?>