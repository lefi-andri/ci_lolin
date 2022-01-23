    <script src="<?php echo base_url(); ?>assets/themes/espire/dist/assets/js/vendor.js"></script>

    <script src="<?php echo base_url(); ?>assets/themes/espire/dist/assets/js/app.min.js"></script>

    <!-- page plugins js -->
    <script src="<?php echo base_url(); ?>assets/themes/espire/bower_components/selectize/dist/js/standalone/selectize.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/themes/espire/bower_components/moment/min/moment.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/themes/espire/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="<?php echo base_url(); ?>assets/themes/espire/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js"></script>
    <script src="<?php echo base_url(); ?>assets/themes/espire/bower_components/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
    <script src="<?php echo base_url(); ?>assets/themes/espire/bower_components/summernote/dist/summernote.min.js"></script>

    <!-- page js -->
    <script src="<?php echo base_url(); ?>assets/themes/espire/dist/assets/js/forms/form-elements.js"></script>
    <script src="<?php echo base_url(); ?>assets/themes/espire/bower_components/datatables/media/js/jquery.dataTables.js"></script>

    <!-- page js -->
    <script src="<?php echo base_url(); ?>assets/themes/espire/dist/assets/js/table/data-table.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/select2/js/select2.full.js"></script>

    <!-- CK EDITOR -->
    <script src="<?php echo base_url(); ?>assets/plugins/ckeditor/ckeditor.js"></script>
    <script type="text/javascript">
      CKEDITOR.replace('ckeditor');
    </script>
    <!-- /CK EDITOR -->

    <script>
        $('.profile-img').initial({width:52,height:52, fontSize:20, charCount:2, fontWeight:100}); 
    </script>

    <script>
        $(document).ready(function(){

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
            $("#socialmedia").DataTable({
              ordering: true,
              processing: true,
              serverSide: true,
              ajax: {
                url: "<?php echo base_url('backend/adm_socialmedia/grab_data_socialmedia') ?>",
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
            $("#events").DataTable({
              ordering: true,
              processing: true,
              serverSide: true,
              ajax: {
                url: "<?php echo base_url('backend/adm_events/grab_data_events') ?>",
                type:'POST',
              }
            });
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
    <script>
        $(document).ready(function () {
            $(".select2").select2({
              placeholder: "Please Select"
            });
            
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