<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php //echo $title; ?>Panel Administrator</title> 
  <link rel="icon" type="image/png" href="<?php echo base_url('assets/images/site/favicon.ico'); ?>" /> 

  <link href="<?php echo base_url(); ?>assets/themes/gentelella/css/bootstrap.min.css" rel="stylesheet">

  <link href="<?php echo base_url(); ?>assets/themes/gentelella/fonts/css/font-awesome.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/themes/gentelella/css/animate.min.css" rel="stylesheet">

  <link href="<?php echo base_url(); ?>assets/themes/gentelella/js/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />

  <!-- Custom styling plus plugins -->
  <link href="<?php echo base_url(); ?>assets/themes/gentelella/css/custom.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/themes/gentelella/css/icheck/flat/green.css" rel="stylesheet">

  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/themes/gentelella/css/switchery/switchery.min.css" />

  <script src="<?php echo base_url(); ?>assets/themes/gentelella/js/jquery.min.js"></script>

  <script src="<?php echo base_url(); ?>assets/js/initial.js"></script>


<style>
.myheader {
  color: #FFFFFF; 
}

.peringatan {
    color: red;
}
</style>
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
</head>
<body class="nav-md">

  <div class="container body">


    <div class="main_container">

            <?php $this->load->view('include/message'); ?>

            <?php $this->load->view($main_view); ?>

          </div>

          
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Copyright 2015-2017 <a href="http://www.lolin.co.id">Lolin Kids Care</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>

    </div>
  </div>

  <div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
  </div>


  <script src="<?php echo base_url(); ?>assets/themes/gentelella/js/bootstrap.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/jquery.maskedinput.js"></script>

  <!-- bootstrap progress js -->
  <script src="<?php echo base_url(); ?>assets/themes/gentelella/js/progressbar/bootstrap-progressbar.min.js"></script>
  
  <!-- icheck -->
  <script src="<?php echo base_url(); ?>assets/themes/gentelella/js/icheck/icheck.min.js"></script>
  <!-- tags -->
  <script src="<?php echo base_url(); ?>assets/themes/gentelella/js/tags/jquery.tagsinput.min.js"></script>

  <!-- select2 -->
  <script src="<?php echo base_url(); ?>assets/themes/gentelella/js/select/select2.full.js"></script>
  <!-- form validation -->
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/themes/gentelella/js/parsley/parsley.min.js"></script>
  <!-- textarea resize -->
  <script src="<?php echo base_url(); ?>assets/themes/gentelella/js/textarea/autosize.min.js"></script>
  <script>
    autosize($('.resizable_textarea'));
  </script>
  <!-- Autocomplete -->
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/themes/gentelella/js/autocomplete/countries.js"></script>
  <script src="<?php echo base_url(); ?>assets/themes/gentelella/js/autocomplete/jquery.autocomplete.js"></script>
  <!-- pace -->
  <script src="<?php echo base_url(); ?>assets/themes/gentelella/js/pace/pace.min.js"></script>

  <script src="<?php echo base_url(); ?>assets/themes/gentelella/js/custom.js"></script>

  <!-- /datatables -->
    <script src="<?php echo base_url('assets/plugins/datatables/media/js/jquery.dataTables.min.js') ?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/plugins/datatables/media/js/dataTables.bootstrap.min.js') ?>" type="text/javascript"></script>

          <script type="text/javascript">
          $(document).ready(function() {
            $('#datatable').dataTable();
            $('#datatable-keytable').DataTable({
              keys: true
            });
            $('#datatable-responsive').DataTable();
            $('#datatable-scroller').DataTable({
              ajax: "js/datatables/json/scroller-demo.json",
              deferRender: true,
              scrollY: 380,
              scrollCollapse: true,
              scroller: true
            });
            var table = $('#datatable-fixed-header').DataTable({
              fixedHeader: true
            });
          });
          TableManageButtons.init();
        </script>

  <script>
    $(document).ready(function(){
      setTimeout(function(){
        $(".alert").fadeIn('slow');
      }, 500);
      setTimeout(function(){
        $(".alert").fadeOut('slow');
      }, 5000);

      setTimeout(function(){
        $(".error").fadeIn('slow');
      }, 500);
      setTimeout(function(){
        $(".error").fadeOut('slow');
      }, 5000);
    });     
  </script>


</body>
</html>