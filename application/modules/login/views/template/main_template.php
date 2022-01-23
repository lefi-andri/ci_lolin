<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Authentication | Lolin Kids Care Product</title> 
  <link rel="icon" type="image/x-icon" href="<?php echo base_url(); ?>assets/images/template/favicon.ico">

  <!-- Bootstrap core CSS -->
  <link href="<?php echo base_url(); ?>assets/themes/gentelella/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/themes/gentelella/fonts/css/font-awesome.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/themes/gentelella/css/animate.min.css" rel="stylesheet">

  <!-- Custom styling plus plugins -->
  <link href="<?php echo base_url(); ?>assets/themes/gentelella/css/custom.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/themes/gentelella/css/icheck/flat/green.css" rel="stylesheet">
  <script src="<?php echo base_url(); ?>assets/themes/gentelella/js/jquery.min.js"></script>

  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
  <link href="<?php echo base_url(); ?>assets/style/login.css" rel="stylesheet">
  
<body>

  <div class="container">
    <div class="row">
      <div class="col-md-4 col-md-offset-4">
          <?php $this->load->view('template/notification_message'); ?>
          <?php $this->load->view($main_view); ?>
      </div>
    </div>
  </div>
  
<script src="<?php echo base_url(); ?>assets/js/login.js"></script>
</body>
</html>