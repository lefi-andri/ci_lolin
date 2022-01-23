      <!-- Page Content-->
      <div class="container padding-bottom-3x mb-1">
        <?php $this->load->view('include/template/message'); ?>
        <?php
          $no = 1;
            if ($description_of_product->num_rows() > 0) {
                foreach ($description_of_product->result() as $value_product_description) {
        ?>
        <div class="row">
          <!-- Poduct Gallery-->
          <div class="col-md-6">
            <div class="product-gallery"><span class="product-badge text-danger"></span>
              <div class="gallery-wrapper">
                <div class="gallery-item active"><a href="<?php echo base_url(); ?>assets/images/product/front_of_product/<?php echo $value_product_description->prodsFrontPic; ?>" data-hash="one" data-size="1000x667"></a></div>
                <div class="gallery-item"><a href="<?php echo base_url(); ?>assets/images/product/back_of_product/<?php echo $value_product_description->prodsBackPic; ?>" data-hash="two" data-size="1000x667"></a></div>
              </div>
              <div class="product-carousel owl-carousel">
                <div data-hash="one"><img src="<?php echo base_url(); ?>assets/images/product/front_of_product/<?php echo $value_product_description->prodsFrontPic; ?>" alt="Product"></div>
                <div data-hash="two"><img src="<?php echo base_url(); ?>assets/images/product/back_of_product/<?php echo $value_product_description->prodsBackPic; ?>" alt="Product"></div>
              </div>
              <ul class="product-thumbnails">
                <li class="active"><a href="#one"><img src="<?php echo base_url(); ?>assets/images/product/front_of_product/<?php echo $value_product_description->prodsFrontPic; ?>" alt="Product"></a></li>
                <li><a href="#two"><img src="<?php echo base_url(); ?>assets/images/product/back_of_product/<?php echo $value_product_description->prodsBackPic; ?>" alt="Product"></a></li>
              </ul>
            </div>
          </div>
          <!-- Product Info-->
          <div class="col-md-6">
            <div class="padding-top-2x mt-2 hidden-md-up"></div>
              <!--div class="rating-stars"><i class="icon-star filled"></i><i class="icon-star filled"></i><i class="icon-star filled"></i><i class="icon-star filled"></i><i class="icon-star"></i>
              </div><span class="text-muted align-middle">&nbsp;&nbsp;4.2 | 3 customer reviews</span-->
            
            <h2 class="padding-top-1x text-normal"><?php echo $value_product_description->prodsName; ?></h2><span class="h2 d-block">
              <del class="text-muted text-normal"></del>&nbsp; <?php #echo $value_product_description->prodsNetto; ?></span>
            <p><?php echo $value_product_description->prodsDesc; ?></p>
            
            <div class="padding-bottom-1x mb-2"><span class="text-medium">Kategori:&nbsp;</span>
              <?php 
              $kategori = $this->db->get_where('product_cat', array('catprodsId'=>$value_product_description->catprodsId))->row();
              ?>
              <a class="navi-link" href="<?php echo base_url(); ?>product/category/<?php echo $kategori->catprodsSlug; ?>"><?php echo $kategori->catprodsName; ?></a>
            </div>
            <hr class="mb-3">
            <div class="d-flex flex-wrap justify-content-between">
              <div class="entry-share mt-2 mb-2"><span class="text-muted">Bagikan:</span>
                <div class="share-links">
                <?php $share = 'http://www.'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>
                <?php echo anchor("http://www.facebook.com/share.php?u=$share", '<i class="socicon-facebook"></i>', array('class'=>'social-button shape-circle sb-facebook', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Facebook')); ?>
                <?php echo anchor("http://twitter.com/share?url=$share&text=$value_product_description->prodsName", '<i class="socicon-twitter"></i>', array('class'=>'social-button shape-circle sb-twitter', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Twitter')); ?>
                <?php echo anchor("https://plus.google.com/share?url=$share", '<i class="socicon-googleplus"></i>', array('class'=>'social-button shape-circle sb-google-plus', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Google +')); ?>
                <?php echo anchor("http://www.linkedin.com/shareArticle?mini=true&url='.$share.'&title=$value_product_description->prodsName", '<i class="socicon-linkedin"></i>', array('class'=>'social-button shape-circle sb-linkedin', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Linked In')); ?>
                </div>
              </div>
              <div class="sp-buttons mt-2 mb-2">


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
              // do other stuff for a valid form
              $.post('<?php echo base_url(); ?>index.php/frontend/product/tambah', $("#myform-<?php echo $no; ?>").serialize(), function(data) {
                $('#hasil').html(data);
              });
            }
          });
        });
      </script>

              <form method="post" action="" id="myform-<?php echo $no;?>" name="myform-<?php echo $no; ?>">

                <?php echo form_hidden('product_id', $value_product_description->prodsId); ?>
                <?php echo form_hidden('price', $value_product_description->prodsPrice); ?>
                <?php echo form_hidden('product_name', $value_product_description->prodsName); ?>

                <?php  
                /*if (!$this->ion_auth->logged_in())
                {
                  echo anchor("#order", "Beli", array('title'=>'Beli Produk' , 'class'=>'btn btn-primary', 'data-target'=>'#order', 'data-toggle'=>'modal', 'data-id'=>$value_product_description->prodsSlug,));
                }else{
                  echo form_submit('', "Beli Produk", array('id' => 'clickable', 'class' => 'btn btn-primary', 'data-toast'=>'', 'data-toast-position'=>'topCenter','data-toast-type'=>'success', 'data-toast-icon'=>'icon-circle-check', 'data-toast-title'=>$value_product_description->prodsName, 'data-toast-message'=> 'berhasil ditambahkan di keranjang belanja anda.'));
                }*/
                #echo anchor("#order", "Beli", array('title'=>'Beli Produk' , 'class'=>'btn btn-primary', 'data-target'=>'#order', 'data-toggle'=>'modal', 'data-id'=>$value_product_description->prodsSlug,));
                echo form_submit('', "Beli Produk", array('id' => 'clickable', 'class' => 'btn btn-primary', 'data-toast'=>'', 'data-toast-position'=>'topCenter','data-toast-type'=>'success', 'data-toast-icon'=>'icon-circle-check', 'data-toast-title'=>$value_product_description->prodsName, 'data-toast-message'=> 'berhasil ditambahkan di keranjang belanja anda.'));
                ?>

                <?php echo form_close(); ?>
              </div>
            </div>
          </div>
        </div>
        <?php  
            }
        }
        ?>

        <!-- Product Tabs-->
        <div class="row padding-top-3x mb-3">
          <div class="col-lg-10 offset-lg-1">
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item"><a class="nav-link active" href="#aturan" data-toggle="tab" role="tab">Aturan Pakai</a></li>
              <li class="nav-item"><a class="nav-link" href="#bahan" data-toggle="tab" role="tab">Bahan</a></li>
              <li class="nav-item"><a class="nav-link" href="#no_bpom" data-toggle="tab" role="tab">NO BPOM</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane fade show active" id="aturan" role="tabpanel">
                <p><?php echo $value_product_description->prodsDirections; ?></p>
                
              </div>
              <div class="tab-pane fade" id="bahan" role="tabpanel">
                <p><?php echo $value_product_description->prodsIngredients; ?></p>
                
              </div>
              <div class="tab-pane fade" id="no_bpom" role="tabpanel">
                <p><?php echo $value_product_description->nomor_bpom; ?></p>
                
              </div>
            </div>
          </div>
        </div>

        <!-- Related Products Carousel-->
        <h3 class="text-center padding-top-2x mt-2 padding-bottom-1x">Produk Lainnya Dari Lolin</h3>
        <!-- Carousel-->
        <div class="owl-carousel" data-owl-carousel="{ &quot;nav&quot;: false, &quot;dots&quot;: true, &quot;margin&quot;: 30, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;576&quot;:{&quot;items&quot;:2},&quot;768&quot;:{&quot;items&quot;:3},&quot;991&quot;:{&quot;items&quot;:4},&quot;1200&quot;:{&quot;items&quot;:4}} }">
          
            <?php  
            $this->db->select('prodsName, prodsSlug, prodsBasePic, prodsNetto');
            $this->db->from('product');
            $this->db->order_by('rand()');
            $this->db->limit(8, 0);
            $this->db->where('prodsShow', '1');
            $entry_produk = $this->db->get();
            foreach ($entry_produk->result() as $entry) {
            ?>
            <!-- Product-->
            <div class="grid-item">
            <div class="product-card"><a class="product-thumb" href="<?php echo base_url(); ?>product/<?php echo $entry->prodsSlug; ?>"><img src="<?php echo base_url(); ?>assets/images/product/base_of_product/<?php echo $entry->prodsBasePic; ?>" alt="Product"></a>
              <h3 class="product-title"><a href="<?php echo base_url(); ?>product/<?php echo $entry->prodsSlug; ?>"><?php echo $entry->prodsName; ?></a></h3>
              <div class="product-buttons">
                <?php echo anchor(base_url()."product/".$entry->prodsSlug, 'Detail', array('class'=>"btn btn-outline-primary btn-sm")); ?>
              </div>
            </div>
            </div>
            <?php
            }
            ?>
          
          
        </div>
      </div>