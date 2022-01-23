<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Update kategori produk</h2>
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
					<label for="inputEmail3" class="col-sm-2 control-label">Nama Kategori Produk <b class="peringatan">*</b></label>
					<div class="col-sm-10">
						<span class="peringatan"><?php echo form_error('catprodsName'); ?></span>
						<?php  
							$form = array(
								'catprodsName' => array(
									'name' => 'catprodsName', 
									'value'=>set_value('catprodsName', isset($form_value['catprodsName']) ? $form_value['catprodsName'] : ''),
									'class'=>'form-control'
								),
							);
						?>
						<?php echo form_input($form['catprodsName']); ?>
					</div>
				</div>

				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Urutan Product <b class="peringatan">*</b></label>
					<div class="col-sm-10">
						<span class="peringatan"><?php echo form_error('catprodsSort'); ?></span>
						<?php
							$form = array(
								'catprodsSort' => array(
									'name' => 'catprodsSort', 
									'value'=>set_value('catprodsSort', isset($form_value['catprodsSort']) ? $form_value['catprodsSort'] : ''),
									'class'=>'form-control'
								),
							);
						?>
						<?php echo form_input($form['catprodsSort']); ?>
					</div>
				</div>

				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Gambar Di Navbar</label>
					<div class="col-sm-10">
						<span class="peringatan"><?php echo form_error('catprodsNavbarPicture'); ?></span>
						<?php
							$form = array(
								'catprodsNavbarPicture' => array(
									'name' => 'catprodsNavbarPicture', 
									'value'=>set_value('catprodsNavbarPicture', isset($form_value['catprodsNavbarPicture']) ? $form_value['catprodsNavbarPicture'] : ''),		
								),
							);
						?>
						<?php echo form_upload($form['catprodsNavbarPicture']); ?>
						<p>Jika tidak ada boleh dikosongkan</p>
					</div>
				</div>

				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Tampilkan Kategori Produk <b class="peringatan">*</b></label>
					<div class="col-sm-10">
					<span class="peringatan"><?php echo form_error('catprodsShow'); ?></span>
						<label class="radio-inline">
				            <?php echo form_radio('catprodsShow', 'y', set_radio('catprodsShow', 'y', isset($form_value['catprodsShow']) && $form_value['catprodsShow'] == 'y' ? TRUE : FALSE), array('class' => 'flat')); ?>
				        Ya</label>
				        <label class="radio-inline">
				            <?php echo form_radio('catprodsShow', 'n', set_radio('catprodsShow', 'n', isset($form_value['catprodsShow']) && $form_value['catprodsShow'] == 'n' ? TRUE : FALSE), array('class' => 'flat')); ?>
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