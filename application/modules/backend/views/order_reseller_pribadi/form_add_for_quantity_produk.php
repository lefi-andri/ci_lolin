<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Order</small></h2>
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
foreach ($produk as $key=>$val) {
	
	$id = (int) $_POST['data_id_produk'][$key];
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
						  'name' => 'quantity[]',
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
	<input type="hidden" name="reseller_id" value="<?php #echo $reseller_id; ?>">
	<input type="hidden" name="prodsId[]" value="<?php #echo $prodsId; ?>">
<?php
	$no++;
}
?>
	</tbody>
</table>

<?php echo form_submit('submit', 'Next', array('class'=>'btn btn-dark btn-block')); ?>
<?php echo form_close(); ?>

      </div>
    </div>
  </div>
</div>
