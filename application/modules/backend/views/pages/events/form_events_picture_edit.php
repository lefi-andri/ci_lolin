<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Update foto event</h2>
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

				<?php echo form_open_multipart($form_action, ['class'=>'form-horizontal']); ?>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Foto Event <b class="peringatan">*</b></label>
					<div class="col-sm-10">
						<span><?php echo form_error('eventsPicImage'); ?></span>
						<?php  
							$form = array(
								'eventsPicImage' => array(
									'name' => 'eventsPicImage', 
									'value'=>set_value('eventsPicImage', isset($form_value['eventsPicImage']) ? $form_value['eventsPicImage'] : ''),		
								),
							);
						?>
						<?php echo form_upload($form['eventsPicImage']); ?>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Caption Foto <b class="peringatan">*</b></label>
					<div class="col-sm-10">
						<span><?php echo form_error('eventsPicName'); ?></span>
						<?php
							$form = array(
								'eventsPicName' => array(
									'name' => 'eventsPicName', 
									'value'=>set_value('eventsPicName', isset($form_value['eventsPicName']) ? $form_value['eventsPicName'] : ''),
									'class'=>'form-control'
								),
							);
						?>
						<?php echo form_input($form['eventsPicName']); ?>
					</div>
				</div>
				
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Pengurutan Foto Event <b class="peringatan">*</b></label>
					<div class="col-sm-10">
						<span class="peringatan"><?php echo form_error('eventsPicSort'); ?></span>
						<?php
							$form = array(
								'eventsPicSort' => array(
									'name' => 'eventsPicSort', 
									'value'=>set_value('eventsPicSort', isset($form_value['eventsPicSort']) ? $form_value['eventsPicSort'] : ''),
									'class'=>'form-control'
								),
							);
						?>
						<?php echo form_input($form['eventsPicSort']); ?>
					</div>
				</div>

				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Foto Ditampilkan <b class="peringatan">*</b></label>
					<div class="col-sm-10">
					<span class="peringatan"><?php echo form_error('eventsPicShow'); ?></span>
						<label class="radio-inline">
				            <?php echo form_radio('eventsPicShow', '1', set_radio('eventsPicShow', '1', isset($form_value['eventsPicShow']) && $form_value['eventsPicShow'] == '1' ? TRUE : FALSE), array('class' => 'flat')); ?>
				        Ya</label>
				        <label class="radio-inline">
				            <?php echo form_radio('eventsPicShow', '0', set_radio('eventsPicShow', '0', isset($form_value['eventsPicShow']) && $form_value['eventsPicShow'] == '0' ? TRUE : FALSE), array('class' => 'flat')); ?>
				        Tidak</label>
				    </div>
				</div>

				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<?php echo anchor($this->session->userdata('lolin_urlback_backend'), '<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Batal', array('class' => 'btn btn-warning btn-sm' )); ?>
						<?php echo form_submit('submit', 'Update', array('class'=>'btn btn-dark btn-sm')); ?>
					</div>
				</div>
				<?php echo form_close(); ?>

      </div>
    </div>
  </div>
</div>