    <div class="modal fade" id="modalDefault" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Logout</h4>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <p>Apakah Anda ingin keluar dari akun ?</p>
          </div>
          <div class="modal-footer">
            <button class="btn btn-outline-secondary btn-sm" type="button" data-dismiss="modal">Tidak</button>
            <?php echo anchor('reseller/logout', 'Ya', array('class'=>'btn btn-primary btn-sm')); ?>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="order" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"><i class="fa fa-shopping-bag"></i> Membeli Produk</h4>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <div class="fetched-data"></div>
          </div>
        </div>
      </div>
    </div>
  <script src="<?= base_url(); ?>assets/bootstrap/js/jquery.js" type="text/javascript"></script>
  <script type="text/javascript">
  $(document).ready(function(){
      $('#order').on('show.bs.modal', function (e) {
          var rowid = $(e.relatedTarget).data('id');
          $.ajax({
              type : 'post',
              url : "<?php echo base_url('frontend/product/looks'); ?>",
              data :  'rowid='+ rowid,
              success : function(data){
              $('.fetched-data').html(data);
              }
          });
       });
  });
  </script>


      <div class="modal fade" id="order_of_product" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <!--div class="modal-header">
            <h4 class="modal-title">Detail</h4>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div-->
          <div class="modal-body">
            <div class="fetched-data"></div>
          </div>
        </div>
      </div>
    </div>
  <script src="<?= base_url(); ?>assets/bootstrap/js/jquery.js" type="text/javascript"></script>
  <script type="text/javascript">
  $(document).ready(function(){
      $('#order_of_product').on('show.bs.modal', function (e) {
          var rowid = $(e.relatedTarget).data('id');
          $.ajax({
              type : 'post',
              url : "<?php echo base_url('frontend/reseller_order/looks'); ?>",
              data :  'rowid='+ rowid,
              success : function(data){
              $('.fetched-data').html(data);
              }
          });
       });
  });
  </script>
