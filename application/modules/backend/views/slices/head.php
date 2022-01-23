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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no">
    <title><?php print $title ? $title : SITE_TITLE; ?> | Lolin Kids Care Product</title>

    <!-- Favicon -->
    <?php echo favicons(); ?>

    <!-- plugins css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/themes/espire/bower_components/bootstrap/dist/css/bootstrap.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/themes/espire/bower_components/PACE/themes/blue/pace-theme-minimal.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/themes/espire/bower_components/perfect-scrollbar/css/perfect-scrollbar.min.css" />

    <!-- page plugins css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/themes/espire/bower_components/selectize/dist/css/selectize.default.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/themes/espire/bower_components/bootstrap-daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/themes/espire/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/themes/espire/bower_components/summernote/dist/summernote.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/themes/espire/bower_components/datatables/media/css/jquery.dataTables.css" />

    <link href="<?php echo base_url(); ?>assets/plugins/select2/css/select2.min.css" rel="stylesheet">

    <!-- core css -->
    <link href="<?php echo base_url(); ?>assets/themes/espire/dist/assets/css/ei-icon.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/themes/espire/dist/assets/css/themify-icons.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/themes/espire/dist/assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/themes/espire/dist/assets/css/animate.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/themes/espire/dist/assets/css/app.css" rel="stylesheet">

    <script src="<?php echo base_url(); ?>assets/js/initial.js"></script>
    <style type="text/css" media="screen">
    #notifications {
        cursor: pointer;
        position: fixed;
        right: 0px;
        z-index: 9999;
        bottom: 0px;
        margin-bottom: 22px;
        margin-right: 15px;
        min-width: 300px; 
        max-width: 800px;  
    }
    </style>