      <?php  
      if (($this->uri->segment(1) != '') and ($this->uri->segment(1) != 'home')) {
      ?>
            <div class="page-title">
              <div class="container">
                <div class="column">
                  <h1><?php echo $label; ?></h1>
                </div>
                <?php echo $this->breadcrumb->show(); ?>
              </div>
            </div>
      <?php
      }
      ?>