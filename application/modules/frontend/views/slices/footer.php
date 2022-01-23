
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