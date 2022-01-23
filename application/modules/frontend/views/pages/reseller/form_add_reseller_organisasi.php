<script type="text/javascript" src="<?= base_url(); ?>assets/js/jquery.min.js"></script>
<script>
$(document).ready(function(){
  $('.refreshCaptcha').on('click', function(){
    $.get('<?php echo base_url().'frontend/reseller/refresh_captcha'; ?>', function(data){
      $('#captImg').html(data);
    });
  });
 
});
</script>


<!-- Page Content-->
<div class="container padding-bottom-3x mb-2">
	
	<div class="row">
	  <div class="col-md-6">
      <img class="d-block mx-auto img-thumbnail mb-3" src="<?php echo base_url(); ?>assets/images/template/register_distributor.jpg" alt="Lolin Image">
	  </div>
	  <div class="col-md-6">


	<?php echo form_open($form_action, array('class'=>'login-box')); ?>

		<?php $this->load->view('include/template/message'); ?>

		<div align="center">
			<h3 class="margin-bottom-1x">Registrasi Distributor</h3>
			<p style="font-size: 14px;">Sudah punya akun Lolin? <?php echo anchor('reseller', '<b>Login</b>', array('style'=>'text-decoration:none;')); ?></p>
		</div>

		<h6 class="text-muted text-normal text-uppercase padding-top-2x">CONTACT INFORMATION</h6>
          <hr class="margin-bottom-1x">

          <div class="col-sm-12">
                <div class="form-group">
                  <label for="nama_organisasi">Nama Organisasi</label>
                  <?php echo form_error('nama_organisasi'); ?>
                  <?php  
			            $form = array(
			            	'nama_organisasi' => array(
			            		'id' => 'nama_organisasi',
				              	'name' => 'nama_organisasi', 
				              	'value'=>set_value('nama_organisasi', isset($form_value['nama_organisasi']) ? $form_value['nama_organisasi'] : ''),
				              	'class'=>'form-control form-control-sm',
				              	'placeholder' => 'Nama Organisasi',
				            ),
				        );
				    ?>
                  <?php echo form_input($form['nama_organisasi']); ?>
                </div>
              </div>
	    
	    	<div class="col-sm-12">
                <div class="form-group">
                  <label for="alamat_organisasi">Alamat Organisasi</label>
                  <?php echo form_error('alamat_organisasi'); ?>
                  <?php
				    	$form = array(
				            'alamat_organisasi' => array(
				            	'id' => 'alamat_organisasi',
				              	'name' => 'alamat_organisasi', 
				              	'value'=>set_value('alamat_organisasi', isset($form_value['alamat_organisasi']) ? $form_value['alamat_organisasi'] : ''),
				              	'class'=>'form-control form-control-sm',
				              	'placeholder' => 'Alamat Organisasi',
				            ),
				        );
				    ?>
                  <?php echo form_input($form['alamat_organisasi']); ?>
                </div>
              </div>
	    
	    	<div class="col-sm-12">
                <div class="form-group">
                  <label for="nomor_telepon_organisasi">Telepon Organisasi</label>
                  <?php echo form_error('nomor_telepon_organisasi'); ?>
                  <?php
				    	$form = array(
				            'nomor_telepon_organisasi' => array(
				            	'id' => 'nomor_telepon_organisasi',
				              	'name' => 'nomor_telepon_organisasi',
				              	'value'=>set_value('nomor_telepon_organisasi', isset($form_value['nomor_telepon_organisasi']) ? $form_value['nomor_telepon_organisasi'] : ''),
				              	'class'=>'form-control form-control-sm',
				              	'placeholder' => 'Nomor Telepon Organisasi',
				            ),
				        );
				    ?>
                  <?php echo form_input($form['nomor_telepon_organisasi']); ?>
                </div>
              </div>
	    
	    	<div class="col-sm-12">
                <div class="form-group">
                  <label for="nama_lengkap">Nama Perwakilan</label>
                  <?php echo form_error('nama_lengkap'); ?>
                  <?php
				    	$form = array(
				            'nama_lengkap' => array(
				            	'id' => 'nama_lengkap',
				              	'name' => 'nama_lengkap', 
				              	'value'=>set_value('nama_lengkap', isset($form_value['nama_lengkap']) ? $form_value['nama_lengkap'] : ''),
				              	'class'=>'form-control form-control-sm',
				              	'placeholder' => 'Nama Lengkap',
				            ),
				        );
				    ?>
                  <?php echo form_input($form['nama_lengkap']); ?>
                </div>
              </div>
	    
	    	<div class="col-sm-12">
                <div class="form-group">
                  <label for="email">E Mail</label>
                  <?php echo form_error('email'); ?>
                  <?php
				    	$form = array(
				            'email' => array(
				            	'id' => 'email',
				              	'name' => 'email',
				              	'value'=>set_value('email', isset($form_value['email']) ? $form_value['email'] : ''),
				              	'class'=>'form-control form-control-sm',
				              	'placeholder' => 'E Mail',
				            ),
				        );
				    ?>
                  <?php echo form_input($form['email']); ?>
                </div>
              </div>


        <h6 class="text-muted text-normal text-uppercase padding-top-2x">ACCOUNT INFORMATION</h6>
          <hr class="margin-bottom-1x">

         <div class="col-sm-12">
                <div class="form-group">
                  <label for="password">Password</label>
                  <?php echo form_error('password'); ?>
                  <?php
				    	$form = array(
				            'password' => array(
				            	'id' => 'password',
				              	'type' => 'password',
				              	'name' => 'password',
				              	'value' => set_value('password', isset($form_value['password']) ? $form_value['password'] : ''),
				              	'class' => 'form-control form-control-sm',
				              	'placeholder' => 'Password',
				            ),
				        );
				    ?>
                  <?php echo form_input($form['password']); ?>
                </div>
              </div>
	    
	    
	    	<div class="col-sm-12">
                <div class="form-group">
                  <label for="password_confirm">Konfirmasi Password</label>
                  <?php echo form_error('password_confirm'); ?>
                  <?php
				    	$form = array(
				            'password_confirm' => array(
				            	'id' => 'password_confirm',
				              	'type' => 'password',
				              	'name' => 'password_confirm',
				              	'value' => set_value('password_confirm', isset($form_value['password_confirm']) ? $form_value['password_confirm'] : ''),
				              	'class' => 'form-control form-control-sm',
				              	'placeholder' => 'Konfirmasi Password',
				            ),
				        );
				    ?>
                  <?php echo form_input($form['password_confirm']); ?>
                </div>
              </div>

        <h6 class="text-muted text-normal text-uppercase padding-top-2x">RESELLER PACKAGE</h6>
          <hr class="margin-bottom-1x">

			<div class="col-sm-12">
	            <div class="form-group">
	                  <label for="paket_id">Pilih Paket Distributor</label>
	                  <?php echo form_error('paket_id'); ?>
	                  <?php echo form_dropdown('paket_id', $dropdown_paket_distributor, set_value('paket_id', isset($form_value['paket_id']) ? $form_value['paket_id'] : ''), array('class' => 'form-control form-control-sm', 'id'=>'paket_id')); ?>
	                  
	            </div>
	        </div>
	    	
	    	<div class="col-sm-6">
                <div class="form-group">
                  <label for="secutity_code">Captcha <a href="javascript:void(0);" class="refreshCaptcha" title="Ubah Captcha"><i class="fa fa-refresh"></i></a></label>
                  <div id="captImg"><?php echo $gambar_captcha; ?></div>
                  <br>
                  <?php echo form_error('secutity_code'); ?>
                  <?php
				    	$form = array(
				            'secutity_code' => array(
				            	'id' => 'secutity_code',
				              	'name' => 'secutity_code',
				              	'value'=>set_value('secutity_code', isset($form_value['secutity_code']) ? $form_value['secutity_code'] : ''),
				              	'class'=>'form-control',
				              	'placeholder' => 'Captcha',
				            ),
			            );
			        ?>
                  <?php echo form_input($form['secutity_code']); ?>
                </div>
              </div>
	    

	    
	    	<div class="col-sm-12">
                <div class="form-group">
                  	<?php echo anchor(base_url('reseller'), 'Kembali', array('class'=>'btn btn-outline-primary')); ?>
					<?php echo form_submit('submit', 'Daftar', array('class'=>'btn btn-primary')); ?>
                </div>
              </div>
	    

		<?php echo form_close(); ?>


	  </div>
	</div>

</div>
