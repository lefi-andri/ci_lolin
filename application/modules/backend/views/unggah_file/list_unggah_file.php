<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Unggah File</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="#">Settings 1</a>
              </li>
              <li><a href="#">Settings 2</a>
              </li>
            </ul>
          </li>
          <li><a class="close-link"><i class="fa fa-close"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <p class="text-muted font-13 m-b-30">
          Halaman ini digunakan untuk mengelola unggahan file.
        </p>
        <div align="right">
			<?php echo anchor($this->session->userdata('lolin_urlback_backend'), '<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Refresh Data', array('class' => 'btn btn-info btn-sm' )); ?>
			<?php echo anchor('backend/unggah_file/add', '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah Unggah File', array('class' => 'btn btn-dark btn-sm' )); ?>
		</div>

		<?php echo $table; ?>
      </div>
    </div>
  </div>
</div>

<!-- SCRIPT MODAL AJAX -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="myModal">
  <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title"><i class="fa fa-chain"></i> Salin link ke editor anda.</h5>
            </div>
            <div class="modal-body">                
                <div class="fetched-data"></div>
            </div>                    
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    $('#myModal').on('show.bs.modal', function (e) {
        var rowid = $(e.relatedTarget).data('id');
        $.ajax({
            type : 'post',
            url : '<?php echo base_url(); ?>backend/unggah_file/detail',
            data :  'rowid='+ rowid,
            success : function(data){
            $('.fetched-data').html(data);
            }
        });
     });
});
</script>