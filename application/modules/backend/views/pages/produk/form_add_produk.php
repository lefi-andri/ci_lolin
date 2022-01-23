<div class="card">
  	<div class="card-body">

			<?php echo form_open_multipart($form_action, array('class'=>'form-horizontal')); ?>
			<div class="row">
			  	<div class="col-6">
					<div class="form-group">
						<label for="inputEmail3">Kategori Produk *</label>
							<span class="peringatan"><?php echo form_error('catprodsId'); ?></span>					
							<?php echo form_dropdown('catprodsId', $dd_product_kategori, set_value('catprodsId', isset($form_value['catprodsId']) ? $form_value['catprodsId'] : ''), array('class' => 'form-control select2', 'required' => 'required')); ?>
					</div>

					<div class="form-group">
						<label for="inputEmail3">Kode Produk *</label>
							<span class="peringatan"><?php echo form_error('prodsKode'); ?></span>
							<?php  
							$form = array(
								'prodsKode' => array(
									'name' 			=> 'prodsKode', 
									'value'			=> set_value('prodsKode', isset($form_value['prodsKode']) ? $form_value['prodsKode'] : ''),
									'placeholder' 	=> 'Kode Produk',
									'class'			=> 'form-control',
									'type'			=> 'text',
									'required'		=> 'required',
								),
							);
							?>
							<?php echo form_input($form['prodsKode']); ?>
					</div>

					<div class="form-group">
						<label for="inputEmail3">Nama Produk *</label>
							<span class="peringatan"><?php echo form_error('prodsName'); ?></span>
							<?php
							$form = array(
								'prodsName' => array(
									'name' 			=> 'prodsName', 
									'value'			=> set_value('prodsName', isset($form_value['prodsName']) ? $form_value['prodsName'] : ''),
									'placeholder' 	=> 'Nama Produk',
									'class'			=> 'form-control',
									'type'			=> 'text',
									'required'		=> 'required',
								),
							);
							?>
							<?php echo form_input($form['prodsName']); ?>
					</div>
					<div class="form-group">
						<label for="inputEmail3">Netto Produk <i>dalam ukuran ml</i> *</label>
							<span class="peringatan"><?php echo form_error('prodsNetto'); ?></span>
							<?php
							$form = array(
								'prodsNetto' => array(
									'name' 			=> 'prodsNetto', 
									'value'			=> set_value('prodsNetto', isset($form_value['prodsNetto']) ? $form_value['prodsNetto'] : ''),
									'placeholder' 	=> 'Netto Produk',
									'class'			=> 'form-control',
									'type'			=> 'number',
									'required'		=> 'required',
								),
							);
							?>
							<?php echo form_input($form['prodsNetto']); ?>
					</div>

					<div class="form-group">
						<label for="inputEmail3">Berat Produk (gram)*</label>
							<span class="peringatan"><?php echo form_error('prodsWeight'); ?></span>
							<?php
							$form = array(
								'prodsWeight' => array(
									'name' 			=> 'prodsWeight', 
									'value'			=> set_value('prodsWeight', isset($form_value['prodsWeight']) ? $form_value['prodsWeight'] : ''),
									'placeholder' 	=> 'Berat Produk',
									'class'			=> 'form-control',
									'type'			=> 'number',
									'required'		=> 'required',
								),
							);
							?>
							<?php echo form_input($form['prodsWeight']); ?>
					</div>
			  	</div>
			  	<div class="col-6">
			  		<div class="form-group">
						<label for="inputEmail3">Gambar Dasar Produk *</label>
							<span><?php echo form_error('prodsBasePic'); ?></span>
							<?php
							$form = array(
								'prodsBasePic' => array(
									'name' 			=> 'prodsBasePic', 
									'value'			=> set_value('prodsBasePic', isset($form_value['prodsBasePic']) ? $form_value['prodsBasePic'] : ''),
									'required'		=> 'required',
								),
							);
							?>
							<?php echo form_upload($form['prodsBasePic']); ?>
					</div>

					<div class="form-group">
						<label for="inputEmail3">Caption Gambar Dasar Produk *</label>
							<span><?php echo form_error('prodsBasePicCaption'); ?></span>
							<?php
							$form = array(
								'prodsBasePicCaption' => array(
									'name' 			=> 'prodsBasePicCaption', 
									'value'			=> set_value('prodsBasePicCaption', isset($form_value['prodsBasePicCaption']) ? $form_value['prodsBasePicCaption'] : ''),
									'placeholder' 	=> 'Caption Gambar Dasar Produk',
									'class'			=> 'form-control',
									'type'			=> 'text',
									'required'		=> 'required',
								),
							);
							?>
							<?php echo form_input($form['prodsBasePicCaption']); ?>
					</div>

					<div class="form-group">
						<label for="inputEmail3">Gambar Produk Depan *</label>
							<span class="peringatan"><?php echo form_error('file'); ?></span>
							<?php
							$form = array(
								'file' => array(
									'name' 			=> 'file', 
									'value'			=>set_value('file', isset($form_value['file']) ? $form_value['file'] : ''),
									'required'		=> 'required',
								),
							);
							?>
							<?php echo form_upload($form['file']); ?>
					</div>

					<div class="form-group">
						<label for="inputEmail3">Caption Gambar Produk Depan *</label>
							<span class="peringatan"><?php echo form_error('prodsFrontPicCaption'); ?></span>
							<?php
							$form = array(
								'prodsFrontPicCaption' => array(
									'name' 			=> 'prodsFrontPicCaption', 
									'value'			=> set_value('prodsFrontPicCaption', isset($form_value['prodsFrontPicCaption']) ? $form_value['prodsFrontPicCaption'] : ''),
									'placeholder' 	=> 'Caption Gambar Depan Produk',
									'class'			=> 'form-control',
									'type'			=> 'text',
									'required'		=> 'required',
								),
							);
							?>
							<?php echo form_input($form['prodsFrontPicCaption']); ?>
					</div>

					<div class="form-group">
						<label for="inputEmail3">Gambar Produk Belakang *</label>
							<span class="peringatan"><?php echo form_error('file_headline'); ?></span>
							<?php
							$form = array(
								'file_headline' => array(
									'name' 			=> 'file_headline', 
									'value'			=> set_value('file_headline', isset($form_value['file_headline']) ? $form_value['file_headline'] : ''),		
									'required'		=> 'required',
								),
							);
							?>
							<?php echo form_upload($form['file_headline']); ?>
					</div>

					<div class="form-group">
						<label for="inputEmail3">Caption Gambar Produk Belakang *</label>
							<span class="peringatan"><?php echo form_error('prodsBackPicCaption'); ?></span>
							<?php
							$form = array(
								'prodsBackPicCaption' => array(
									'name' 			=> 'prodsBackPicCaption', 
									'value'			=> set_value('prodsBackPicCaption', isset($form_value['prodsBackPicCaption']) ? $form_value['prodsBackPicCaption'] : ''),
									'placeholder' 	=> 'Caption Gambar Belakang Produk',
									'class'			=> 'form-control',
									'type'			=> 'text',
									'required'		=> 'required',
								),
							);
							?>
							<?php echo form_input($form['prodsBackPicCaption']); ?>
					</div>
			  	</div>
			</div>
						

			

			<div class="row">
				<div class="col-12">
					<div class="form-group">
						<label for="inputEmail3">Deskripsi Produk *</label>
							<span class="peringatan"><?php echo form_error('prodsDesc'); ?></span>
							<?php 
							$prodsDesc = set_value('prodsDesc', isset($form_value['prodsDesc']) ? $form_value['prodsDesc'] : '');
							?>
							<?php
							$form = array(	
								'prodsDesc' => array(
									'name' 			=> 'prodsDesc', 
									'value'			=> set_value('prodsDesc', isset($form_value['prodsDesc']) ? $form_value['prodsDesc'] : ''),
								),
							);
							?>
							<textarea name="prodsDesc" class="form-control ckeditor" required="required"><?php echo $prodsDesc; ?></textarea>
					</div>

					<div class="form-group">
						<label for="inputEmail3">Keyword Produk *</label>
							<span class="peringatan"><?php echo form_error('prodsKeyword'); ?></span>
							<?php
							$form = array(
								'prodsKeyword' => array(
									'name' 			=> 'prodsKeyword', 
									'value'			=> set_value('prodsKeyword', isset($form_value['prodsKeyword']) ? $form_value['prodsKeyword'] : ''),
									'placeholder' 	=> 'Kata Kunci Produk',
									'class'			=> 'form-control',
									'type'			=> 'text',
									'required'		=> 'required',
								),
							);
							?>
							<?php echo form_input($form['prodsKeyword']); ?>
					</div>

					<div class="form-group">
						<label for="inputEmail3">Urutan Produk *</label>
							<span class="peringatan"><?php echo form_error('prodsSort'); ?></span>
							<?php
							$form = array(
								'prodsSort' => array(
									'name' 			=> 'prodsSort', 
									'value'			=> set_value('prodsSort', isset($form_value['prodsSort']) ? $form_value['prodsSort'] : ''),
									'placeholder' 	=> 'Pengurutan Produk',
									'class'			=> 'form-control',
									'type'			=> 'number',
									'required'		=> 'required',
								),
							);
							?>
							<?php echo form_input($form['prodsSort']); ?>
					</div>
					
					<div class="form-group">
						<label for="inputEmail3">Tampilkan Produk *</label>
						<br>
						<span class="peringatan"><?php echo form_error('prodsShow'); ?></span>
							<label class="radio-inline">
					            <?php echo form_radio('prodsShow', '1', set_radio('prodsShow', '1', isset($form_value['prodsShow']) && $form_value['prodsShow'] == '1' ? TRUE : FALSE), array('class' => 'flat')); ?>
					        Ya</label>
					     	<label class="radio-inline">
					            <?php echo form_radio('prodsShow', '0', set_radio('prodsShow', '0', isset($form_value['prodsShow']) && $form_value['prodsShow'] == '0' ? TRUE : FALSE), array('class' => 'flat')); ?>
					        Tidak</label>
					</div>
				</div>
			</div>				
			<div class="row">
				<div class="col-6">
					<div class="form-group">
						<label for="inputEmail3">Harga Satuan Produk *</label>
							<input type="text" name="harga_satuan" class="form-control" required="required">
					</div>

					<div class="row">
						<label for="inputEmail3" class="col-sm-2 control-label">Harga Diskon 1*</label>
						<div class="col-sm-2">
							<input type="number" name="satuan_diskon[]" class="form-control" placeholder="Jumlah Satuan" min="0">
						</div>
						<div class="col-sm-4">
							<input type="number" name="harga_satuan_diskon[]" class="form-control" placeholder="Harga" min="0">
						</div>
						<div class="col-sm-2">
							<input type="number" name="berat[]" class="form-control" placeholder="Berat (Kg)" min="0">
						</div>
					</div>
					<div class="row">
						<label for="inputEmail3" class="col-sm-2 control-label">Harga Diskon 2*</label>
						<div class="col-sm-2">
							<input type="number" name="satuan_diskon[]" class="form-control" placeholder="Jumlah Satuan" min="0">
						</div>
						<div class="col-sm-4">
							<input type="number" name="harga_satuan_diskon[]" class="form-control" placeholder="Harga" min="0">
						</div>
						<div class="col-sm-2">
							<input type="number" name="berat[]" class="form-control" placeholder="Berat (Kg)" min="0">
						</div>
					</div>
					<div class="row">
						<label for="inputEmail3" class="col-sm-2 control-label">Harga Diskon 3*</label>
						<div class="col-sm-2">
							<input type="number" name="satuan_diskon[]" class="form-control" placeholder="Jumlah Satuan" min="0">
						</div>
						<div class="col-sm-4">
							<input type="number" name="harga_satuan_diskon[]" class="form-control" placeholder="Harga" min="0">
						</div>
						<div class="col-sm-2">
							<input type="number" name="berat[]" class="form-control" placeholder="Berat (Kg)" min="0">
						</div>
					</div>
					<div class="row">
						<label for="inputEmail3" class="col-sm-2 control-label">Harga Diskon 4*</label>
						<div class="col-sm-2">
							<input type="number" name="satuan_diskon[]" class="form-control" placeholder="Jumlah Satuan" min="0">
						</div>
						<div class="col-sm-4">
							<input type="number" name="harga_satuan_diskon[]" class="form-control" placeholder="Harga" min="0">
						</div>
						<div class="col-sm-2">
							<input type="number" name="berat[]" class="form-control" placeholder="Berat (Kg)" min="0">
						</div>
					</div>
					<div class="row">
						<label for="inputEmail3" class="col-sm-2 control-label">Harga Diskon 5*</label>
						<div class="col-sm-2">
							<input type="number" name="satuan_diskon[]" class="form-control" placeholder="Jumlah Satuan" min="0">
						</div>
						<div class="col-sm-4">
							<input type="number" name="harga_satuan_diskon[]" class="form-control" placeholder="Harga" min="0">
						</div>
						<div class="col-sm-2">
							<input type="number" name="berat[]" class="form-control" placeholder="Berat (Kg)" min="0">
						</div>
					</div>
					<div class="row">
						<label for="inputEmail3" class="col-sm-2 control-label">Harga Diskon 6*</label>
						<div class="col-sm-2">
							<input type="number" name="satuan_diskon[]" class="form-control" placeholder="Jumlah Satuan" min="0">
						</div>
						<div class="col-sm-4">
							<input type="number" name="harga_satuan_diskon[]" class="form-control" placeholder="Harga" min="0">
						</div>
						<div class="col-sm-2">
							<input type="number" name="berat[]" class="form-control" placeholder="Berat (Kg)" min="0">
						</div>
					</div>
				</div>
				<div class="col-6">
					<div class="form-group">
						<label for="inputEmail3">Poin *</label>
							<?php  
							$group_reseller = $this->db->query("SELECT * FROM groups WHERE name != 'admin' and name != 'web_developer'");
							foreach ($group_reseller->result() as $group) {
							?>
							<p><?php echo $group->description; ?></p>
							<?php echo form_hidden('group_id[]', $group->id); ?>

							<p><?php echo form_input('poinNilai[]', '', array('required'=>'required', 'class'=>'form-control')); ?></p>
							<?php
							}
							?>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="form-group">
						<label for="inputEmail3">Aturan *</label>
							<?php 
							$prodsDirections = set_value('prodsDirections', isset($form_value['prodsDirections']) ? $form_value['prodsDirections'] : '');
							?>
							<textarea name="prodsDirections" class="form-control ckeditor" required="required"><?php echo $prodsDirections; ?></textarea>
					</div>
					<div class="form-group">
						<label for="inputEmail3">Bahan *</label>
							<?php 
							$prodsIngredients = set_value('prodsIngredients', isset($form_value['prodsIngredients']) ? $form_value['prodsIngredients'] : '');
							?>
							<textarea name="prodsIngredients" class="form-control ckeditor" required="required"><?php echo $prodsIngredients; ?></textarea>
					</div>
					<div class="form-group">
						<label for="inputEmail3">Nomor BPOM *</label>
							<?php 
							$nomor_bpom = set_value('nomor_bpom', isset($form_value['nomor_bpom']) ? $form_value['nomor_bpom'] : '');
							?>
							<textarea name="nomor_bpom" class="form-control ckeditor" required="required"><?php echo $nomor_bpom; ?></textarea>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-6">
					<div class="form-group">
						<label for="inputEmail3">Merchant *</label>
						<br>
							<?php  
							$data_merchant = $this->db->get_where('merchant', array('tampilkan_merchant'=>1));
							foreach ($data_merchant->result() as $key => $value) {
							?>
								<label>
									<input name="merchant[]" type="checkbox" class='' value="<?php echo $value->id_merchant; ?>"> <?php echo $value->nama_merchant; ?>
								</label>
							<?php
							}
							?>
					</div>
				</div>
				<div class="col-6">

				</div>
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