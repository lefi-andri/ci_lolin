<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Update sosial media website</h2>
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
					<label for="inputEmail3" class="col-sm-2 control-label">Type Sosial Media  <b class="peringatan">*</b></label>
					<div class="col-sm-10">
						<span class="peringatan"><?php echo form_error('socialType'); ?></span>
						<?php  
						$form = array(
							'socialType' => array(
								'name' => 'socialType', 
								'value'=>set_value('socialType', isset($form_value['socialType']) ? $form_value['socialType'] : ''),
								'class'=>'form-control'
							),
						);
						?>
						<?php echo form_input($form['socialType']); ?>
					</div>
				</div>

				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Nama Sosial Media  <b class="peringatan">*</b></label>
					<div class="col-sm-10">
						<span class="peringatan"><?php echo form_error('socialName'); ?></span>
						<?php
						$form = array(
							'socialName' => array(
								'name' => 'socialName', 
								'value'=>set_value('socialName', isset($form_value['socialName']) ? $form_value['socialName'] : ''),
								'class'=>'form-control'
							),
						);
						?>
						<?php echo form_input($form['socialName']); ?>
					</div>
				</div>

				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Sosial Remark  <b class="peringatan">*</b></label>
					<div class="col-sm-10">
						<span class="peringatan"><?php echo form_error('socialRemark'); ?></span>
						<?php
						$form = array(
							'socialRemark' => array(
								'name' => 'socialRemark', 
								'value'=>set_value('socialRemark', isset($form_value['socialRemark']) ? $form_value['socialRemark'] : ''),
								'class'=>'form-control'
							),
						);
						?>
						<?php echo form_input($form['socialRemark']); ?>
					</div>
				</div>

				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Sosial Value  <b class="peringatan">*</b></label>
					<div class="col-sm-10">
						<span class="peringatan"><?php echo form_error('socialValue'); ?></span>
						<?php 
						$socialValue = set_value('socialValue', isset($form_value['socialValue']) ? $form_value['socialValue'] : '');
						?>
						<textarea name="socialValue" class="form-control ckeditor"><?php echo $socialValue; ?></textarea>
					</div>
				</div>

				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Sosial Media Ditampilkan  <b class="peringatan">*</b></label>
					<span class="peringatan"><?php echo form_error('socialStatus'); ?></span>
					<div class="col-sm-10">
				        <label class="radio-inline">
				            <?php echo form_radio('socialStatus', 'y', set_radio('socialStatus', 'y', isset($form_value['socialStatus']) && $form_value['socialStatus'] == 'y' ? TRUE : FALSE), array('class' => 'flat')); ?>
				         Ya</label>
				        <label class="radio-inline">
				            <?php echo form_radio('socialStatus', 'n', set_radio('socialStatus', 'n', isset($form_value['socialStatus']) && $form_value['socialStatus'] == 'n' ? TRUE : FALSE), array('class' => 'flat')); ?>
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