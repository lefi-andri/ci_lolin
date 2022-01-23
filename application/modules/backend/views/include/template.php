<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Panel Administrator</title>	
	<link rel="icon" type="image/x-icon" href="<?php echo base_url(); ?>assets/images/template/favicon.ico">

  <link href="<?php echo base_url(); ?>assets/themes/gentelella/css/bootstrap.min.css" rel="stylesheet">

	<link href="<?php echo base_url(); ?>assets/themes/gentelella/fonts/css/font-awesome.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/themes/gentelella/css/animate.min.css" rel="stylesheet">

  <!-- Custom styling plus plugins -->
  <link href="<?php echo base_url(); ?>assets/themes/gentelella/css/custom.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/themes/gentelella/css/icheck/flat/green.css" rel="stylesheet">

  <!--link href="<?php #echo base_url(); ?>assets/themes/gentelella/js/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" /-->
  <link href="<?php echo base_url(); ?>assets/themes/gentelella/js/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url(); ?>assets/themes/gentelella/js/datatables/buttons.bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url(); ?>assets/themes/gentelella/js/datatables/fixedHeader.bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url(); ?>assets/themes/gentelella/js/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url(); ?>assets/themes/gentelella/js/datatables/scroller.bootstrap.min.css" rel="stylesheet" type="text/css" />


	<!-- Custom styling plus plugins -->
	<link href="<?php echo base_url(); ?>assets/themes/gentelella/css/custom.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/themes/gentelella/css/icheck/flat/green.css" rel="stylesheet">
	<!-- editor -->
	<link href="<?php echo base_url(); ?>assets/themes/gentelella/css/editor/external/google-code-prettify/prettify.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/themes/gentelella/css/editor/index.css" rel="stylesheet">
	<!-- select2 -->
	<link href="<?php echo base_url(); ?>assets/themes/gentelella/css/select/select2.min.css" rel="stylesheet">
	<!-- switchery -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/themes/gentelella/css/switchery/switchery.min.css" />

	<script src="<?php echo base_url(); ?>assets/themes/gentelella/js/jquery.min.js"></script>

  <!-- Meload datetimepicker bootstrap -->
  <link href="<?php echo base_url(); ?>assets/plugins/datetimepicker/bootstrap-datetimepicker.min.css" rel="stylesheet">

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

      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">

          <div class="navbar nav_title" style="border: 0;">
            <a href="<?php echo base_url('backend/dashboard/index'); ?>" class="site_title myheader"><i class="fa fa-shopping-bag"></i> <span>Lolin</span></a>
          </div>
          <div class="clearfix"></div>
          <?php
          $user = $this->ion_auth->get_user();
          $nama_pengguna="";
          $split = explode(" ", $user->nama_lengkap);

          foreach ($split as $key => $value) {
            if ($key < 2) {
              $nama_pengguna .= substr($value,0,1);
            }            
          }        
          ?>
          <!-- menu prile quick info -->
          <div class="profile">
            <div class="profile_pic">
              <img data-name="<?php echo $nama_pengguna; ?>" class="profile img-circle profile_img"/>
            </div>
            <div class="profile_info">
              <span>Welcome,</span>
              <h2><?php echo $user->nama_lengkap; ?></h2>
            </div>
          </div>
          <!-- /menu prile quick info -->

          <br />

          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                    
            <?php $this->load->view('include/menu'); ?>
            

          </div>
          <!-- /sidebar menu -->

          <!-- /menu footer buttons -->
          <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="Settings">
              <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
              <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Lock">
              <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Logout">
              <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
          </div>
          <!-- /menu footer buttons -->
        </div>
      </div>

      <?php $this->load->view('include/navbar'); ?>

      <!-- page content -->
      <div class="right_col" role="main">
        <div class="">

          <div class="clearfix"></div>
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">

			<?php if($this->session->flashdata('message')){ ?>
			    <div class="alert alert-success">
			        <a href="#" class="close" data-dismiss="alert">&times;</a>
			        <strong><?php echo $this->session->flashdata('message'); ?></strong>
			    </div>
			<?php } ?>
            
            <?php $this->load->view('include/message'); ?>
            <!--code><?php echo $this->breadcrumb->show(); ?></code-->
            <?php $this->load->view($main_view); ?>
              
            <?php $this->load->view('include/modal_logout'); ?>
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
  <script>
  jQuery(function($){
      $("#tgl").mask("99/99/9999",{placeholder:"dd/mm/yyyy"});
  });
  </script>
  <!-- bootstrap progress js -->
  <script src="<?php echo base_url(); ?>assets/themes/gentelella/js/progressbar/bootstrap-progressbar.min.js"></script>
  
  <!-- icheck -->
  <script src="<?php echo base_url(); ?>assets/themes/gentelella/js/icheck/icheck.min.js"></script>
  <!-- tags -->
  <script src="<?php echo base_url(); ?>assets/themes/gentelella/js/tags/jquery.tagsinput.min.js"></script>
  <!-- switchery -->
  <script src="<?php echo base_url(); ?>assets/themes/gentelella/js/switchery/switchery.min.js"></script>
  <!-- daterangepicker -->
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/themes/gentelella/js/moment/moment.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/themes/gentelella/js/datepicker/daterangepicker.js"></script>
  <!-- richtext editor -->
  <script src="<?php echo base_url(); ?>assets/themes/gentelella/js/editor/bootstrap-wysiwyg.js"></script>
  <script src="<?php echo base_url(); ?>assets/themes/gentelella/js/editor/external/jquery.hotkeys.js"></script>
  <script src="<?php echo base_url(); ?>assets/themes/gentelella/js/editor/external/google-code-prettify/prettify.js"></script>
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



        <!-- Datatables-->
        <script src="<?php echo base_url(); ?>assets/themes/gentelella/js/datatables/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/themes/gentelella/js/datatables/dataTables.bootstrap.js"></script>
        <script src="<?php echo base_url(); ?>assets/themes/gentelella/js/datatables/dataTables.buttons.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/themes/gentelella/js/datatables/buttons.bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/themes/gentelella/js/datatables/jszip.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/themes/gentelella/js/datatables/pdfmake.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/themes/gentelella/js/datatables/vfs_fonts.js"></script>
        <script src="<?php echo base_url(); ?>assets/themes/gentelella/js/datatables/buttons.html5.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/themes/gentelella/js/datatables/buttons.print.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/themes/gentelella/js/datatables/dataTables.fixedHeader.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/themes/gentelella/js/datatables/dataTables.keyTable.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/themes/gentelella/js/datatables/dataTables.responsive.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/themes/gentelella/js/datatables/responsive.bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/themes/gentelella/js/datatables/dataTables.scroller.min.js"></script>

  <!-- pace -->
  <script src="<?php echo base_url(); ?>assets/themes/gentelella/js/pace/pace.min.js"></script>

        <script>
          var handleDataTableButtons = function() {
              "use strict";
              0 !== $("#datatable-buttons").length && $("#datatable-buttons").DataTable({
                dom: "Bfrtip",
                buttons: [{
                  extend: "copy",
                  className: "btn-sm"
                }, {
                  extend: "csv",
                  className: "btn-sm"
                }, {
                  extend: "excel",
                  className: "btn-sm"
                }, {
                  extend: "pdf",
                  className: "btn-sm"
                }, {
                  extend: "print",
                  className: "btn-sm"
                }],
                responsive: !0
              })
            },
            TableManageButtons = function() {
              "use strict";
              return {
                init: function() {
                  handleDataTableButtons()
                }
              }
            }();
        </script>
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


  <script type="text/javascript">
    $(function() {
      'use strict';
      var countriesArray = $.map(countries, function(value, key) {
        return {
          value: value,
          data: key
        };
      });
      // Initialize autocomplete with custom appendTo:
      $('#autocomplete-custom-append').autocomplete({
        lookup: countriesArray,
        appendTo: '#autocomplete-container'
      });
    });
  </script>
  <script src="<?php echo base_url(); ?>assets/themes/gentelella/js/custom.js"></script>



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

	
	<!-- /datatables -->
    <!--script src="<?php #echo base_url('assets/plugins/datatables/media/js/jquery.dataTables.min.js') ?>" type="text/javascript"></script>
    <script src="<?php #echo base_url('assets/plugins/datatables/media/js/dataTables.bootstrap.min.js') ?>" type="text/javascript"></script-->

    <script src="<?php echo base_url('assets/plugins/datetimepicker/moment.js') ?>"></script>
    <script src="<?php echo base_url('assets/plugins/datetimepicker/bootstrap-datetimepicker.min.js') ?>"></script>
    <script>
        $('.profile').initial({width:52,height:52, fontSize:20, charCount:2, fontWeight:100}); 
    </script>
    <script type="text/javascript">
      $(function () {
        $('#tgl-mulai').datetimepicker({
          format: 'YYYY-MM-DD HH:mm:ss',
        });

        $('#tgl-akhir').datetimepicker({
          format: 'YYYY-MM-DD HH:mm:ss',
        });

        $('#datetimepicker').datetimepicker({
          format: 'YYYY-MM-DD HH:mm:ss',
        });
        
        $('#datepicker').datetimepicker({
          format: 'DD MMMM YYYY',
        });
        
        $('#timepicker').datetimepicker({
          format: 'HH:mm'
        });

        $('#tanggal').datetimepicker({
          format: 'YYYY-MM-DD',
        });
      });
    </script>
    
    <script>
  var table;
  $(document).ready(function() {
    
    $(".select2").select2({
          placeholder: "Please Select"
        });

    $("#product").DataTable({
      "processing"    : true, //Feature control the processing indicator.
      "serverSide"    : true, //Feature control DataTables' servermside processing mode.
      //"order"     : [], //Initial no order.
      "iDisplayLength"  : 10,

      "ordering"      : true,
      "processing"    : true,
      "serverSide"    : true,

      // Load data for the table's content from an Ajax source
      "ajax": {
        "url"   : "<?php echo base_url('admin/member_area/grab_data_member') ?>",
        "type"    : "POST",
        "dataType"  : "json",
        "dataSrc": function (jsonData) {        
          return jsonData.data;
        },
        data: {
            data: 'data', 
            <?php #echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
        },
      },

      //Set column definition initialisation properties.
      "columnDefs": [
        { 
          "targets": [ 0 ], //kolom pertama atau penomoran kolom
          "orderable": false, //set not orderable
        },
      ],

        });

    });
  </script>

    <script type="text/javascript">

    	function showDetails(bookURL){
			window.open(bookURL,"bookDetails","width=600,height=430,scrollbars=yes");              
		}

    $(document).ready(function() {
      $(".select2").select2({
          placeholder: "Please Select"
        });

    /**
    * @product
    *
    */
    $("#kategori_produk").DataTable({
      ordering: true,
      processing: true,
      serverSide: true,
      ajax: {
        url: "<?php echo base_url('backend/kategori_produk/grab_data_kategori_produk') ?>",
        type:'POST',
      }
    });   
    $("#produk").DataTable({
      ordering: true,
      processing: true,
      serverSide: true,
      ajax: {
        url: "<?php echo base_url('backend/produk/grab_data_produk'); ?>",
        type:'POST',
      }
    });
    $("#banner").DataTable({
      ordering: true,
      processing: true,
      serverSide: true,
      ajax: {
        url: "<?php echo base_url('backend/adm_banner/grab_data_banner') ?>",
        type:'POST',
      }
    });

    $("#base_banner").DataTable({
      ordering: true,
      processing: true,
      serverSide: true,
      ajax: {
        url: "<?php echo base_url('backend/adm_base_banner/grab_data_base_banner') ?>",
        type:'POST',
      }
    });

    $("#testimoni").DataTable({
      ordering: true,
      processing: true,
      serverSide: true,
      ajax: {
        url: "<?php echo base_url('backend/adm_testimoni/grab_data_testimoni') ?>",
        type:'POST',
      }
    });

    $("#testimonial").DataTable({
      ordering: true,
      processing: true,
      serverSide: true,
      ajax: {
        url: "<?php echo base_url('backend/adm_testimonial/grab_data_testimonial') ?>",
        type:'POST',
      }
    });

    $("#data_kategori_faq").DataTable({
      ordering: true,
      processing: true,
      serverSide: true,
      ajax: {
        url: "<?php echo base_url('backend/kategori_faq/grab_data_kategori_faq') ?>",
        type:'POST',
      }
    });

    $("#data_faq").DataTable({
      ordering: true,
      processing: true,
      serverSide: true,
      ajax: {
        url: "<?php echo base_url().'backend/faq/grab_data_faq/12'; ?>",
        type:'POST',
      }
    });

    $("#socialmedia").DataTable({
      ordering: true,
      processing: true,
      serverSide: true,
      ajax: {
        url: "<?php echo base_url('backend/adm_socialmedia/grab_data_socialmedia') ?>",
        type:'POST',
      }
    });
    $("#offlineshop").DataTable({
      ordering: true,
      processing: true,
      serverSide: true,
      ajax: {
        url: "<?php echo base_url('backend/adm_shop/grab_data_offline_shop') ?>",
        type:'POST',
      }
    });
    $("#onlineshop").DataTable({
      ordering: true,
      processing: true,
      serverSide: true,
      ajax: {
        url: "<?php echo base_url('backend/adm_shop/grab_data_online_shop') ?>",
        type:'POST',
      }
    });
    $("#news_kategori").DataTable({
      ordering: true,
      processing: true,
      serverSide: true,
      ajax: {
        url: "<?php echo base_url('backend/adm_news/grab_data_news_kategori') ?>",
        type:'POST',
      }
    });
    $("#news").DataTable({
      ordering: true,
      processing: true,
      serverSide: true,
      ajax: {
        url: "<?php echo base_url('backend/adm_news/grab_data_news') ?>",
        type:'POST',
      }
    });
    $("#event").DataTable({
      ordering: true,
      processing: true,
      serverSide: true,
      ajax: {
        url: "<?php echo base_url('backend/adm_event/grab_data_event') ?>",
        type:'POST',
      }
    });
    $("#events").DataTable({
      ordering: true,
      processing: true,
      serverSide: true,
      ajax: {
        url: "<?php echo base_url('backend/adm_events/grab_data_events') ?>",
        type:'POST',
      }
    });
    $("#member").DataTable({
      ordering: true,
      processing: true,
      serverSide: true,
      ajax: {
        url: "<?php echo base_url('backend/adm_member_area/grab_data_member') ?>",
        type:'POST',
      }
    });
    $("#bonus_poin").DataTable({
      ordering: true,
      processing: true,
      serverSide: true,
      ajax: {
        url: "<?php echo base_url('backend/adm_bonus/grab_data_bonus_poin') ?>",
        type:'POST',
      }
    });
    $("#contact").DataTable({
      ordering: true,
      processing: true,
      serverSide: true,
      ajax: {
        url: "<?php echo base_url('backend/adm_contact/grab_data_contact') ?>",
        type:'POST',
      }
    });

    $("#tag_line").DataTable({
      ordering: true,
      processing: true,
      serverSide: true,
      ajax: {
        url: "<?php echo base_url('backend/adm_tag_line/grab_data_tag_line') ?>",
        type:'POST',
      }
    });

    $("#change_poin").DataTable({
      ordering: true,
      processing: true,
      serverSide: true,
      ajax: {
        url: "<?php echo base_url('backend/adm_change_poin/grab_data_change_poin') ?>",
        type:'POST',
      }
    });




    	
    	$("#user").DataTable({
			ordering: true,
			processing: true,
			serverSide: true,
			ajax: {
			  url: "<?php echo base_url('backend/user/grab_data') ?>",
			  type:'POST',
			}
		});
    	$("#pgcontent").DataTable({
			ordering: true,
			processing: true,
			serverSide: true,
			ajax: {
			  url: "<?php echo base_url('backend/adm_pagecontent/grab_data') ?>",
			  type:'POST',
			}
		});		
		$("#infoupdate").DataTable({
			ordering: true,
			processing: true,
			serverSide: true,
			ajax: {
			  url: "<?php echo base_url('backend/adm_infoupdate/grab_data') ?>",
			  type:'POST',
			}
		});		
		$("#newscategori").DataTable({
			ordering: true,
			processing: true,
			serverSide: true,
			ajax: {
			  url: "<?php echo base_url('backend/adm_newscategori/grab_data') ?>",
			  type:'POST',
			}
		});
		$("#newscomment").DataTable({
			ordering: true,
			processing: true,
			serverSide: true,
			ajax: {
			  url: "<?php echo base_url('backend/adm_newscomment/grab_data') ?>",
			  type:'POST',
			}
		});
		$("#faq").DataTable({
			ordering: true,
			processing: true,
			serverSide: true,
			ajax: {
			  url: "<?php echo base_url('backend/adm_faq/grab_data') ?>",
			  type:'POST',
			}
		});
		$("#clients").DataTable({
			ordering: true,
			processing: true,
			serverSide: true,
			ajax: {
			  url: "<?php echo base_url('backend/adm_clients/grab_data') ?>",
			  type:'POST',
			}
		});
		



		$("#example").DataTable({
			ordering: true,
			processing: true,
			serverSide: true,
			ajax: {
			  url: "<?php echo base_url('backend/dashboard/ambil_data') ?>",
			  type:'POST',
			}           
		});
    });
    </script>




<script>
  var table;
  $(document).ready(function() {
    $("#order_member").DataTable({
      "processing"    : true, //Feature control the processing indicator.
      "serverSide"    : true, //Feature control DataTables' servermside processing mode.
      //"order"     : [], //Initial no order.
      "iDisplayLength"  : 10,

      "ordering"      : true,
      "processing"    : true,
      "serverSide"    : true,

      // Load data for the table's content from an Ajax source
      "ajax": {
        "url"   : "<?php echo base_url('backend/adm_member_history/grab_data_order_member') ?>",
        "type"    : "POST",
        "dataType"  : "json",
        "dataSrc": function (jsonData) {        
          return jsonData.data;
        }
      },

      //Set column definition initialisation properties.
      "columnDefs": [
        { 
          "targets": [ 0 ], //kolom pertama atau penomoran kolom
          "orderable": false, //set not orderable
        },
      ],

        });
    });
  </script>
<script>
  var table;
  $(document).ready(function() {
    $("#all_order").DataTable({
      "processing"    : true, //Feature control the processing indicator.
      "serverSide"    : true, //Feature control DataTables' servermside processing mode.
      //"order"     : [], //Initial no order.
      "iDisplayLength"  : 10,

      "ordering"      : true,
      "processing"    : true,
      "serverSide"    : true,

      // Load data for the table's content from an Ajax source
      "ajax": {
        "url"   : "<?php echo base_url('backend/adm_member_orders/grab_data_all_order') ?>",
        "type"    : "POST",
        "dataType"  : "json",
        "dataSrc": function (jsonData) {        
          return jsonData.data;
        }
      },

      //Set column definition initialisation properties.
      "columnDefs": [
        { 
          "targets": [ 0 ], //kolom pertama atau penomoran kolom
          "orderable": false, //set not orderable
        },
      ],

        });
    });
  </script>	



<script>
  var table;
  $(document).ready(function() {
    $("#purchase_order").DataTable({
      "processing"    : true, //Feature control the processing indicator.
      "serverSide"    : true, //Feature control DataTables' servermside processing mode.
      //"order"     : [], //Initial no order.
      "iDisplayLength"  : 10,

      "ordering"      : true,
      "processing"    : true,
      "serverSide"    : true,

      // Load data for the table's content from an Ajax source
      "ajax": {
        "url"   : "<?php echo base_url('backend/order/grab_data_all_order') ?>",
        "type"    : "POST",
        "dataType"  : "json",
        "dataSrc": function (jsonData) {        
          return jsonData.data;
        }
      },

      //Set column definition initialisation properties.
      "columnDefs": [
        { 
          "targets": [ 0 ], //kolom pertama atau penomoran kolom
          "orderable": false, //set not orderable
        },
      ],

        });
    });
  </script>


  <!-- CK EDITOR -->
  <script src="<?php echo base_url(); ?>assets/plugins/ckeditor/ckeditor.js"></script>
  <script type="text/javascript">
      CKEDITOR.replace('ckeditor');
  </script>
  <!-- /CK EDITOR -->



</body>
</html>