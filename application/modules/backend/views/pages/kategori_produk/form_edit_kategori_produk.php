<div class="card">
  <div class="card-body">
    <?php echo form_open_multipart($form_action, array('class'=>'form-horizontal')); ?>
		<div class="form-group">
			<label for="catprodsName">Nama Kategori Produk*</label>
				<span class="peringatan"><?php echo form_error('catprodsName'); ?></span>
				<?php  
					$form = array(
						'catprodsName' => array(
							'id' => 'catprodsName',
							'name' => 'catprodsName', 
							'value'=>set_value('catprodsName', isset($form_value['catprodsName']) ? $form_value['catprodsName'] : ''),
							'class'=>'form-control',
							'required' => 'required',
							'type' => 'text',
						),
					);
				?>
				<?php echo form_input($form['catprodsName']); ?>
		</div>

		<div class="form-group">
			<label for="catprodsSort">Urutan Product*</label>
				<span class="peringatan"><?php echo form_error('catprodsSort'); ?></span>
				<?php
					$form = array(
						'catprodsSort' => array(
							'id' => 'catprodsSort',
							'name' => 'catprodsSort', 
							'value'=>set_value('catprodsSort', isset($form_value['catprodsSort']) ? $form_value['catprodsSort'] : ''),
							'class'=>'form-control',
							'required' => 'required',
							'type' => 'number',
						),
					);
				?>
				<?php echo form_input($form['catprodsSort']); ?>
		</div>

		<div class="form-group">
			<label for="catprodsNavbarPicture">Gambar Di Navbar</label>
			<br>
				<span class="peringatan"><?php echo form_error('catprodsNavbarPicture'); ?></span>
				<?php
					$form = array(
						'catprodsNavbarPicture' => array(
							'id' => 'catprodsNavbarPicture',
							'name' => 'catprodsNavbarPicture', 
							'value'=>set_value('catprodsNavbarPicture', isset($form_value['catprodsNavbarPicture']) ? $form_value['catprodsNavbarPicture'] : ''),		
						),
					);
				?>
				<?php echo form_upload($form['catprodsNavbarPicture']); ?>
				<small id="emailHelp" class="form-text text-muted">Jika tidak ada boleh dikosongkan.</small>
		</div>

		<div class="form-group">
			<label for="inputEmail3">Tampilkan Kategori Produk *</label>
			<br>
			<span class="peringatan"><?php echo form_error('catprodsShow'); ?></span>
				<label class="radio-inline">
		            <?php echo form_radio('catprodsShow', 'y', set_radio('catprodsShow', 'y', isset($form_value['catprodsShow']) && $form_value['catprodsShow'] == 'y' ? TRUE : FALSE), array('class' => 'flat')); ?>
		        Ya</label>
		        <label class="radio-inline">
		            <?php echo form_radio('catprodsShow', 'n', set_radio('catprodsShow', 'n', isset($form_value['catprodsShow']) && $form_value['catprodsShow'] == 'n' ? TRUE : FALSE), array('class' => 'flat')); ?>
		        Tidak</label>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<?php echo anchor($this->session->userdata('lolin_urlback_backend'), '<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Batal', array('class' => 'btn btn-default btn-sm' )); ?>
				<?php echo form_submit('submit', 'Simpan', array('class'=>'btn btn-primary btn-sm')); ?>
			</div>
		</div>

		<?php echo form_close(); ?>
  </div>
</div>