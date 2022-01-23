<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Edit merchant</h2>
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
					<label for="inputEmail3" class="col-sm-2 control-label">Nama Merchant <b class="peringatan">*</b></label>
					<div class="col-sm-6">
						<span class="peringatan"><?php echo form_error('nama_merchant'); ?></span>
						<?php  
						$form = array(
							'nama_merchant' => array(
								'name' => 'nama_merchant', 
								'value'=>set_value('nama_merchant', isset($form_value['nama_merchant']) ? $form_value['nama_merchant'] : ''),
								'class'=>'form-control'
							),
						);
						?>
						<?php echo form_input($form['nama_merchant']); ?>
					</div>
				</div>

				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Deskripsi Merchant <b class="peringatan">*</b></label>
					<div class="col-sm-6">
						<span class="peringatan"><?php echo form_error('deskripsi_merchant'); ?></span>
						<?php  
						$form = array(
							'deskripsi_merchant' => array(
								'name' => 'deskripsi_merchant', 
								'value'=>set_value('deskripsi_merchant', isset($form_value['deskripsi_merchant']) ? $form_value['deskripsi_merchant'] : ''),
								'class'=>'form-control'
							),
						);
						?>
						<?php echo form_input($form['deskripsi_merchant']); ?>
					</div>
				</div>

				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Gambar Di Navbar</label>
					<div class="col-sm-10">
						<span class="peringatan"><?php echo form_error('gambar_logo_merchant'); ?></span>
						<?php  
						$form = array(
							'gambar_logo_merchant' => array(
								'name' => 'gambar_logo_merchant', 
								'value'=>set_value('gambar_logo_merchant', isset($form_value['gambar_logo_merchant']) ? $form_value['gambar_logo_merchant'] : ''),		
							),
						);
						?>
						<?php echo form_upload($form['gambar_logo_merchant']); ?>
						<p>Jika tidak ada boleh dikosongkan</p>
					</div>
				</div>

				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Link Merchant <b class="peringatan">*</b></label>
					<div class="col-sm-6">
						<span class="peringatan"><?php echo form_error('link_merchant'); ?></span>
						<?php  
						$form = array(
							'link_merchant' => array(
								'name' => 'link_merchant', 
								'value'=>set_value('link_merchant', isset($form_value['link_merchant']) ? $form_value['link_merchant'] : ''),
								'class'=>'form-control'
							),
						);
						?>
						<?php echo form_input($form['link_merchant']); ?>
					</div>
				</div>

				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Urutan Merchant <b class="peringatan">*</b></label>
					<div class="col-sm-2">
						<span class="peringatan"><?php echo form_error('urutan_merchant'); ?></span>
						<?php  
						$form = array(
							'urutan_merchant' => array(
								'name' => 'urutan_merchant', 
								'value'=>set_value('urutan_merchant', isset($form_value['urutan_merchant']) ? $form_value['urutan_merchant'] : ''),
								'class'=>'form-control'
							),
						);
						?>
						<?php echo form_input($form['urutan_merchant']); ?>
					</div>
				</div>

				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Tampilkan Merchant <b class="peringatan">*</b></label>
					<div class="col-sm-10">
					<span class="peringatan"><?php echo form_error('tampilkan_merchant'); ?></span>
						<label class="radio-inline">
				            <?php echo form_radio('tampilkan_merchant', '1', set_radio('tampilkan_merchant', '1', isset($form_value['tampilkan_merchant']) && $form_value['tampilkan_merchant'] == '1' ? TRUE : FALSE), array('class' => 'flat')); ?>
				        Ya</label>
				        <label class="radio-inline">
				            <?php echo form_radio('tampilkan_merchant', '0', set_radio('tampilkan_merchant', '0', isset($form_value['tampilkan_merchant']) && $form_value['tampilkan_merchant'] == '0' ? TRUE : FALSE), array('class' => 'flat')); ?>
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