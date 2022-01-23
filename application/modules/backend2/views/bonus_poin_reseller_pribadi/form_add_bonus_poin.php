<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Tambah jenis bonus</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="#">Settings 1</a>
              </li>
              <li><a href="#">Settings 2</a>
              </li>
            </ul>
          </li>
          <li><a class="close-link"><i class="fa fa-close"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">

				<?php echo form_open($form_action, ['class'=>'form-horizontal']); ?>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Jenis Bonus <b class="peringatan">*</b></label>
					<div class="col-sm-10">
						<span class="peringatan"><?php echo form_error('nama_jenis_bonus'); ?></span>
						<?php  
						$form = array(
							'nama_jenis_bonus' => array(
								'name' => 'nama_jenis_bonus', 
								'value'=>set_value('nama_jenis_bonus', isset($form_value['nama_jenis_bonus']) ? $form_value['nama_jenis_bonus'] : ''),
								'class'=>'form-control',
								'placeholder'=>'Umroh, Kalung berlian, Emas, Uang Tunai',
							),
						);
						?>
						<?php echo form_input($form['nama_jenis_bonus']); ?>
					</div>
				</div>


				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Nilai Bonus <b class="peringatan">*</b></label>
					<div class="col-sm-10">
						<span class="peringatan"><?php echo form_error('nilai_bonus'); ?></span>
						<?php
						$form = array(
							'nilai_bonus' => array(
								'name' => 'nilai_bonus', 
								'value'=>set_value('nilai_bonus', isset($form_value['nilai_bonus']) ? $form_value['nilai_bonus'] : ''),
								'class'=>'form-control',
								'placeholder'=>'20000000'
							),
						);
						?>
						<?php echo form_input($form['nilai_bonus']); ?>
					</div>
				</div>

				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Poin <b class="peringatan">*</b></label>
					<div class="col-sm-10">
						<span class="peringatan"><?php echo form_error('poin_bonus'); ?></span>
						<?php
						$form = array(
							'poin_bonus' => array(
								'name' => 'poin_bonus', 
								'value'=>set_value('poin_bonus', isset($form_value['poin_bonus']) ? $form_value['poin_bonus'] : ''),
								'class'=>'form-control',
								'placeholder'=>'9000'
							),
						);
						?>
						<?php echo form_input($form['poin_bonus']); ?>
					</div>
				</div>

				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Bonus Aktif <b class="peringatan">*</b></label>
					<div class="col-sm-10">
					<span class="peringatan"><?php echo form_error('bonus_aktif'); ?></span>
						<label class="radio-inline">
				            <?php echo form_radio('bonus_aktif', '1', set_radio('bonus_aktif', '1', isset($form_value['bonus_aktif']) && $form_value['bonus_aktif'] == '1' ? TRUE : FALSE), array('class'=>'flat')); ?>
				        Ya</label>
				        <label class="radio-inline">
				            <?php echo form_radio('bonus_aktif', '0', set_radio('bonus_aktif', '0', isset($form_value['bonus_aktif']) && $form_value['bonus_aktif'] == '0' ? TRUE : FALSE), array('class'=>'flat')); ?>
				        Tidak</label>
				    </div>
				</div>

				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<?php echo anchor($this->session->userdata('lolin_urlback_backend'), '<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Batal', array('class' => 'btn btn-warning btn-sm' )); ?>
						<?php echo form_submit('submit', "Simpan", array('class'=>'btn btn-dark btn-sm')); ?></p>
					</div>
				</div>

				<?php echo form_close(); ?>

      </div>
    </div>
  </div>
</div>
