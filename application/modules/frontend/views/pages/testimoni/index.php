      <!-- Page Content-->
      <div class="container padding-bottom-3x mb-1">
      <?php $this->load->view('include/template/message'); ?>
        <div class="row">
          <div class="col-lg-12 col-md-8 order-md-2">
            <h6 class="text-muted text-normal text-uppercase">Testimoni pelanggan dengan produk Lolin</h6>

            <hr class="margin-bottom-1x">
            <div class="gallery-wrapper">
              <div class="row">
              	<?php  
        				foreach ($konten->result() as $value) {
        				?>
                <div class="col-md-3 col-sm-6">
                  <div class="gallery-item">
                  	<a href="<?php echo base_url().'assets/images/testimoni/middle_'.$value->nama_file; ?>" data-size="1000x667">
                      <img src="<?php echo base_url().'assets/images/testimoni/middle_'.$value->nama_file; ?>" alt="Image">
                    </a>
                  	<span class="caption"><?php echo $value->deskripsi; ?></span>
                  </div>
                </div>
      				<?php
      				}
      				?>
              </div>
            </div>
            
            
          </div>

        </div>
      </div>