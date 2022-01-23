<?php 
$this->load->helper('indonesiandate');
?>
<div class="container">
	<p>
		<label>Nama</label><br>
		<?php echo $contact->conNama; ?>
	</p>
	<p>
		<label>Email</label><br>
		<?php echo $contact->conEmail; ?>
	</p>
	<p>
		<label>Telepon</label><br>
		<?php echo $contact->conTelp; ?>
	</p>
	<p>
		<label>Alamat</label><br>
		<?php echo $contact->conAddress; ?>
	</p>
	<p>
		<label>Pesan</label><br>
		<?php echo $contact->conMessage; ?>
	</p>
	<p>
		<label>Waktu Pengiriman</label><br>
		<?php 
		$pecah = explode(" ", $contact->conTime);
		echo "<b>Tanggal :</b>".indonesian_date($pecah['0']);
		echo "<b>Jam :</b>".$pecah['1']; 
		?>
	</p>
</div>