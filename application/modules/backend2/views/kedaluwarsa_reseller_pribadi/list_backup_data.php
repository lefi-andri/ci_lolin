<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="">
    <script>
    function printContent(el){
        var restorepage = document.body.innerHTML;
        var printcontent = document.getElementById(el).innerHTML;
        document.body.innerHTML = printcontent;
        window.print();
        document.body.innerHTML = restorepage;
    }
    </script>
</head>
<body>
<?php echo anchor($this->session->userdata('lolin_urlback_backend'), '<button>Kembali</button>', array('class' => 'btn btn-warning btn-sm' )); ?>
 <button onClick="printContent('amplop');">Print</button>
<div id="amplop">
<br>
<?php  
if ($data_reseller->group == 'reseller_pribadi') {
?>
<div>
	<b>Data reseller</b>
</div>
<table width="400px" border="0" style="border-collapse: collapse;">
  <tr>
    <td>ID Reseller</td>
    <td>:</td>
    <td><?php echo $data_reseller->reseller_id; ?></td>
  </tr>
  <tr>
    <td>Nama Lengkap</td>
    <td>:</td>
    <td><?php echo $data_reseller->nama_lengkap; ?></td>
  </tr>
  <tr>
    <td>Nomor KTP</td>
    <td>:</td>
    <td><?php echo $data_reseller->nomor_ktp; ?></td>
  </tr>
  <tr>
    <td>Tempat Lahir</td>
    <td>:</td>
    <td><?php echo $data_reseller->tempat_lahir; ?></td>
  </tr>
  <tr>
    <td>Tanggal Lahir</td>
    <td>:</td>
    <td><?php echo indonesian_date($data_reseller->tanggal_lahir); ?></td>
  </tr>
  <tr>
  	<td>Telepon</td>
  	<td>:</td>
  	<td><?php echo $data_reseller->nomor_telepon_reseller; ?></td>
  </tr>
  <tr>
  	<td>Alamat</td>
  	<td>:</td>
  	<td><?php echo $data_reseller->alamat_reseller; ?></td>
  </tr>
  <tr>
  	<td>Email</td>
  	<td>:</td>
  	<td><?php echo $data_reseller->email; ?></td>
  </tr>
  <tr>
    <td>Nama Bank</td>
    <td>:</td>
    <td><?php echo ($data_reseller->bank_id != "")? $this->db->get_where('bank', array('id' => $data_reseller->bank_id))->row()->nama_bank : '' ?></td>
  </tr>
  <tr>
  	<td>Nomor Rekening</td>
  	<td>:</td>
  	<td><?php echo $data_reseller->nomor_rekening; ?></td>
  </tr>
  <tr>
  	<td>Nama Pemilik Rekening</td>
  	<td>:</td>
  	<td><?php echo $data_reseller->nama_pemilik_rekening; ?></td>
  </tr>
  <tr>
    <td>Tanggal Daftar</td>
    <td>:</td>
    <?php  
    list($tanggal, $waktu) = explode(' ', $data_reseller->tanggal_daftar_reseller);
    ?>
    <td><?php echo indonesian_date($tanggal).' : '.$waktu; ?></td>
  </tr>
  <tr>
    <td>Poin Berakhir</td>
    <td>:</td>
    <td><?php echo indonesian_date($data_reseller->tanggal_kedaluwarsa_poin_reseller); ?></td>
  </tr>
</table>
<?php
}
?>
<br>
<hr>
<?php echo '<b>Admin</b> : '.$admin->nama_lengkap; ?>
<hr>
<br>
<div>
	<b>Data Order</b>
</div>
<div class="panel panel-default">
	<div class="panel-body">
<?php 
$total_semua_poin = "";
foreach ($data_rekaman->result() as $value_rekaman) {
	$data_kode_order = $this->db->get_where('purchase_order', array('order_code'=>$value_rekaman->order_code));

	list($tanggal, $waktu) = explode(' ', $value_rekaman->order_date);
?>
	<p><span class="label label-default">Nomor order :</span> <?php echo $value_rekaman->order_code; ?></p>
	<table width="100%" border="1" style="border-collapse: collapse;">
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
<hr>
<div>
	<b>Data Penukaran Poin</b>
</div>
<br>
<table width="100%" border="1" style="border-collapse: collapse;">
  <tr>
    <td><strong>No.</strong></td>
    <td><strong>Kode Penukaran </strong></td>
    <td><strong>Nama Bonus </strong></td>
    <td><strong>Poin</strong></td>
    <td><strong>Tanggal Tukar </strong></td>
  </tr>
  <tr>
		<?php  
		$total_tukar=0;
		$no = 1;
		foreach ($data_rekaman_penukaran->result() as $value_rekaman) {

			list($tanggal, $waktu) = explode(' ', $value_rekaman->tanggal_tukar_poin);
		?>
		<td><?php echo $no;  ?></td>
	    <td><?php echo $value_rekaman->kode_tukar_poin; ?></td>
	    <td><?php echo $value_rekaman->nama_jenis_bonus; ?></td>
	    <td><?php echo $value_rekaman->poin_bonus; ?></td>
	    <td><?php echo indonesian_date($tanggal).' : '.$waktu; ?></td>
		<?php	
			$no++;

			$total_tukar += $value_rekaman->poin_bonus;
		}
		?>
  </tr>
</table>
<br>
<i>Total Semua Penukaran : <?php echo $total_tukar; ?></i>
<br>
<hr>
<br>
<b>Total Poin : </b><?php echo $poin_saat_ini; ?>


</div>
</body>
</html>