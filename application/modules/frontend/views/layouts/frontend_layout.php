<!DOCTYPE html>
<html lang="en">
<head>
	<?php echo $head; ?>
</head>
<!-- Body-->
<body class="<?php echo $body_class; ?>">
    <!-- Google Tag Manager (noscript)-->
    <noscript>
      <iframe src="http://www.googletagmanager.com/ns.html?id=GTM-T4DJFPZ" height="0" width="0" style="display: none; visibility: hidden;"></iframe>
    </noscript>
    <!-- Off-Canvas Category Menu-->
    <?php echo $categori_menu_extend; ?>
    <!-- Off-Canvas Mobile Menu-->
    <?php echo $mobile_menu_extend; ?>
    <!-- Topbar-->
    <?php echo $top_bar_extend; ?>
    <!-- Navbar-->
    <?php echo $navbar_extend; ?>
    <!-- Modal-->
    <?php echo $modal; ?>
    <!-- Off-Canvas Wrapper-->
    <div class="offcanvas-wrapper">
      <!-- Page Title-->
      <?php echo $breadcrumb; ?>
      	<!-- Page Content-->
      	<?php echo $content; ?>
      	<!-- Site Footer-->
        <?php echo $site_footer_extend; ?>
    </div>
    <?php echo $footer; ?>
    <?php echo $js; ?>
</body>
</html>