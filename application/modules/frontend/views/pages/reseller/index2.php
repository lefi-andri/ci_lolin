<script type="text/javascript" src="<?= base_url(); ?>assets/js/jquery.min.js"></script>
  <script>
    $(document).ready(function(){
      $('.refreshCaptcha').on('click', function(){
        $.get('<?php echo base_url().'frontend/reseller/refresh_captcha'; ?>', function(data){
          $('#captImg').html(data);
        });
      });
      $('.refreshCaptchaLogin').on('click', function(){
        $.get('<?php echo base_url().'frontend/reseller/refresh_captcha_login'; ?>', function(data){
          $('#caption_image_captcha_login').html(data);
        });
      });
    });
  </script>

<div class="container">
  <div class="row justify-content-md-center">
    <div class="col col-lg-6 padding-bottom-3x">

          <?php $this->load->view('include/template/message'); ?>
          <?php echo form_open("reseller", array('class'=>'login-box'));?>

            <div align="center">
              <h3 class="margin-bottom-1x">Login</h3>
              <p style="font-size: 14px;">Belum punya akun Lolin? <?php echo anchor('reseller/pribadi/register', '<b>Daftar Reseller</b>', array('style'=>'text-decoration:none;')); ?> atau <?php echo anchor('reseller/organisasi/register', '<b>Daftar Distributor</b>', array('style'=>'text-decoration:none;')); ?></p>
            </div>
            
            <div class="form-group input-group">
              <label for="username_login">E-Mail</label>
                <?php echo form_error('username_login') ?>
                <?php  
                $form = array( 
                  'username_login' => array(
                    'id' => 'username_login',
                    'name' => 'username_login', 
                    'value' => set_value('username_login', isset($form_value['username_login']) ? $form_value['username_login'] : ''),
                    'class' => 'form-control',
                    'placeholder' => 'E-Mail',
                    'type' => 'email',
                  ),
                );
                ?>
                <?php echo form_input($form['username_login']); ?>
            </div>

            <div class="form-group input-group">
              <label for="password_login">Password</label>
                <?php echo form_error('password_login') ?>
                <?php  
                $form = array( 
                  'password_login' => array(
                    'id' => 'password_login',
                    'name' => 'password_login', 
                    'value' => set_value('password_login', isset($form_value['password_login']) ? $form_value['password_login'] : ''),
                    'class' => 'form-control',
                    'placeholder' => 'Password',
                    'type' => 'password',
                  ),
                );
                ?>
                <?php echo form_input($form['password_login']); ?>
            </div>

            <div class="col-sm-8">
              <div class="form-group">
                <label for="">Captcha <a href="javascript:void(0);" class="refreshCaptchaLogin" title="Ubah Captcha"><i class="fa fa-refresh"></i></a></label>
                <p id="caption_image_captcha_login"><?php echo $gambar_captcha_login; ?></p>
                
                <?php echo form_error('secutity_code_login'); ?>
                <?php
                $form = array(
                  'secutity_code_login' => array(
                    'name' => 'secutity_code_login',
                    'value'=>set_value('secutity_code_login', isset($form_value['secutity_code_login']) ? $form_value['secutity_code_login'] : ''),
                    'class'=>'form-control',
                    'placeholder' => 'Captcha',
                  ),
                );
              ?>
                <?php echo form_input($form['secutity_code_login']); ?>
              </div>
            </div>

            <div class="text-center text-sm-left">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="remember" class="custom-control-input"  id="ex-check-1" value="1">
                  <label class="custom-control-label" for="ex-check-1">Ingat Saya</label>
                </div>
            </div>

            <div class="text-center text-sm-right">
              <?php echo form_submit('login', 'Login', array('class'=>'btn btn-primary margin-bottom-none btn-sm')); ?>
            </div>

          <?php echo form_close(); ?>


    </div>
  </div>
</div>
