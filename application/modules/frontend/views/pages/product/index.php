      <!-- Page Content-->
      <div class="container padding-bottom-3x mb-1">
      <?php $this->load->view('include/template/message'); ?>
        <div class="row">
          <!-- Products-->
          <div class="col-xl-12 col-lg-8">
<?php  
$konten = array();
foreach ($this->cart->contents() as $items) {
  $konten[] = $items['id'];
}
#print_r($konten);
?>
<?php #echo "<hr>"; ?>
<?php #print_r($this->cart->contents()); ?>
<?php #echo "<hr>"; ?>
<?php #print_r($_SESSION); ?>
<?php #echo anchor(base_url().'index.php/frontend/product/empty_cart', 'Hapus Keranjang Belanja', array(''=>'')); ?>
            <!-- Products Grid-->
            <div class="isotope-grid cols-4 mb-2">
              <div class="gutter-sizer"></div>
              <div class="grid-sizer"></div>
              
              <?php  
              $no = 1;
              foreach ($data->result() as $produk) {
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
              // do other stuff for a valid form
              $.post('<?php echo base_url(); ?>index.php/frontend/product/tambah', $("#myform-<?php echo $no; ?>").serialize(), function(data) {
                $('#hasil').html(data);
              });
            }
          });
        });
      </script>


              <!-- Product-->
              <div class="grid-item">
                <div class="product-card">
                  <a class="product-thumb" href="<?php echo base_url()."product/".$produk->prodsSlug; ?>">
                    <img src="<?php echo base_url()."assets/images/product/base_of_product/".$produk->prodsBasePic; ?>" alt="Product">
                  </a>
                  <h4 class="card-title"><?php echo $produk->prodsName; ?></h4>
                  <div style="height: 130px;">
                  <p>
                    <?php 
                      //echo $produk->prodsDesc; 
                    $num_char = 100;
                    $temp_post = strlen($produk->prodsDesc);
                    if ($temp_post >= $num_char) {
                      $char     = $produk->prodsDesc{$num_char - 1};
                      while($char != ' ') {
                          $char = $produk->prodsDesc{--$num_char}; // Cari spasi pada posisi 49, 48, 47, dst...
                      }
                      echo substr($produk->prodsDesc, 0, $num_char) . '...';
                      }else{
                      echo $produk->prodsDesc;
                    }
                    ?>
                  </p> 
                  </div>
                  
                  <div class="bg-dark" style="padding: 20px;">
                  <form method="post" action="" id="myform-<?php echo $no;?>" name="myform-<?php echo $no; ?>">

                    
                    <?php
                    # COBA CEK JIKA ADA DIKERANJANG UBAH JADI DISABLED
                    if ($this->cart->contents()) {
                      foreach($this->cart->contents() as $items) {
                        if ($items['id'] == $produk->prodsId) {
                          $diss = 'disabled';
                        }else{
                          $diss = '';
                        }
                      }
                    }else{
                      $diss = '';
                    }
                    ?>

                    <?php  

                    ?>

                    <div class="product-buttons">
                      <?php echo form_hidden('product_id', $produk->prodsId); ?>
                      <?php echo form_hidden('price', $produk->prodsPrice); ?>
                      <?php echo form_hidden('product_name', $produk->prodsName); ?>
                      <?php echo anchor(base_url()."product/".$produk->prodsSlug, 'Detail', array('class'=>"btn btn-outline-white btn-sm")); ?>
                      
                      <?php  
                      /*if (!$this->ion_auth->logged_in())
                      {
                        echo anchor("#order", "Beli", array('title'=>'Beli Produk' , 'class'=>'btn btn-primary btn-sm', 'data-target'=>'#order', 'data-toggle'=>'modal', 'data-id'=>$produk->prodsSlug,));
                      }else{
                        echo form_submit('', "Beli", array('id' => 'clickable'.$no, 'class' => 'btn btn-white btn-sm', 'data-toast'=>'', 'data-toast-position'=>'topCenter','data-toast-type'=>'success', 'data-toast-icon'=>'icon-circle-check', 'data-toast-title'=>$produk->prodsName, 'data-toast-message'=> 'berhasil ditambahkan di keranjang belanja anda.'));
                      }*/
                      #echo anchor("#order", "Beli", array('title'=>'Beli Produk' , 'class'=>'btn btn-primary btn-sm', 'data-target'=>'#order', 'data-toggle'=>'modal', 'data-id'=>$produk->prodsSlug,));
                      

                      echo form_submit('', "Beli", array('id' => 'clickable'.$no, 'class' => 'btn btn-primary btn-sm', 'data-toast'=>'', 'data-toast-position'=>'topCenter','data-toast-type'=>'success', 'data-toast-icon'=>'icon-circle-check', 'data-toast-title'=>$produk->prodsName, 'data-toast-message'=> 'berhasil ditambahkan di keranjang belanja anda.'));
                      
                      ?>
                     
                      

                    </div>
                  <?php echo form_close(); ?>
                  </div>
                </div>
              </div>
      
              <?php
              $no++;
              }
              ?>
              
            </div>


            <!-- Pagination-->
            <?php echo $pagination; ?>
          </div>
          <!-- Sidebar          -->
          <!--div class="col-xl-3 col-lg-4">
            <aside class="sidebar sidebar-offcanvas">
              
              <section class="widget widget-categories">
                <h3 class="widget-title">Produk Kategori</h3>
                <ul>
                <?php  
                foreach ($data_kategori_produk->result() as $value) {
                ?>
                  <li><a class="tag" href="<?php echo base_url().'product/category/'.$value->catprodsSlug; ?>">
                    <?php echo $value->catprodsName; ?> <span>(<?php echo $this->db->get_where('product', array('catprodsId' => $value->catprodsId))->num_rows(); ?>)</span>
                  </a></li>
                <?php
                }
                ?>
                </ul>
              </section>

              
              <section class="promo-box" style="background-image: url(<?php echo base_url(); ?>assets/images/iklan/middle_<?php echo $iklan->nama_file; ?>);">
                <span class="overlay-dark" style="opacity: .35;"></span>
                <div class="promo-box-content text-center padding-top-2x padding-bottom-2x">
                  <h3 class="text-bold text-light text-shadow"><?php echo $iklan->caption; ?></h3>
                  <h4 class="text-light text-thin text-shadow"><?php echo $iklan->deskripsi; ?></h4><a class="btn btn-sm btn-primary" href="<?php echo $iklan->link; ?>">Kunjungi</a>
                </div>
              </section>
              
            </aside>
          </div-->
        </div>
      </div>

<!--div class="container padding-bottom-3x mb-1">
  <div class="row">
    <div class="col-md-12">
        
        <div class="card border-dark text-center">
          <div class="card-body">
            <h4 class="card-title">Promo Produk Lolin Kids Care</h4>
            <p class="card-text">Anda juga dapat melihat promo menarik produk melalui :</p>
            <a href="https://www.bukalapak.com/u/ptlolinberjayamulia?from=omnisearch&search_source=omnisearch_user&source=navbar" title="" target="_blank"><img src="<?php echo base_url(); ?>assets/images/merchant/Bukalapak_1528077198.jpg" alt=""></a>
            <a href="https://www.tokopedia.com/lolinworld?source=universe&st=product" title="" target="_blank"><img src="<?php echo base_url(); ?>assets/images/merchant/Tokopedia_1528077206.jpg" alt=""></a>
            <a href="https://www.blibli.com/merchant/lolin-kids-care-products/LOW-60021" title="" target="_blank"><img src="<?php echo base_url(); ?>assets/images/merchant/Blibli_1528077214.jpg" alt=""></a>
          </div>
        </div>

    </div>
  </div>
</div-->