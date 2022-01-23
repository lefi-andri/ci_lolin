<div class="panel panel-default">
	<div class="panel-heading">Jumlah Produk Dibeli</div>
  	<div class="panel-body">
		<?php echo form_open(base_url('admin/reseller/order/item/confirmation'), ['class'=>'form-horizontal']); ?>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Nama Reseller</label>
					<div class="col-sm-10">
						<?php
						echo $nama_reseller;
						?>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Masukkan Jumlah Produk Yang Dibeli <b class="peringatan">*</b></label>
					<div class="col-sm-10">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>No.</th>
									<th>Kode Produk</th>
									<th>Nama Produk</th>
									<th>Harga</th>	
									<th>Jumlah Pembelian</th>		
								</tr>
							</thead>
							<tbody>
						<?php  
						$no = 1;
						foreach ($product as $key=>$val) {
							
							$id = (int) $_POST['product'][$key];
							$result = $this->db->query("SELECT * FROM product WHERE prodsId=$id");
							if ($result->num_rows()>0)
							{
							?>
								<tr>
								<?php
								foreach ($result->result_array() as $prods) {
									$prodsId 		= $prods['prodsId'];
									$prodsCode 		= $prods['prodsKode'];
									$prodsName 		= $prods['prodsName'];
									$prodsPrice 	= $prods['prodsPrice'];
									?>
									<td><?php echo $no; ?></td>
									<td><?php echo $prodsCode; ?></td>
									<td><?php echo $prodsName; ?></td>
									<td><?php echo $prodsPrice; ?></td>
									<td>
										<div class="col-xs-3">
											<?php  
												$data = array(
												  'name' => 'jumlah[]',
												  'id'   => '',
												  'value' => 1,
												  'class'=> 'form-control',
												  'type' => 'number',
												  'required' => 'required'
												);
												echo form_input($data);
											?>
										</div>
									</td>
								<?php
								}
								?>
								</tr>

								<?php		
							}
							?>
							
							<input type="hidden" name="prodsId[]" value="<?php echo $prodsId; ?>">
							
							<?php
							$no++;
						}
						?>
							</tbody>
						</table>
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<?php echo form_submit('submit', 'Next', array('class'=>'btn btn-dark btn-block')); ?>
						<?php echo anchor($this->session->userdata('lolin_urlback_backend'), 'Kembali', array('class' => 'btn btn-default btn-block' )); ?>
					</div>
				</div>
		<?php echo form_close(); ?>
  </div>
</div>