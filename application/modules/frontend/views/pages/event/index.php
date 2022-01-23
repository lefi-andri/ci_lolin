      <!-- Page Content-->
      <div class="container padding-bottom-3x mb-1">
      <?php $this->load->view('include/template/message'); ?>
        <div class="row">
          <div class="col-lg-9 col-md-8 order-md-2">
            
            <h6 class="text-muted text-normal text-uppercase padding-top-1x mt-1">Semua Event Lolin</h6>
            <hr class="margin-bottom-1x">
            <div class="gallery-wrapper isotope-grid cols-3 grid-no-gap">
              <div class="gutter-sizer"></div>
              <div class="grid-sizer"></div>
              <?php  
              foreach ($contentEvent->result() as $value) {      
              ?>
              <div class="grid-item gallery-item">
                <a href="<?php echo base_url().'assets/images/events/large_'.$value->eventsPic; ?>" data-size="1000x667"><img src="<?php echo base_url().'assets/images/events/middle_'.$value->eventsPic; ?>" alt="Image"></a>
                <span class="caption"><?php echo $value->eventsName; ?></span>
              </div>
              <?php
              }
              ?>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 order-md-1">
            <!-- Side Menu-->
            <div class="padding-top-3x hidden-md-up"></div>
              <nav class="list-group" id="components-list">
                <a class="list-group-item list-group-item-action" href="<?php echo base_url().'event'; ?>" data-filter-item="af">All Events</a>
                <?php  
                foreach ($contentEvent->result() as $value) {      
                ?>
                  <a class="list-group-item list-group-item-action" href="<?php echo base_url().'event/'.$value->eventsSlug; ?>" data-filter-item="af"><?php echo $value->eventsName; ?></a>
                <?php
                }
                ?>
              </nav>
          </div>
        </div>
      </div>

