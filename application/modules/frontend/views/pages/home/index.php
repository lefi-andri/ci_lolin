<div class="owl-carousel dots-inside" data-owl-carousel="{ &quot;nav&quot;: true, &quot;dots&quot;: true, &quot;loop&quot;: true, &quot;autoplay&quot;: true, &quot;autoplayTimeout&quot;: 4000 }">
  <?php  
  foreach ($banner->result() as $ban) {
  ?>
  <a href="<?php echo $ban->link; ?>"><img src="<?php echo base_url(); ?>assets/images/banner/middle_<?php echo $ban->nama_file; ?>" alt="<?php echo $ban->caption; ?>"></a>
  <?php  
  }
  ?> 
</div>
<!-- Introduction Widgets-->
<section class="container padding-top-1x">
  <div class="row">
    <div class="col-md-12 text-center mb-30">
      <?php echo $introduction->deskripsi; ?>
    </div>
  </div>
</section>

<!-- Services-->
<section class="container padding-bottom-2x">
  <div class="row">
    <div class="col-md-3 col-sm-6 text-center mb-30"><img class="d-block w-90 img-thumbnail rounded-circle mx-auto mb-3" src="<?php echo base_url(); ?>assets/images/introduction/middle_<?php echo $terdaftar->nama_file; ?>" alt="Shipping">
      <h6><?php echo $terdaftar->caption; ?></h6>
      <p class="text-muted margin-bottom-none"><?php echo $terdaftar->deskripsi; ?></p>
    </div>
    <div class="col-md-3 col-sm-6 text-center mb-30"><img class="d-block w-90 img-thumbnail rounded-circle mx-auto mb-3" src="<?php echo base_url(); ?>assets/images/introduction/middle_<?php echo $bersertifikat->nama_file; ?>" alt="Money Back">
      <h6><?php echo $bersertifikat->caption; ?></h6>
      <p class="text-muted margin-bottom-none"><?php echo $bersertifikat->deskripsi; ?></p>
    </div>
    <div class="col-md-3 col-sm-6 text-center mb-30"><img class="d-block w-90 img-thumbnail rounded-circle mx-auto mb-3" src="<?php echo base_url(); ?>assets/images/introduction/middle_<?php echo $free_paraben->nama_file; ?>" alt="Support">
      <h6><?php echo $free_paraben->caption; ?></h6>
      <p class="text-muted margin-bottom-none"><?php echo $free_paraben->deskripsi; ?></p>
    </div>
    <div class="col-md-3 col-sm-6 text-center mb-30"><img class="d-block w-90 img-thumbnail rounded-circle mx-auto mb-3" src="<?php echo base_url(); ?>assets/images/introduction/middle_<?php echo $no_allergents->nama_file; ?>" alt="Payment">
      <h6><?php echo $no_allergents->caption; ?></h6>
      <p class="text-muted margin-bottom-none"><?php echo $no_allergents->deskripsi; ?></p>
    </div>
  </div>
</section>

<!-- Product Widgets-->
<section class="container padding-bottom-1x">
  <h6 class="text-muted text-normal text-uppercase padding-top-1x"><i class="fa fa-shopping-bag"></i> Produk</h6>
  <hr class="margin-bottom-1x">
  <div class="card-deck">
    <?php
    $no = 1;
    foreach ($produk->result() as $value_product) {
    ?>
      <script type="text/javascript">
        $(document).ready(function(){
          $("#myform-<?php echo $no; ?>").validate({
            debug: false,
            rules: {
              banyak: "required"
            },
            messages: {
              banyak: " error",
            },
            submitHandler: function(form) {
              $.post('<?php echo base_url(); ?>index.php/frontend/product/tambah', $("#myform-<?php echo $no; ?>").serialize(), function(data) {
                $('#hasil').html(data);
              });
            }
          });
        });
      </script>
    <div class="card margin-bottom-1x"><img class="card-img-top" src="<?php echo base_url(); ?>assets/images/product/base_of_product/<?php echo $value_product->prodsBasePic; ?>" alt="Card image">
      <div class="card-body">
        <h4 class="card-title"><?php echo $value_product->prodsName; ?></h4>
        <p class="card-text">
          <?php
          $num_char = 100;
          $temp_post = strlen($value_product->prodsDesc);
          if ($temp_post >= $num_char) {
            $char     = $value_product->prodsDesc{$num_char - 1};
            while($char != ' ') {
                $char = $value_product->prodsDesc{--$num_char}; // Cari spasi pada posisi 49, 48, 47, dst...
            }
            echo substr($value_product->prodsDesc, 0, $num_char) . '...';
          ?>
          <?php
          }else{
            echo $value_product->prodsDesc;
          }
          ?>
        </p>
      </div>
      <div class="card-footer text-muted">
      <form method="post" action="" id="myform-<?php echo $no;?>" name="myform-<?php echo $no; ?>">
      <?php echo form_hidden('product_id', $value_product->prodsId); ?>
      <?php echo form_hidden('price', $value_product->prodsPrice); ?>
      <?php echo form_hidden('product_name', $value_product->prodsName); ?>
      <?php echo anchor(base_url()."product/".$value_product->prodsSlug, 'Detail', array('class'=>"btn btn-outline-primary btn-sm")); ?>
      <?php echo form_submit('', "Beli", array('id' => 'clickable'.$no, 'class' => 'btn btn-primary btn-sm', 'data-toast'=>'', 'data-toast-position'=>'topCenter','data-toast-type'=>'success', 'data-toast-icon'=>'icon-circle-check', 'data-toast-title'=>$value_product->prodsName, 'data-toast-message'=> 'berhasil ditambahkan di keranjang belanja anda.')); ?>
      <?php echo form_close(); ?>
      </div>
    </div>
    <?php
    $no++;
    }
    ?>
  </div>
  <div align="center">
    <?php echo anchor(base_url("shop"), 'View Shop', array('class'=>'btn btn-success')); ?>
  </div>
  <h6 class="text-muted text-normal text-uppercase padding-top-1x"><i class="fa fa-instagram"></i> #lolin_kids_care</h6>
  <hr class="margin-bottom-1x">
  <div class="card-group">
    <?php
    foreach ($instagram->result() as $value_instagram) {
    ?>
    <div class="card margin-bottom-1x"><img class="card-img-top" src="<?php echo base_url(); ?>assets/images/instagram/middle_<?php echo $value_instagram->nama_file; ?>" alt="Insta image">
      <div class="card-body">
        <p class="card-text">
        <?php
          $num_char = 70;
          $temp_post = strlen($value_instagram->deskripsi);
          if ($temp_post >= $num_char) {
            $char     = $value_instagram->deskripsi{$num_char - 1};
            while($char != ' ') {
                $char = $value_instagram->deskripsi{--$num_char}; // Cari spasi pada posisi 49, 48, 47, dst...
            }
            echo substr($value_instagram->deskripsi, 0, $num_char) . '...';
          ?>
          <a href="<?php echo $value_instagram->link; ?>" class='text-medium' target="_blank">Read More</a>
          <?php
          }else{
            echo $value_instagram->deskripsi;
          }
          ?>
        </p>
      </div>
      <div class="card-footer text-muted">
        Last updated 
        <?php 
        $this->load->helper('indonesiandate');
        list($tanggal, $waktu) = explode(' ', $value_instagram->tanggal);
        echo indonesian_date($tanggal);
        ?>
      </div>
    </div>
    <?php  
    }
    ?>
  </div>
  <div align="center">
    <?php echo anchor("https://www.instagram.com/lolin_kids_care/", 'View Gallery', array('class'=>'btn btn-success', 'target'=>'_blank')); ?>
  </div>
  <h6 class="text-muted text-normal text-uppercase padding-top-1x"><i class="fa fa-bookmark"></i> Article</h6>
  <hr class="margin-bottom-1x">
  <div class="owl-carousel" data-owl-carousel="{ &quot;nav&quot;: false, &quot;dots&quot;: true, &quot;loop&quot;: true, &quot;margin&quot;: 30, &quot;autoplay&quot;: true, &quot;autoplayTimeout&quot;: 4000, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;630&quot;:{&quot;items&quot;:2},&quot;991&quot;:{&quot;items&quot;:3},&quot;1200&quot;:{&quot;items&quot;:3}} }">
  <?php
  foreach ($blog->result() as $value_new_article) {
  ?>
    <a href="<?php echo base_url(); ?>blog/<?php echo $value_new_article->slug; ?>">
                      <img src="<?php echo base_url(); ?>assets/images/blog/gambar_judul/middle_<?php echo $value_new_article->nama_gambar_judul; ?>" alt="Product">
                    </a>
  <?php  
  }
  ?>
  </div>
</section>