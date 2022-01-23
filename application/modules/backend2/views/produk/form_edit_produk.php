<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Update produk</h2>
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
					<label for="inputEmail3" class="col-sm-2 control-label">Kategori Produk <b class="peringatan">*</b></label>
					<div class="col-sm-4">
						<span class="peringatan"><?php echo form_error('catprodsId'); ?></span>					
						<?php echo form_dropdown('catprodsId', $dd_product_kategori, set_value('catprodsId', isset($form_value['catprodsId']) ? $form_value['catprodsId'] : ''), array('class' => 'form-control select2' )); ?>
					</div>
				</div>

				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Kode Produk <b class="peringatan">*</b></label>
					<div class="col-sm-4">
						<span class="peringatan"><?php echo form_error('prodsKode'); ?></span>
						<?php  
						$form = array(
							'prodsKode' => array(
								'name' 			=> 'prodsKode', 
								'value'			=> set_value('prodsKode', isset($form_value['prodsKode']) ? $form_value['prodsKode'] : ''),
								'placeholder' 	=> 'Kode Produk',
								'class'			=> 'form-control'
							),
						);
						?>
						<?php echo form_input($form['prodsKode']); ?>
					</div>
				</div>

				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Nama Produk <b class="peringatan">*</b></label>
					<div class="col-sm-8">
						<span class="peringatan"><?php echo form_error('prodsName'); ?></span>
						<?php
						$form = array(
							'prodsName' => array(
								'name' 			=> 'prodsName', 
								'value'			=> set_value('prodsName', isset($form_value['prodsName']) ? $form_value['prodsName'] : ''),
								'placeholder' 	=> 'Nama Produk',
								'class'			=> 'form-control'
							),
						);
						?>
						<?php echo form_input($form['prodsName']); ?>
					</div>
				</div>

				<hr>	

				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Gambar Dasar Produk <b class="peringatan">*</b></label>
					<div class="col-sm-10">
						<span><?php echo form_error('prodsBasePic'); ?></span>
						<?php
						$form = array(
							'prodsBasePic' => array(
								'name' 			=> 'prodsBasePic', 
								'value'			=> set_value('prodsBasePic', isset($form_value['prodsBasePic']) ? $form_value['prodsBasePic'] : ''),		
							),
						);
						?>
						<?php echo form_upload($form['prodsBasePic']); ?>
					</div>			
				</div>

				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Caption Gambar Dasar Produk <b class="peringatan">*</b></label>
					<div class="col-sm-10">
						<span><?php echo form_error('prodsBasePicCaption'); ?></span>
						<?php
						$form = array(
							'prodsBasePicCaption' => array(
								'name' 			=> 'prodsBasePicCaption', 
								'value'			=> set_value('prodsBasePicCaption', isset($form_value['prodsBasePicCaption']) ? $form_value['prodsBasePicCaption'] : ''),
								'placeholder' 	=> 'Caption Gambar Dasar Produk',
								'class'			=> 'form-control'
							),
						);
						?>
						<?php echo form_input($form['prodsBasePicCaption']); ?>
					</div>
				</div>

				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Gambar Produk Depan <b class="peringatan">*</b></label>
					<div class="col-sm-10">
						<span class="peringatan"><?php echo form_error('file'); ?></span>
						<?php
						$form = array(
							'file' => array(
								'name' 			=> 'file', 
								'value'			=>set_value('file', isset($form_value['file']) ? $form_value['file'] : ''),		
							),
						);
						?>
						<?php echo form_upload($form['file']); ?>
					</div>		
				</div>

				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Caption Gambar Produk Depan <b class="peringatan">*</b></label>
					<div class="col-sm-10">
						<span class="peringatan"><?php echo form_error('prodsFrontPicCaption'); ?></span>
						<?php
						$form = array(
							'prodsFrontPicCaption' => array(
								'name' 			=> 'prodsFrontPicCaption', 
								'value'			=> set_value('prodsFrontPicCaption', isset($form_value['prodsFrontPicCaption']) ? $form_value['prodsFrontPicCaption'] : ''),
								'placeholder' 	=> 'Caption Gambar Depan Produk',
								'class'			=> 'form-control'
							),
						);
						?>
						<?php echo form_input($form['prodsFrontPicCaption']); ?>
					</div>
				</div>

				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Gambar Produk Belakang <b class="peringatan">*</b></label>
					<div class="col-sm-10">
						<span class="peringatan"><?php echo form_error('file_headline'); ?></span>
						<?php
						$form = array(
							'file_headline' => array(
								'name' 			=> 'file_headline', 
								'value'			=> set_value('file_headline', isset($form_value['file_headline']) ? $form_value['file_headline'] : ''),		
							),
						);
						?>
						<?php echo form_upload($form['file_headline']); ?>
					</div>			
				</div>

				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Caption Gambar Produk Belakang <b class="peringatan">*</b></label>
					<div class="col-sm-10">
						<span class="peringatan"><?php echo form_error('prodsBackPicCaption'); ?></span>
						<?php
						$form = array(
							'prodsBackPicCaption' => array(
								'name' 			=> 'prodsBackPicCaption', 
								'value'			=> set_value('prodsBackPicCaption', isset($form_value['prodsBackPicCaption']) ? $form_value['prodsBackPicCaption'] : ''),
								'placeholder' 	=> 'Caption Gambar Belakang Produk',
								'class'			=> 'form-control'
							),
						);
						?>
						<?php echo form_input($form['prodsBackPicCaption']); ?>
					</div>
				</div>

				<hr>

				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Netto Produk <i>dalam ukuran ml</i> <b class="peringatan">*</b></label>
					<div class="col-sm-2">
						<span class="peringatan"><?php echo form_error('prodsNetto'); ?></span>
						<?php
						$form = array(
							'prodsNetto' => array(
								'name' 			=> 'prodsNetto', 
								'value'			=> set_value('prodsNetto', isset($form_value['prodsNetto']) ? $form_value['prodsNetto'] : ''),
								'placeholder' 	=> 'Netto Produk',
								'class'			=> 'form-control'
							),
						);
						?>
						<?php echo form_input($form['prodsNetto']); ?>
					</div>
				</div>

				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Berat Produk (gram)*</label>
					<div class="col-sm-2">
						<span class="peringatan"><?php echo form_error('prodsWeight'); ?></span>
						<?php
						$form = array(
							'prodsWeight' => array(
								'name' 			=> 'prodsWeight', 
								'value'			=> set_value('prodsWeight', isset($form_value['prodsWeight']) ? $form_value['prodsWeight'] : ''),
								'placeholder' 	=> 'Berat Produk',
								'class'			=> 'form-control'
							),
						);
						?>
						<?php echo form_input($form['prodsWeight']); ?>
					</div>
				</div>

				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Deskripsi Produk <b class="peringatan">*</b></label>
					<div class="col-sm-10">
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
						<textarea name="prodsDesc" class="form-control ckeditor"><?php echo $prodsDesc; ?></textarea>
					</div>
				</div>

				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Keyword Produk <b class="peringatan">*</b></label>
					<div class="col-sm-10">
						<span class="peringatan"><?php echo form_error('prodsKeyword'); ?></span>
						<?php
						$form = array(
							'prodsKeyword' => array(
								'name' 			=> 'prodsKeyword', 
								'value'			=> set_value('prodsKeyword', isset($form_value['prodsKeyword']) ? $form_value['prodsKeyword'] : ''),
								'placeholder' 	=> 'Kata Kunci Produk',
								'class'			=> 'form-control'
							),
						);
						?>
						<?php echo form_input($form['prodsKeyword']); ?>
					</div>
				</div>

				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Urutan Product <b class="peringatan">*</b></label>
					<div class="col-sm-10">
						<span class="peringatan"><?php echo form_error('prodsSort'); ?></span>
						<?php
						$form = array(
							'prodsSort' => array(
								'name' 			=> 'prodsSort', 
								'value'			=> set_value('prodsSort', isset($form_value['prodsSort']) ? $form_value['prodsSort'] : ''),
								'placeholder' 	=> 'Pengurutan Produk',
								'class'			=> 'form-control'
							),
						);
						?>
						<?php echo form_input($form['prodsSort']); ?>
					</div>
				</div>

				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Tampilkan Produk <b class="peringatan">*</b></label>
					<div class="col-sm-10">
					<span class="peringatan"><?php echo form_error('prodsShow'); ?></span>
						<label class="radio-inline">
				            <?php echo form_radio('prodsShow', '1', set_radio('prodsShow', '1', isset($form_value['prodsShow']) && $form_value['prodsShow'] == '1' ? TRUE : FALSE), array('class' => 'flat')); ?>
				        Ya</label>
				     	<label class="radio-inline">
				            <?php echo form_radio('prodsShow', '0', set_radio('prodsShow', '0', isset($form_value['prodsShow']) && $form_value['prodsShow'] == '0' ? TRUE : FALSE), array('class' => 'flat')); ?>
				        Tidak</label>
				    </div>
				</div>

				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Poin <b class="peringatan">*</b></label>
					<div class="col-sm-4">
						<?php
						$this->db->select('*');
						$this->db->from('product');
						$this->db->join('poin', 'poin.prodsId = product.prodsId');
						$this->db->join('groups', 'groups.id = poin.group_id');
						$this->db->where('product.prodsId', $id);
						$group_reseller = $this->db->get();
						
						foreach ($group_reseller->result() as $group) {
						?>
						<p><?php echo $group->description; ?></p>
						<?php echo form_hidden('poinId[]', $group->poinId); ?>
						<p><?php echo form_input('poinNilai[]', $group->poinNilai, array('required'=>'required', 'class'=>'form-control')); ?></p>
						<?php
						}
						?>
					</div>
				</div>

				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Harga Satuan Produk <b class="peringatan">*</b></label>
					<div class="col-sm-10">
						<input type="text" name="harga_satuan" class="form-control" value="<?php echo set_value('prodsPrice', isset($form_value['prodsPrice']) ? $form_value['prodsPrice'] : '') ?>" required="required">
					</div>
				</div>

				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Harga Diskon 1<b class="peringatan">*</b></label>
					<div class="col-sm-2">
						<?php  
						$produk_id = $form_value['prodsId'];
						$diskon_1 = $this->db->get_where('diskon_harga', array('produk_id' => $produk_id, 'diskon_urutan' => '1'))->row();
						?>
						<input type="hidden" name="diskon_id[]" value="<?php echo $diskon_1->diskon_id; ?>">
						<input type="number" name="satuan_diskon[]" class="form-control" placeholder="Jumlah Satuan" min="0" value="<?php echo $diskon_1->jumlah_unit; ?>">
					</div>
					<div class="col-sm-4">
						<input type="number" name="harga_satuan_diskon[]" class="form-control" placeholder="Harga" min="0" value="<?php echo $diskon_1->harga_jumlah_unit; ?>">
					</div>
					<div class="col-sm-2">
						<input type="number" name="berat[]" class="form-control" placeholder="Berat (Kg)" min="0" value="<?php echo $diskon_1->berat; ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Harga Diskon 2<b class="peringatan">*</b></label>
					<div class="col-sm-2">
						<?php  
						$produk_id = $form_value['prodsId'];
						$diskon_2 = $this->db->get_where('diskon_harga', array('produk_id' => $produk_id, 'diskon_urutan' => '2'))->row();
						?>
						<input type="hidden" name="diskon_id[]" value="<?php echo $diskon_2->diskon_id; ?>">
						<input type="number" name="satuan_diskon[]" class="form-control" placeholder="Jumlah Satuan" min="0" value="<?php echo $diskon_2->jumlah_unit; ?>">
					</div>
					<div class="col-sm-4">
						<input type="number" name="harga_satuan_diskon[]" class="form-control" placeholder="Harga" min="0" value="<?php echo $diskon_2->harga_jumlah_unit; ?>">
					</div>
					<div class="col-sm-2">
						<input type="number" name="berat[]" class="form-control" placeholder="Berat (Kg)" min="0" value="<?php echo $diskon_2->berat; ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Harga Diskon 3<b class="peringatan">*</b></label>
					<div class="col-sm-2">
						<?php  
						$produk_id = $form_value['prodsId'];
						$diskon_3 = $this->db->get_where('diskon_harga', array('produk_id' => $produk_id, 'diskon_urutan' => '3'))->row();
						?>
						<input type="hidden" name="diskon_id[]" value="<?php echo $diskon_3->diskon_id; ?>">
						<input type="number" name="satuan_diskon[]" class="form-control" placeholder="Jumlah Satuan" min="0" value="<?php echo $diskon_3->jumlah_unit; ?>">
					</div>
					<div class="col-sm-4">
						<input type="number" name="harga_satuan_diskon[]" class="form-control" placeholder="Harga" min="0" value="<?php echo $diskon_3->harga_jumlah_unit; ?>">
					</div>
					<div class="col-sm-2">
						<input type="number" name="berat[]" class="form-control" placeholder="Berat (Kg)" min="0" value="<?php echo $diskon_3->berat; ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Harga Diskon 4<b class="peringatan">*</b></label>
					<div class="col-sm-2">
						<?php  
						$produk_id = $form_value['prodsId'];
						$diskon_4 = $this->db->get_where('diskon_harga', array('produk_id' => $produk_id, 'diskon_urutan' => '4'))->row();
						?>
						<input type="hidden" name="diskon_id[]" value="<?php echo $diskon_4->diskon_id; ?>">
						<input type="number" name="satuan_diskon[]" class="form-control" placeholder="Jumlah Satuan" min="0" value="<?php echo $diskon_4->jumlah_unit; ?>">
					</div>
					<div class="col-sm-4">
						<input type="number" name="harga_satuan_diskon[]" class="form-control" placeholder="Harga" min="0" value="<?php echo $diskon_4->harga_jumlah_unit; ?>">
					</div>
					<div class="col-sm-2">
						<input type="number" name="berat[]" class="form-control" placeholder="Berat (Kg)" min="0" value="<?php echo $diskon_4->berat; ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Harga Diskon 5<b class="peringatan">*</b></label>
					<div class="col-sm-2">
						<?php  
						$produk_id = $form_value['prodsId'];
						$diskon_5 = $this->db->get_where('diskon_harga', array('produk_id' => $produk_id, 'diskon_urutan' => '5'))->row();
						?>
						<input type="hidden" name="diskon_id[]" value="<?php echo $diskon_5->diskon_id; ?>">
						<input type="number" name="satuan_diskon[]" class="form-control" placeholder="Jumlah Satuan" min="0" value="<?php echo $diskon_5->jumlah_unit; ?>">
					</div>
					<div class="col-sm-4">
						<input type="number" name="harga_satuan_diskon[]" class="form-control" placeholder="Harga" min="0" value="<?php echo $diskon_5->harga_jumlah_unit; ?>">
					</div>
					<div class="col-sm-2">
						<input type="number" name="berat[]" class="form-control" placeholder="Berat (Kg)" min="0" value="<?php echo $diskon_5->berat; ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Harga Diskon 6<b class="peringatan">*</b></label>
					<div class="col-sm-2">
						<?php  
						$produk_id = $form_value['prodsId'];
						$diskon_6 = $this->db->get_where('diskon_harga', array('produk_id' => $produk_id, 'diskon_urutan' => '6'))->row();
						?>
						<input type="hidden" name="diskon_id[]" value="<?php echo $diskon_6->diskon_id; ?>">
						<input type="number" name="satuan_diskon[]" class="form-control" placeholder="Jumlah Satuan" min="0" value="<?php echo $diskon_6->jumlah_unit; ?>">
					</div>
					<div class="col-sm-4">
						<input type="number" name="harga_satuan_diskon[]" class="form-control" placeholder="Harga" min="0" value="<?php echo $diskon_6->harga_jumlah_unit; ?>">
					</div>
					<div class="col-sm-2">
						<input type="number" name="berat[]" class="form-control" placeholder="Berat (Kg)" min="0" value="<?php echo $diskon_6->berat; ?>">
					</div>
				</div>

				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Aturan <b class="peringatan">*</b></label>
					<div class="col-sm-10">
						<?php 
						$prodsDirections = set_value('prodsDirections', isset($form_value['prodsDirections']) ? $form_value['prodsDirections'] : '');
						?>
						<textarea name="prodsDirections" class="form-control ckeditor"><?php echo $prodsDirections; ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Bahan <b class="peringatan">*</b></label>
					<div class="col-sm-10">
						<?php 
						$prodsIngredients = set_value('prodsIngredients', isset($form_value['prodsIngredients']) ? $form_value['prodsIngredients'] : '');
						?>
						<textarea name="prodsIngredients" class="form-control ckeditor"><?php echo $prodsIngredients; ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Nomor BPOM <b class="peringatan">*</b></label>
					<div class="col-sm-10">
						<?php 
						$nomor_bpom = set_value('nomor_bpom', isset($form_value['nomor_bpom']) ? $form_value['nomor_bpom'] : '');
						?>
						<textarea name="nomor_bpom" class="form-control ckeditor"><?php echo $nomor_bpom; ?></textarea>
					</div>
				</div>

				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Merchant <b class="peringatan">*</b></label>
					<div class="col-sm-10">
						<?php
						$data_merchant = $this->db->get_where('merchant', array('tampilkan_merchant'=>1));

						if (!empty($form_value['merchant'])) {
							$selected_merchant = unserialize($form_value['merchant']);
							foreach ($data_merchant->result() as $key => $value) {
								if (in_array($value->id_merchant, $selected_merchant)) { 
								?>
								<div class="checkbox">
									<label>
										<input name="merchant[]" type="checkbox" class='flat' value="<?php echo $value->id_merchant; ?>" checked> <?php echo $value->nama_merchant; ?>
									</label>
								</div>
								<?php
								}else{
								?>
								<div class="checkbox">
									<label>
										<input name="merchant[]" type="checkbox" class='flat' value="<?php echo $value->id_merchant; ?>"> <?php echo $value->nama_merchant; ?>
									</label>
								</div>
								<?php
								}
							}
						}else{
							foreach ($data_merchant->result() as $key_null => $value_null) {
						?>
						<div class="checkbox">
							<label>
								<input name="merchant[]" type="checkbox" class='flat' value="<?php echo $value_null->id_merchant; ?>"> <?php echo $value_null->nama_merchant; ?>
							</label>
						</div>
						<?php
							}
						}
						?>

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