<?php
defined('BASEPATH') OR exit('No direct script access allowed');
define("SITE_NAME","PT. LOLIN BERJAYA MULIA");
define("SITE_TITLE","Lolin Kids Care Product");
define("SITE_KEYWORD","lolin, lolin kids care product, perawatan anak sejak dini, perawatan anak, produk anak, shampoo anak, conditioner anak, facial wash anak, body lotion anak");
define("SITE_DESCRIPTION","Lolin merupakan produk perawatan khusus anak dengan varian Shampoo, Conditioner, Facial Wash, dan Body Lotion.");
define("SITE_MOBILE","off");
define("SITE_STATUS","on");
define("ONLINE_BACKUP","on");
define("SITE_EMAIL","info@lolin.co.id");
define("SITE_DEVELOPER_EMAIL","info@lolin.co.id");
define("MAIL_SIGNATURE","Regards, Lolin Kids Care");
define("SITE_IMAGE","");
define("SITE_COLOR","");
define("WATERMARK_IMAGE","watermarkimage.png");
define("WATERMARK_POSITION","4");
define("BLACKLIST_IP","");
define("WHITELIST_IP","");
define("SITE_LOG","on");
define("ADMIN_LOG","on");
define("IMAGE_QUALITY","80");
define("COMMENT_MOD_BLOG","on");
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php print $title ? $title : SITE_TITLE; ?> | Lolin Kids Care Product</title>
    <!-- SEO Meta Tags-->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="index, follow">
    <meta name="description" content="<?php print $description ? $description : SITE_DESCRIPTION; ?>">
    <meta name="keywords" content="<?php print $keyword ? $keyword : SITE_KEYWORD; ?>">
    <meta http-equiv="Copyright" content="2015 - <?php echo date('Y'); ?>. <?php print SITE_NAME; ?>. All rights reserved.">
    <meta name="author" content="Lolin Kids Care">
    <meta http-equiv="imagetoolbar" content="no">
    <meta name="language" content="Indonesia">
    <meta name="revisit-after" content="7">
    <meta name="webcrawlers" content="all">
    <meta name="rating" content="general">
    <meta name="spiders" content="all">
    <meta name="googlebot" content="index,follow">
    <!-- Mobile Specific Meta Tag-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <!-- Favicon and Apple Icons-->
    <link rel="icon" type="image/x-icon" href="<?php echo base_url(); ?>assets/images/template/favicon.ico">
    <link rel="apple-touch-icon" href="../touch-icon-iphone.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url(); ?>assets/themes/unishop/touch-icon-ipad.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url(); ?>assets/themes/unishop/touch-icon-iphone-retina.png">
    <link rel="apple-touch-icon" sizes="167x167" href="<?php echo base_url(); ?>assets/themes/unishop/touch-icon-ipad-retina.png">
    <!-- Vendor Styles including: Bootstrap, Font Icons, Plugins, etc.-->
    <link rel="stylesheet" media="screen" href="<?php echo base_url(); ?>assets/themes/unishop/css/vendor.min.css">
    <!-- Main Template Styles-->
    <link id="mainStyles" rel="stylesheet" media="screen" href="<?php echo base_url(); ?>assets/themes/unishop/css/styles.min.css">
    <!-- Customizer Styles-->
    <link rel="stylesheet" media="screen" href="<?php echo base_url(); ?>assets/themes/unishop/customizer/customizer.min.css">

    <link href="<?php echo base_url(); ?>assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <link href="<?php echo base_url(); ?>assets/plugins/select2/css/select2.min.css" rel="stylesheet">
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

    <link rel="stylesheet" media="screen" href="<?php echo base_url(); ?>assets/plugins/easy-notification/notification.css">
    <script src="<?php echo base_url(); ?>assets/plugins/easy-notification/ie-emulation-modes-warning.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/easy-notification/ie10-viewport-bug-workaround.js"></script>

  <script type="text/javascript">
  function loadCart() {
    /*$('#total_cart').load('<?php #echo base_url(); ?>my-cart/');*/

    /*$('#total_cart').load('<?php echo base_url(); ?>index.php/frontend/product/total_all_cart/');*/

    $('#jmlcart').load('<?php echo base_url(); ?>index.php/frontend/product/total_cart/');
    $('#jmlcart2').load('<?php echo base_url(); ?>index.php/frontend/product/show_cart/');
    $('#keranjang').load('<?php echo base_url(); ?>index.php/frontend/product/show_cart/');

    $('#my_cart').load('<?php echo base_url(); ?>index.php/frontend/product/my_cart/');
  }
  setInterval (loadCart, 5000);
  </script>




  </head>
  <!-- Body-->
  <body>
    <!-- Google Tag Manager (noscript)-->
    <noscript>
      <iframe src="http://www.googletagmanager.com/ns.html?id=GTM-T4DJFPZ" height="0" width="0" style="display: none; visibility: hidden;"></iframe>
    </noscript>

    <!-- Off-Canvas Category Menu-->
    <?php $this->load->view('include/template/extend/categori_menu_extend'); ?>
    <!-- Off-Canvas Mobile Menu-->
    <?php $this->load->view('include/template/extend/mobile_menu_extend'); ?>
    <!-- Topbar-->
    <?php $this->load->view('include/template/extend/top_bar_extend'); ?>
    <!-- Navbar-->
    <?php $this->load->view('include/template/extend/navbar_extend'); ?>
    <!-- Modal-->
    <?php $this->load->view('include/template/modal'); ?>    
    <!-- Off-Canvas Wrapper-->
    <div class="offcanvas-wrapper">
      <!--div class="container-fluid"-->
      <?php //$this->load->view('include/template/message'); ?>
      <!--/div-->
      <!-- Page Title-->
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
      <?php #print_r($_SESSION); ?>
      <!-- Page Content-->
      <?php $this->load->view($main_view); ?>
      <?php #$this->load->view('include/template/extend/page_content_extend'); ?>

      <!-- Site Footer-->
      <?php $this->load->view('include/template/extend/site_footer_extend'); ?>
    </div>
     <!-- Photoswipe container-->
    <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="pswp__bg"></div>
      <div class="pswp__scroll-wrap">
        <div class="pswp__container">
          <div class="pswp__item"></div>
          <div class="pswp__item"></div>
          <div class="pswp__item"></div>
        </div>
        <div class="pswp__ui pswp__ui--hidden">
          <div class="pswp__top-bar">
            <div class="pswp__counter"></div>
            <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
            <button class="pswp__button pswp__button--share" title="Share"></button>
            <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
            <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
            <div class="pswp__preloader">
              <div class="pswp__preloader__icn">
                <div class="pswp__preloader__cut">
                  <div class="pswp__preloader__donut"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
            <div class="pswp__share-tooltip"></div>
          </div>
          <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"></button>
          <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)"></button>
          <div class="pswp__caption">
            <div class="pswp__caption__center"></div>
          </div>
        </div>
      </div>
    </div>
    <!-- Back To Top Button--><a class="scroll-to-top-btn" href="#"><i class="icon-arrow-up"></i></a>
    <!-- Backdrop-->
    <div class="site-backdrop"></div>
    <!-- JavaScript (jQuery) libraries, plugins and custom scripts-->
    <script src="<?php echo base_url(); ?>assets/themes/unishop/js/vendor.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/themes/unishop/js/scripts.min.js"></script>
    <!-- Customizer scripts-->
    <!--script src="<?php #echo base_url(); ?>assets/themes/unishop/customizer/customizer.min.js"></script-->

    <script src="<?php echo base_url(); ?>assets/plugins/easy-notification/easy.notification.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/easy-notification/jquery.validate.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/easy-notification/docs.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/plugins/select2/js/select2.full.js"></script>
    <script>
        $(document).ready(function () {
            $("#prov").select2({
                placeholder: "Please Select"
            });

            $("#kota").select2({
                placeholder: "Please Select"
            });

            $("#kurir").select2({
                placeholder: "Please Select"
            });

            $("#layanan").select2({
                placeholder: "Please Select"
            });

            $("#bank").select2({
                placeholder: "Please Select"
            });
        });
    </script>
  </body>
</html>