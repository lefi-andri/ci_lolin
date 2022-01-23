<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Lolin Kids Care Activation</title>
    <link rel="icon" type="image/x-icon" href="<?php echo base_url(); ?>assets/images/template/favicon.ico">
    
    <!-- Vendor Styles including: Bootstrap, Font Icons, Plugins, etc.-->
    <link rel="stylesheet" media="screen" href="<?php echo base_url(); ?>assets/themes/unishop/css/vendor.min.css">
    <!-- Main Template Styles-->
    <link id="mainStyles" rel="stylesheet" media="screen" href="<?php echo base_url(); ?>assets/themes/unishop/css/styles.min.css">
    <!-- Customizer Styles-->
    <link rel="stylesheet" media="screen" href="<?php echo base_url(); ?>assets/themes/unishop/customizer/customizer.min.css">

    <link href="<?php echo base_url(); ?>assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Google Tag Manager-->
    <script>
      (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
      new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
      j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
      '../../../../../www.googletagmanager.com/gtm5445.html?id='+i+dl;f.parentNode.insertBefore(j,f);
      })(window,document,'script','dataLayer','GTM-T4DJFPZ');
    </script>
    <!-- Modernizr-->
    <script src="<?php echo base_url(); ?>assets/themes/unishop/js/modernizr.min.js"></script>
  </head>
  <body>
    <noscript>
      <iframe src="http://www.googletagmanager.com/ns.html?id=GTM-T4DJFPZ" height="0" width="0" style="display: none; visibility: hidden;"></iframe>
    </noscript>

    <div class="offcanvas-wrapper">
    	<div class="container">
    		<hr class="margin-bottom-1x">
            <div class="card text-center">
              <div class="card-header"><span class="text-lg">Aktivasi Akun Reseller</span></div>
              <div class="card-body">
                <h3 class="card-title"></h3>
                <p class="card-text">
                	<?php $this->load->view('include/template/message'); ?>
            		  <?php $this->load->view($main_view); ?>
            	</p>
            	<a class="btn btn-primary" href="<?php echo base_url(); ?>reseller">Ok</a>
              </div>
              <div class="card-footer text-muted">Lolin Kids Care Product</div>
            </div>
    	</div>
    </div>
   
    <!-- JavaScript (jQuery) libraries, plugins and custom scripts-->
    <script src="<?php echo base_url(); ?>assets/themes/unishop/js/vendor.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/themes/unishop/js/scripts.min.js"></script>
    <!-- Customizer scripts-->
    <script src="<?php echo base_url(); ?>assets/themes/unishop/customizer/customizer.min.js"></script>
  </body>
</html>