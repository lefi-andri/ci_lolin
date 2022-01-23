<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Update penukaran poin</h2>
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

        <?php echo form_open($form_action); ?>

<table class="table">
	<thead>
		<tr>
			<th>No</th>
			<th>Id Reseller</th>
			<th>Nama</th>
			<th>Alamat</th>
			<th>Terdaftar</th>
			<th>Experied</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		
			<?php
				$no = 1;
				foreach ($data_reseller_pribadi as $value_reseller) {
			?>
			<tr>
				<td><?php echo $no; ?></td>
				<td><?php echo $value_reseller->reseller_id; ?></td>
				<td><?php echo $value_reseller->nama_lengkap; ?></td>
				<td><?php echo $value_reseller->alamat_reseller; ?></td>
				<td><?php echo $value_reseller->tanggal_daftar_reseller; ?></td>
				<td><?php echo $value_reseller->tanggal_kedaluwarsa_poin_reseller; ?></td>
				<td>
					<?php  
					$data = array(
					        'name'          => 'user_id',
					        'value'         => $value_reseller->id,
					        'checked'       => set_radio('user_id', 'y', isset($form_value['reseller_id']) && $form_value['reseller_id'] == $value_reseller->id ? TRUE : FALSE),
					        'class'         => 'flat',
					        'required'		=> 'required'
					);

					echo "<label>".form_radio($data)." Pilih</label>";
					?>
				</td>
			</tr>
			<?php
				$no++;	
				}
			?>
		
	</tbody>
</table>

<table class="table">
	<thead>
		<tr>
			<th>No</th>
			<th>Bonus</th>
			<th>Nilai Bonus</th>
			<th>Poin Bonus</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php
		$no = 1;
		foreach ($data_bonus_poin->result() as $value_bonus) {
		?>
		<tr>
			<td><?php echo $no; ?></td>
			<td><?php echo $value_bonus->nama_jenis_bonus; ?></td>
			<td><?php echo $value_bonus->nilai_bonus; ?></td>
			<td><?php echo $value_bonus->poin_bonus; ?></td>
			<td>
					<?php  
					$data = array(
					        'name'          => 'bonus_poin_id',
					        'value'         => $value_bonus->bonus_poin_id,
					        'checked'       => set_radio('bonus_poin_id', $value_bonus->bonus_poin_id, isset($form_value['bonus_poin_id']) && $form_value['bonus_poin_id'] == $value_bonus->bonus_poin_id ? TRUE : FALSE),
					        'class'         => 'flat',
					        'required'		=> 'required'
					);

					echo "<label>".form_radio($data)." Pilih</label>";
					?>
			</td>
		</tr>
		<?php
		$no++;
		}
		?>
	</tbody>
</table>

<?php echo anchor($this->session->userdata('lolin_urlback_backend'), '<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Batal', array('class' => 'btn btn-warning btn-sm' )); ?>
<?php echo form_submit('submit', "Update", array('class'=>'btn btn-dark brn-sm')); ?>

      </div>
    </div>
  </div>
</div>