<!-- Page Content-->
<div class="container padding-bottom-2x mb-2">
	<div class="row align-items-center padding-bottom-2x">
		<div>
			<?php 
			if (count($result->result()) > 0) {
				echo "Hasil pencarian ".$keyword." ditemukan ".count($result)." data";
			}else{
				echo "Tidak ditemukan data dengan kata kunci ".$keyword;
			}
			?>
		</div>
		<?php  
		if(count($result)>0)
		{
		?>
		<table class="table">
		<?php	
			foreach ($result->result() as $data) {
			echo "<tr>
				<td>".anchor( base_url()."product/".$data->prodsSlug, $data->prodsName) . "</td>		
				</tr>";	
			}
		?>
		</table>
		<?php
		}
		?>
		<div>
			<?php echo anchor($this->session->userdata('lolin_urlback_frontend'), 'Kembali', array('title'=>'Kembali ke halaman pencarian', 'class'=>'btn btn-primary')); ?>
		</div>
	</div>
</div>