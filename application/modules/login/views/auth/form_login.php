<script>
  $(document).ready(function(){
    $('.refreshCaptcha').on('click', function(){
      $.get('<?php echo base_url().'login/auth/refresh_captcha'; ?>', function(data){
        $('#captImg').html(data);
      });
    });      
  });
</script>
<div align="center">
<div class="panel panel-default">
  <div class="panel-body">

  <img src="<?php echo base_url(); ?>assets/images/template/lolin-logo.png" alt="">
  <?php echo form_open($form_action); ?>
  <?php echo form_error('email'); ?>
  <?php echo form_error('password'); ?>
  <?php echo form_error('secutity_code'); ?>
  <br>
  <div class="input-group">
    <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-user"></span></span>
    <?php echo form_input($email); ?>
  </div>
  <div class="input-group">
    <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-lock"></span></span>
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
  <br>
  <?php echo form_submit('submit', 'Log in', array('class' => 'btn btn-dark btn-block')); ?>
  <?php echo form_close(); ?>
    <br>
    <p>© 2018 All Rights Reserved. Privacy and Terms</p>
  </div>
</div>
</div>