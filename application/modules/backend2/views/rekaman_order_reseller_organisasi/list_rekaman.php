<?php echo anchor($this->session->userdata('lolin_urlback_backend'), '<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Kembali', array('class' => 'btn btn-warning btn-sm' )); ?>

<div class="panel panel-default">
	<div class="panel-body">
<?php 
$total_semua_poin = "";
foreach ($data_rekaman->result() as $value_rekaman) {
	$data_kode_order = $this->db->get_where('purchase_order', array('order_code'=>$value_rekaman->order_code));

	list($tanggal, $waktu) = explode(' ', $value_rekaman->order_date);
?>
	<p><span class="label label-default">Nomor order :</span> <?php echo $value_rekaman->order_code; ?></p>
	<table width="100%" border="0" class="table">
		<tr>
			<td rowspan="2" style="background-color: #DDDDDD;"><div align="center"><strong>Kode Barang </strong></div></td>
			<td rowspan="2" style="background-color: #DDDDDD;"><div align="center"><strong>Nama Barang </strong></div></td>
			<td rowspan="2" style="background-color: #DDDDDD;"><div align="center"><strong>Nilai Poin </strong></div></td>
			<td style="background-color: #DDDDDD;">&nbsp;</td>
			<td style="background-color: #F7F7F7;"><div align="left"><strong>Tgl Ambil : </strong></div></td>
			<td style="background-color: #F7F7F7;"><?php echo indonesian_date($tanggal); ?></td>
		</tr>
		<tr>
			<td style="background-color: #DDDDDD;">&nbsp;</td>
			<td style="background-color: #DDDDDD;"><div align="center"><strong>Jumlah Barang </strong></div></td>
			<td style="background-color: #DDDDDD;"><div align="center"><strong>Jumlah Poin </strong></div></td>
		</tr>
	  
<?php
	$total_poin = "";
	foreach ($data_kode_order->result() as $key_produk_order => $value_produk_order) {

		$this->db->select('*');
		$this->db->where(array('order_code'=>$value_produk_order->order_code,'produk_id'=>$value_produk_order->produk_id));
		$this->db->group_by('order_code');
		$data_produk_order = $this->db->get('purchase_order');

		foreach ($data_produk_order->result() as $key_produk => $value_produk) {
				
			$data_produk = $this->db->get_where('product', array('prodsId'=>$value_produk->produk_id))->row();

			$this->db->select('*');
			$this->db->from('product');
			$this->db->join('poin', 'poin.prodsId = product.prodsId');
			$this->db->join('groups', 'groups.id = poin.group_id');
			$this->db->where('product.prodsId', $data_produk->prodsId);
			$this->db->where('groups.id', $value_rekaman->group_id);
			$poin_grup = $this->db->get()->row();

			# AMBIL JUMLAH QUANTITY
			$quantity = $this->db->get_where('purchase_order', array('produk_id'=>$value_produk->produk_id, 'order_code'=>$value_rekaman->order_code))->row();
			# AMBIL JUMLAH POIN
			$hitung_poin = $poin_grup->poinNilai * $quantity->order_quantity;
			
			?>
			  <tr>
			    <td><?php echo $data_produk->prodsKode; ?></td>
			    <td><?php echo $data_produk->prodsName; ?></td>
			    <td><div align="center"><?php echo $poin_grup->poinNilai; ?></div></td>
			    <td>&nbsp;</td>
			    <td><div align="center"><?php echo $quantity->order_quantity; ?></div></td>
			    <td><div align="center"><?php echo $hitung_poin; ?></div></td>
			  </tr>
			<?php
		}
		# AMBIL TOTAL QUANTITY
		if ($data_kode_order->num_rows() > 0) {
        	$this_tukar_total = 0;
	        foreach ($data_kode_order->result() as $data_tukar) {
	        	$this_tukar_total += $data_tukar->order_quantity;
	        }
        } else {
        	$this_tukar_total = 0;
        }

        # AMBIL TOTAL POIN
        $total_poin += $hitung_poin;
	}
	$total_semua_poin += $total_poin;
	?>
	<tr>
		<td colspan="3">&nbsp;</td>
		<td>&nbsp;</td>
		<td><div align="center">TOTAL</div></td>
		<td><div align="center"><?php echo $total_poin; ?></div></td>
	</tr>
	</table>
	<hr>
<?php

}
echo '<p><i>Total Semua Poin <span class="label label-success">'.$total_semua_poin.'</span></i></p>';
?>


	</div>
</div>