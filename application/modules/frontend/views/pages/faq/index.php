      <!-- Page Content-->
      <div class="container padding-bottom-3x">
      <?php $this->load->view('include/template/message'); ?>
        <div class="row">
          <!-- Side Menu-->
          <div class="col-lg-3 col-md-4">

            <img src="<?php echo base_url(); ?>assets/images/template/lolin_faq.jpg" alt="Image Faq">
            
            <div class="padding-bottom-3x hidden-md-up"></div>
          </div>
          <!-- Content-->
          <div class="col-lg-9 col-md-8">
            <div class="accordion" id="accordion" role="tablist">
              <?php  
              $no = 1;
              foreach ($konten->result() as $value) {
                
              ?>
              <div class="card">
                <div class="card-header" role="tab">
                  <h6><a class="collapsed" href="#collapse<?php echo $no; ?>" data-toggle="collapse" data-parent="#accordion"><?php echo $value->pertanyaan; ?></a></h6>
                </div>
                <div class="collapse <?php if($no == '1'){echo "show";} ?>" id="collapse<?php echo $no; ?>" role="tabpanel">
                  <div class="card-body"><?php echo $value->jawaban; ?></div>
                </div>
              </div>
              <?php  
              $no++;
              }
              ?>
              

            </div>
            
          </div>
        </div>
      </div>