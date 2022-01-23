<?php  
	$form = array(
		'pengaturanOwnerName' => array(
			'name' 			=> 'pengaturanOwnerName', 
			'value'			=> set_value('pengaturanOwnerName', isset($form_value['pengaturanOwnerName']) ? $form_value['pengaturanOwnerName'] : ''),
			'class'			=> 'form-control',
			'placeholder'	=> 'Owner Name'
		),
		'pengaturanCompanyName' => array(
			'name' 			=> 'pengaturanCompanyName', 
			'value'			=> set_value('pengaturanCompanyName', isset($form_value['pengaturanCompanyName']) ? $form_value['pengaturanCompanyName'] : ''),
			'class'			=> 'form-control',
			'placeholder'	=> 'Company Name'
		),
	);
?>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">Pengaturan</div>
			<div class="panel-body">
				<?php echo form_open($form_action, ['class'=>'form-horizontal']); ?>

				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Pengaturan Tahun <b class="peringatan">*</b></label>
					<div class="col-sm-3">
						<?php echo form_dropdown('pengaturanTahun', $opt_filter, set_value('pengaturanTahun', isset($form_value['pengaturanTahun']) ? $form_value['pengaturanTahun'] : ''), 'class="form-control"'); ?>
					</div>
				</div>

				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Owner Name <b class="peringatan">*</b></label>
					<div class="col-sm-7">
						<span class="peringatan"><?php echo form_error('pengaturanOwnerName'); ?></span>
						<?php echo form_input($form['pengaturanOwnerName']); ?>
					</div>
				</div>

				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Company Name <b class="peringatan">*</b></label>
					<div class="col-sm-7">
						<span class="peringatan"><?php echo form_error('pengaturanCompanyName'); ?></span>
						<?php echo form_input($form['pengaturanCompanyName']); ?>
					</div>
				</div>

				<div class="form-group">
		          <label for="inputEmail3" class="col-sm-2 control-label">Pengaturan Email</label>
		          <div class="col-sm-10">
		          <span class="peringatan"><?php echo form_error('pengaturanEmail'); ?></span>
		            <label class="radio-inline">
		                    <?php echo form_radio('pengaturanEmail', '1', set_radio('pengaturanEmail', '1', isset($form_value['pengaturanEmail']) && $form_value['pengaturanEmail'] == '1' ? TRUE : FALSE), array('class' => 'flat')); ?>
		                Ya</label>
		                <label class="radio-inline">
		                    <?php echo form_radio('pengaturanEmail', '0', set_radio('pengaturanEmail', '0', isset($form_value['pengaturanEmail']) && $form_value['pengaturanEmail'] == '0' ? TRUE : FALSE), array('class' => 'flat')); ?>
		                Tidak</label>
		                <p>Perbolehkan website mengirimkan email ?</p>
		            </div>
		        </div>



				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<?php echo anchor($this->session->userdata('lolin_urlback_backend'), "Kembali", array('class' => 'btn btn-default btn-sm' )); ?>
						<?php echo form_submit('submit', "Simpan Data", ['class'=>'btn btn-dark btn-sm']); ?>
					</div>
				</div>

				<?php echo form_close(); ?>		

			</div>
		</div>
	</div>
</div>
