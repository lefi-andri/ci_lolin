<?php  
	$form = array(
		'pengaturanOwnerName' => array(
			'id'			=> 'pengaturanOwnerName',
			'name' 			=> 'pengaturanOwnerName', 
			'value'			=> set_value('pengaturanOwnerName', isset($form_value['pengaturanOwnerName']) ? $form_value['pengaturanOwnerName'] : ''),
			'class'			=> 'form-control',
			'placeholder'	=> 'Owner Name'
		),
		'pengaturanCompanyName' => array(
			'id'			=> 'pengaturanCompanyName',
			'name' 			=> 'pengaturanCompanyName', 
			'value'			=> set_value('pengaturanCompanyName', isset($form_value['pengaturanCompanyName']) ? $form_value['pengaturanCompanyName'] : ''),
			'class'			=> 'form-control',
			'placeholder'	=> 'Company Name'
		),
	);
?>

<div class="card">
  <div class="card-header text-white bg-secondary">
    Pengaturan Website
  </div>
  <div class="card-body">
    
	<?php echo form_open($form_action, array('class'=>'form-horizontal')); ?>

	<div class="form-group">
		<label for="pengaturanTahun" class="col-sm-2 control-label">Pengaturan Tahun <b class="peringatan">*</b></label>
		<div class="col-sm-3">
			<?php echo form_dropdown('pengaturanTahun', $opt_filter, set_value('pengaturanTahun', isset($form_value['pengaturanTahun']) ? $form_value['pengaturanTahun'] : ''), array("class"=>"form-control select2", "id"=>"pengaturanTahun")); ?>
		</div>
	</div>

	<div class="form-group">
		<label for="pengaturanOwnerName" class="col-sm-2 control-label">Owner Name <b class="peringatan">*</b></label>
		<div class="col-sm-7">
			<span class="peringatan"><?php echo form_error('pengaturanOwnerName'); ?></span>
			<?php echo form_input($form['pengaturanOwnerName']); ?>
		</div>
	</div>

	<div class="form-group">
		<label for="pengaturanCompanyName" class="col-sm-2 control-label">Company Name <b class="peringatan">*</b></label>
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
			<?php echo form_submit('submit', "Simpan Data", array('class'=>'btn btn-primary btn-sm')); ?>
		</div>
	</div>

	<?php echo form_close(); ?>	

  </div>
</div>