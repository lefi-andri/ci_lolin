<div class="">

  <div class="row top_tiles">
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="tile-stats">
        <div class="icon"><i class="fa fa-caret-square-o-right"></i>
        </div>
        <div class="count"><?php echo $konten_halaman; ?></div>

        <h3>Konten Halaman</h3>
        <p>Jumlah halaman website.</p>
      </div>
    </div>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="tile-stats">
        <div class="icon"><i class="fa fa-comments-o"></i>
        </div>
        <div class="count"><?php echo $blog; ?></div>

        <h3>Blog</h3>
        <p>Jumlah artikel blog.</p>
      </div>
    </div>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="tile-stats">
        <div class="icon"><i class="fa fa-sort-amount-desc"></i>
        </div>
        <div class="count"><?php echo $produk; ?></div>

        <h3>Produk</h3>
        <p>Jumlah produk.</p>
      </div>
    </div>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
      <div class="tile-stats">
        <div class="icon"><i class="fa fa-check-square-o"></i>
        </div>
        <div class="count"><?php echo $pesan_contact; ?></div>

        <h3>Pesan Kontak</h3>
        <p>Pesan kontak dari website.</p>
      </div>
    </div>
  </div>

  <div class="row">
  <div class="col-md-6">

	<div class="panel panel-default">
	  <div class="panel-heading"><i class="fa fa-dashboard"></i> Dashboard</div>
	  <div class="panel-body">
		Hai <strong><?php #echo $get_data_user->userInfoName; ?></strong>, selamat datang di halaman Administrator.<br/>
		Login terakhir anda <?php #echo $get_data_user->authLastLogin; ?><br/>Silahkan klik menu pilihan yang berada di sebelah kiri untuk mengelola konten website anda. <?php #print_r($_SESSION); ?>
	  </div>
	</div>

	<div class="panel panel-default">
	  <div class="panel-heading"><i class="fa fa-rocket"></i> QUICK STAT</div>
	  <div class="panel-body">
	    <p>Berikut ini data statistik website Lolin.co.id</p>
		<table>
			<tr>
				<th>Page Content</th>
				<td>
					<?php  
					$rekamanPageContent = $this->db->get('content')->num_rows();
					echo $rekamanPageContent;
					?>
				</td>
			</tr>
			<tr>
				<th>Main Banner</th>
				<td>
					<?php  
					$rekamanBanner = $this->db->get('banner')->num_rows();
					echo $rekamanBanner;
					?>
				</td>
			</tr>
			<tr>
				<th>Info/Update</th>
				<td></td>
			</tr>
			<tr>
				<th>Photo Gallery</th>
				<td>
					<?php  
					$rekamanImgBank = $this->db->get('unggah_gambar')->num_rows();
					echo $rekamanImgBank;
					?>
				</td>
			</tr>
			<tr>
				<th>News</th>
				<td></td>
			</tr>
			<tr>
				<th>News: Category</th>
				<td></td>
			</tr>
			<tr>
				<th>Video</th>
				<td></td>
			</tr>
			<tr>
				<th>Video: Category</th>
				<td></td>
			</tr>		
		</table>
	  </div>
	</div>

  </div>
  <div class="col-md-6">

  	<div class="panel panel-default">
	  <div class="panel-heading"><i class="fa fa-balance-scale"></i> LICENSE</div>
	  <div class="panel-body">
		<table>
			<thead>
				<tr>
					<th>Licensed to</th>
					<th>Language Support</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><span class="label label-default">http://www.lolin.co.id</span></td>
					<td>Indonesia</td>
				</tr>
			</tbody>
		</table>
	  </div>
	</div>

	<div class="panel panel-default">
	  <div class="panel-heading"><i class="fa fa-universal-access"></i> Visitor</div>
	  <div class="panel-body">
	    <table>
			<tr>
				<th>Visitors</th>
				<td></td>
			</tr>
			<tr>
				<th>Page Views</th>
				<td></td>
			</tr>
			<tr>
				<th>Online Now</th>
				<td></td>
			</tr>
		</table>
	  </div>
	</div>

	<div class="panel panel-default">
	  <div class="panel-heading"><i class="fa fa-file-text"></i> Manage File</div>
	  <div class="panel-body">
	    <table>
			<tr>
				<th>Image Manager</th>
				<td></td>
			</tr>
			<tr>
				<th>File Manager</th>
				<td></td>
			</tr>
			<tr>
				<th>Word List</th>
				<td></td>
			</tr>
			<tr>
				<th>Email Queue</th>
				<td></td>
			</tr>
			<tr>
				<th>Email Blacklist</th>
				<td></td>
			</tr>				
		</table>
	  </div>
	</div>

  </div>
</div>

  
  </div>
</div>