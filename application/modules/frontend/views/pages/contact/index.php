      <div class="container">
      <?php $this->load->view('include/template/message'); ?>
      	<div class="row">
		  <div class="col-md-8 offset-md-2">
		  	<div align="center">
		  		<h3>LOLIN KIDS CARE</h3>
		  		<h5>Kirimkan kirim pesan anda untuk saran, kritik, pembelian produk lolin, maupun informasi lebih lanjut.</h5>
		  	</div>
		  </div>
		 </div>
      	<div class="row">
		  <div class="col-md-6 offset-md-3">
			<?php echo form_open($form_action); ?>
			<div class="form-group">
				<label>Nama Lengkap</label>
				<span class="information-area"><?php echo form_error('conNama'); ?></span>
				<?php  
				$form = array(
					'conNama' => array(
						'name' => 'conNama', 
						'value'=>set_value('conNama', isset($form_value['conNama']) ? $form_value['conNama'] : ''),
						'class'=>'form-control'
					),
				);
				?>
				<?php echo form_input($form['conNama']); ?>
			</div>

			<div class="form-group">
				<label>Alamat</label>
				<span class="information-area"><?php echo form_error('conAddress'); ?></span>
				<?php
				$form = array(
					'conAddress' => array(
						'name' => 'conAddress', 
						'value'=>set_value('conAddress', isset($form_value['conAddress']) ? $form_value['conAddress'] : ''),
						'class'=>'form-control'
					),
				);
				?>
				<?php echo form_input($form['conAddress']); ?>
			</div>

			<div class="form-group">
				<label>Telpon</label>
				<span class="information-area"><?php echo form_error('conTelp'); ?></span>
				<?php
				$form = array(
					'conTelp' => array(
						'name' => 'conTelp', 
						'value'=>set_value('conTelp', isset($form_value['conTelp']) ? $form_value['conTelp'] : ''),
						'class'=>'form-control'
					),
				);
				?>
				<?php echo form_input($form['conTelp']); ?>
			</div>

			<div class="form-group">
				<label>Alamat Email Anda</label>
				<span class="information-area"><?php echo form_error('conEmail'); ?></span>
				<?php
				$form = array(
					'conEmail' => array(
						'name' => 'conEmail', 
						'value'=>set_value('conEmail', isset($form_value['conEmail']) ? $form_value['conEmail'] : ''),
						'class'=>'form-control'
					),
				);
				?>
				<?php echo form_input($form['conEmail']); ?>
			</div>

			<div class="form-group">
				<label>Kritik dan Saran</label>
				<span class="information-area"><?php echo form_error('conMessage'); ?></span>
				<?php
				$form = array(
					'conMessage' => array(
						'name' => 'conMessage', 
						'value'=>set_value('conMessage', isset($form_value['conMessage']) ? $form_value['conMessage'] : ''),
						'class'=>'form-control'
					),	
				);
				?>
				<?php echo form_textarea($form['conMessage']); ?>
			</div>
			<div class="row">
			  <div class="col-md-6 col-md-push-6">
			  	<?php echo form_submit('submit', 'Kirim Pesan', array('class' => 'btn btn-primary btn-lg btn-block waves-effect waves-light', 'id' => '')) ?>
			  </div>
			  <div class="col-md-6 col-md-pull-6">
			  	<img src="<?php echo base_url('assets/images/template/be-our-distributor.png'); ?>" class="img-responsive" alt="Be Our Distributor">
			  </div>
			</div>
			<?php echo form_close(); ?>
		  </div>
		</div>
      </div>
      <br>