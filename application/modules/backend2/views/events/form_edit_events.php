<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Update event</h2>
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
        
				<?php echo form_open_multipart($form_action, array('class'=>'form-horizontal')); ?>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Nama Event <b class="peringatan">*</b></label>
					<div class="col-sm-10">
						<span class="peringatan"><?php echo form_error('eventsName'); ?></span>
						<?php  
						$form = array(
							'eventsName' => array(
								'name' => 'eventsName', 
								'value'=>set_value('eventsName', isset($form_value['eventsName']) ? $form_value['eventsName'] : ''),
								'class'=>'form-control'
							),
						);
						?>
						<?php echo form_input($form['eventsName']); ?>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Deskripsi Event <b class="peringatan">*</b></label>
					<div class="col-sm-10">
						<span class="peringatan"><?php echo form_error('eventsDesc'); ?></span>
						<?php 
						$eventsDesc = set_value('eventsDesc', isset($form_value['eventsDesc']) ? $form_value['eventsDesc'] : '');
						?>
						<textarea name="eventsDesc" class="form-control ckeditor"><?php echo $eventsDesc; ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Tanggal Event <b class="peringatan">*</b></label>
					<div class="col-sm-10">
						<span class="peringatan"><?php echo form_error('eventsDate'); ?></span>
						<?php
						$form = array(
							'eventsDate' => array(
								'name' => 'eventsDate', 
								'value'=>set_value('eventsDate', isset($form_value['eventsDate']) ? $form_value['eventsDate'] : ''),
								'id'	=> 'tglevent',
								'class'=>'form-control'
							),
						);
						?>
						<?php echo form_input($form['eventsDate']); ?>
					</div>
				</div>
				<script type="text/javascript">
			        $(document).ready(function() {
			          $('#tglevent').daterangepicker({
			            singleDatePicker: true,
			            calender_style: "picker_2",
			            format: "YYYY-MM-DD"
			          }, function(start, end, label) {
			            console.log(start.toISOString(), end.toISOString(), label);
			          });
			        });
			    </script>	
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Tempat Event <b class="peringatan">*</b></label>
					<div class="col-sm-10">
						<span class="peringatan"><?php echo form_error('eventsVenue'); ?></span>
						<?php
						$form = array(
							'eventsVenue' => array(
								'name' => 'eventsVenue', 
								'value'=>set_value('eventsVenue', isset($form_value['eventsVenue']) ? $form_value['eventsVenue'] : ''),
								'class'=>'form-control'
							),
						);
						?>
						<?php echo form_input($form['eventsVenue']); ?>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Gambar Utama <b class="peringatan">*</b></label>
					<div class="col-sm-10">
						<span class="peringatan"><?php echo form_error('file'); ?></span>
						<?php
						$form = array(
							'file' => array(
								'name' => 'file', 
								'value'=>set_value('file', isset($form_value['file']) ? $form_value['file'] : ''),		
							),
						);
						?>
						<?php echo form_upload($form['file']); ?>
					</div>	
				</div>		
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Events Sort <b class="peringatan">*</b></label>
					<div class="col-sm-10">
						<span class="peringatan"><?php echo form_error('eventsSort'); ?></span>
						<?php
						$form = array(
							'eventsSort' => array(
								'name' => 'eventsSort', 
								'value'=>set_value('eventsSort', isset($form_value['eventsSort']) ? $form_value['eventsSort'] : ''),
								'class'=>'form-control'
							),
						);
						?>
						<?php echo form_input($form['eventsSort']); ?>
					</div>
				</div>		

				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Tampilkan Event <b class="peringatan">*</b></label>
					<div class="col-sm-10">
					<span class="peringatan"><?php echo form_error('eventsShow'); ?></span>
						<label class="radio-inline">
				            <?php echo form_radio('eventsShow', 'y', set_radio('eventsShow', 'y', isset($form_value['eventsShow'])&& $form_value['eventsShow'] == 'y' ? TRUE : FALSE), array('class' => 'flat')); ?>
				        Ya</label>
				       	<label class="radio-inline">
				            <?php echo form_radio('eventsShow', 'n', set_radio('eventsShow', 'n', isset($form_value['eventsShow']) && $form_value['eventsShow'] == 'n' ? TRUE : FALSE), array('class' => 'flat')); ?>
				        Tidak</label>
				        
				    </div>
				</div>

				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<?php echo anchor($this->session->userdata('lolin_urlback_backend'), '<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Batal', array('class' => 'btn btn-warning btn-sm' )); ?>
						<?php echo form_submit('submit', 'Simpan', array('class'=>'btn btn-dark btn-sm')); ?>
					</div>
				</div>
				<?php echo form_close(); ?>	
      </div>
    </div>
  </div>
</div>