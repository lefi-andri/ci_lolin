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
?>
<!-- robot speak -->
	<meta charset="utf-8">
	<title><?php print $title ? $title : SITE_TITLE; ?> | Lolin Kids Care Product</title>
	<!-- SEO Meta Tags-->
	<?php echo chrome_frame(); ?>
	<?php echo view_port(); ?>
	<?php echo apple_mobile('black-translucent'); ?>
	<?php echo $meta; ?>
	<meta name="robots" content="index, follow">
	<meta http-equiv="Copyright" content="2015 - <?php echo date('Y'); ?>. <?php print SITE_NAME; ?>. All rights reserved.">
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
	<?php echo favicons(); ?>
	<!-- icons and icons and icons and icons and icons and a tile -->
	<?php echo windows_tile(array('name' => 'Stencil', 'image' => base_url().'assets/img/icons/tile.png', 'color' => '#4eb4e5')); ?>
	<!-- Vendor Styles including: Bootstrap, Font Icons, Plugins, etc.-->
	<link rel="stylesheet" media="screen" href="<?php echo base_url(); ?>assets/themes/unishop/css/vendor.min.css">
	<!-- Main Template Styles-->
	<link id="mainStyles" rel="stylesheet" media="screen" href="<?php echo base_url(); ?>assets/themes/unishop/css/styles.min.css">
	<!-- Customizer Styles-->
	<link rel="stylesheet" media="screen" href="<?php echo base_url(); ?>assets/themes/unishop/customizer/customizer.min.css">
	<link href="<?php echo base_url(); ?>assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/plugins/select2/css/select2.min.css" rel="stylesheet">
	<!-- crayons and paint -->	
	<?php #echo add_css(array('bootstrap', 'bootstrap-responsive', 'style')); ?>
	<?php echo $css; ?>
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
	<!-- magical wizardry -->
	<?php #echo jquery('1.9.1'); ?>
	<?php #echo shiv(); ?>
	<?php #echo add_js(array('bootstrap.min', 'scripts')); ?>
	<?php #echo $js; ?>
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