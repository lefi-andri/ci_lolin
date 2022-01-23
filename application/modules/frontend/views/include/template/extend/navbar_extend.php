    <!-- Topbar-->
    <div class="topbar">
    <?php $get_facebook     = $this->db->get_where('socialmedia', array("socialId" => "4"))->row()->socialValue; ?>
    <?php $get_instagram    = $this->db->get_where('socialmedia', array("socialId" => "6"))->row()->socialValue; ?>  
    

      <div class="topbar-column"><a class="hidden-md-down" href="mailto:info@lolin.co.id"><i class="icon-mail"></i>&nbsp; info@lolin.co.id</a><a class="hidden-md-down" href="tel:085604848140"><i class="icon-bell"></i>&nbsp; 085604848140</a>
      <?php echo anchor($get_facebook, '<i class="socicon-facebook"></i>', array('target'=>'_blank', 'rel'=>'nofollow', 'class'=>'social-button sb-facebook shape-none sb-dark')); ?>
      <?php echo anchor($get_instagram, '<i class="socicon-instagram"></i>', array('target'=>'_blank', 'rel'=>'nofollow', 'class'=>'social-button sb-instagram shape-none sb-dark')); ?>
      </div>
      
      <div class="topbar-column">
        <?php  
        if (!$this->ion_auth->logged_in()){
        ?>
        <a class="hidden-md-down" href="<?php echo base_url('reseller'); ?>"><i class="fa fa-sign-in"></i> Login</a>
        <a class="hidden-md-down" href="<?php echo base_url('reseller/pribadi/register'); ?>"><i class="fa fa-user"></i> Register</a>
        <?php
        }
        ?>
      </div>

    </div>
    <header class="navbar navbar-sticky">
      
      <!-- Form Search -->
      <?php echo form_open(base_url('home/search/resultSearch'), array('method' => 'get', 'id'=> 'form', 'class'=>'site-search')); ?>
        <input type="text" name="keyword" placeholder="Type to search...">
        <div class="search-tools"><span class="clear-search">Clear</span><span class="close-search"><i class="icon-cross"></i></span></div>
      <?php echo form_close(); ?>


      <div class="site-branding">
        <div class="inner">
          <a class="offcanvas-toggle cats-toggle" href="#product-categories" data-toggle="offcanvas"></a>
          <a class="offcanvas-toggle menu-toggle" href="#mobile-menu" data-toggle="offcanvas"></a>
          <a class="site-logo" href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>assets/themes/unishop/img/logo/logo.png" alt="Lolin Kids Care"></a>
        </div>
      </div>
      
      <nav class="site-menu">
        <ul>
          <!--li class="<?php if(($this->uri->segment(1)=='home') or ($this->uri->segment(1)=='')){echo "active";} ?>">
            <a href="<?php echo base_url(); ?>"><span>Home</span></a>
          </li-->
          <li class="<?php if(($this->uri->segment(1)=='about_us')){echo "active";} ?>">
            <a href="<?php echo base_url('about_us'); ?>"><span>About Us</span></a>
          </li>
          <li class="<?php if(($this->uri->segment(1)=='shop')){echo "active";} ?>">
            <a href="<?php echo base_url('shop'); ?>"><span>Shop</span></a>
          </li>
          <li class="<?php if(($this->uri->segment(1)=='faq')){echo "active";} ?>">
            <a href="<?php echo base_url('faq'); ?>"><span>Faq</span></a>
          </li>
          <!--li class="<?php if(($this->uri->segment(1)=='blog')){echo "active";} ?>">
            <a href="<?php echo base_url('blog'); ?>"><span>Artikel</span></a>
          </li-->
          <li class="<?php if(($this->uri->segment(1)=='reseller')){echo "active";} ?>">
            <a href="<?php echo base_url('reseller'); ?>"><span>Member Area</span></a>
          </li>
          <!--li class="<?php if(($this->uri->segment(1)=='reseller')){echo "active";} ?>"><a href="<?php echo base_url('reseller'); ?>"><span>Member Area</span></a>
            <ul class="sub-menu">
              <li><a href="<?php echo base_url('reseller'); ?>">Reseller Area</a></li>
              <li><a href="<?php echo base_url('event'); ?>">Event</a></li>
              <li><a href="<?php echo base_url('testimonials'); ?>">Testimoni</a></li>
            </ul>
          </li-->
          <li class="<?php if(($this->uri->segment(1)=='contact')){echo "active";} ?>">
            <a href="<?php echo base_url('contact'); ?>"><span>Contact</span></a>
          </li>
          
        </ul>
      </nav>
      
      <div class="toolbar">
        <div class="inner">
          <div class="tools">
            <div class="search"><i class="icon-search"></i></div>
            
            <div class="cart" id="my_cart">
              <a href="<?php echo base_url().'cart'; ?>"></a>
                <i class="icon-bag"></i><span class="count">0</span><span class="subtotal">Rp. 0</span>
            </div>

          </div>
        </div>
      </div>
    </header>