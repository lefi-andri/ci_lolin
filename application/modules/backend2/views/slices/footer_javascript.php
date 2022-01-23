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

    <script>
        $('.profile-img').initial({width:52,height:52, fontSize:20, charCount:2, fontWeight:100}); 
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