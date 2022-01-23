<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Tambah gambar event</h2>
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
        

<?php echo form_open_multipart($form_action); ?>

  <script type="text/javascript">
    function add() {
      var content = '';
        content += '<a href="javascript:;" onclick="hapus(this)" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Hapus record</a><br />';
        content += '<div><p><input type="file" class="form-control" name="userfiles[]" required="required" /></p><p><input type="text" class="form-control" name="caption_userfiles[]" placeholder="Caption Gambar" required="required" /></p><p><input type="number" class="form-control" name="event_pic_sort[]" placeholder="Pengurutan Gambar" required="required"></p></div>';
        content += '<br />';
      var x = document.createElement('div');
      x.innerHTML = content;
      document.getElementById('record').appendChild(x);
    }

     function hapus(element) {
      var x = document.getElementById('record');
      x.removeChild(element.parentNode);
     }
    </script>


      <div><p><input type="file" class="form-control" name="userfiles[]" required="required" /></p><p><input type="text" class="form-control" name="caption_userfiles[]" placeholder="Caption Gambar" required="required" /></p><p><input type="number" class="form-control" name="event_pic_sort[]" placeholder="Pengurutan Gambar" required="required"></p></div>
          <br />
          <div id="record"></div>  
         
      <a href="javascript:add();" class="btn btn-dark btn-xs"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah record</a><br><br>

     <?php echo anchor($this->session->userdata('lolin_urlback_backend'), '<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Batal', array('class' => 'btn btn-warning btn-sm' )); ?>
    <?php echo form_submit('submit', 'Simpan', array('class'=>'btn btn-dark btn-sm')); ?>

<?php echo form_close(); ?> 



      </div>
    </div>
  </div>
</div>


