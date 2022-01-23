<script>
function showDetails(bookURL){
       window.open(bookURL,"bookDetails","width=600,height=430,scrollbars=yes");              
    }
</script>

<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Update Konten Halaman</h2>
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

        <?php echo form_open_multipart($form_action, array('class'=>'form-horizontal')); ?>

        <div class="row">
          <div class="col-md-8">

            

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Judul</label>
              <div class="col-sm-8">
                <?php echo form_error('judul'); ?>
                <?php  
                  $form = array(
                    'judul' => array(
                      'name' => 'judul', 
                      'value'=>set_value('judul', isset($form_value['judul']) ? $form_value['judul'] : ''),
                      'class'=>'form-control'
                    ),
                  );
                ?>
                <?php echo form_input($form['judul']); ?>
              </div>
            </div>

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Deskripsi</label>
              <div class="col-sm-10">
                <?php echo form_error('deskripsi'); ?>
                <?php 
                $deskripsi = set_value('deskripsi', isset($form_value['deskripsi']) ? $form_value['deskripsi'] : '');
                ?>
                <textarea name="deskripsi" class="form-control ckeditor"><?php echo $deskripsi; ?></textarea>
                <br>
                <p onclick="return showDetails('<?php echo base_url("backend/unggah_gambar/index"); ?>');" title="Upload Gambar" class="btn btn-warning btn-xs"><i class="fa fa-file-photo-o"></i> Upload Gambar</p>
              </div>
            </div>

            <hr>

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Deskripsi Seo</label>
              <div class="col-sm-10">
                <?php echo form_error('deskripsi_seo'); ?>
                <?php 
                $deskripsi_seo = set_value('deskripsi_seo', isset($form_value['deskripsi_seo']) ? $form_value['deskripsi_seo'] : '');
                ?>
                <textarea name="deskripsi_seo" class="form-control"><?php echo $deskripsi_seo; ?></textarea>
                <p class="help-block">Dibutuhkan agar website kita dapat di indeks oleh mesin pencari (Search engine)</p>
              </div>
            </div>

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Keyword Seo</label>
              <div class="col-sm-10">
                <?php echo form_error('keyword_seo'); ?>
                <?php 
                $keyword_seo = set_value('keyword_seo', isset($form_value['keyword_seo']) ? $form_value['keyword_seo'] : '');
                ?>
                <textarea name="keyword_seo" class="form-control"><?php echo $keyword_seo; ?></textarea>
                <p class="help-block">Dibutuhkan agar website kita dapat di indeks oleh mesin pencari (Search engine), pisahkan dengan koma</p>
              </div>
            </div>

          </div>
          <div class="col-md-4">

            <div class="form-group">
                  <label for="" class="col-sm-4 control-label">Status Halaman</label>
                  <div class="col-sm-8">
                  <?php echo form_error('status_id'); ?>
                  <?php echo form_dropdown('status_id', $dropdown_status, set_value('status_id', isset($form_value['status_id']) ? $form_value['status_id'] : ''), array('class' => 'form-control' )); ?>
                  </div>
            </div>

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-4 control-label">Tampilkan Sebagai Peta Situs</label>
              <div class="col-sm-8">
              <?php echo form_error('peta_situs'); ?>
                <label class="radio-inline">
                        <?php echo form_radio('peta_situs', '1', set_radio('peta_situs', '1', isset($form_value['peta_situs']) && $form_value['peta_situs'] == '1' ? TRUE : FALSE), array('class' => 'flat')); ?>
                    Ya</label>
                    <label class="radio-inline">
                        <?php echo form_radio('peta_situs', '0', set_radio('peta_situs', '0', isset($form_value['peta_situs']) && $form_value['peta_situs'] == '0' ? TRUE : FALSE), array('class' => 'flat')); ?>
                    Tidak</label>
                </div>
            </div>

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-4 control-label">Perbolehkan Tampil</label>
              <div class="col-sm-8">
              <?php echo form_error('perbolehkan_tampil'); ?>
                <label class="radio-inline">
                        <?php echo form_radio('perbolehkan_tampil', '1', set_radio('perbolehkan_tampil', '1', isset($form_value['perbolehkan_tampil']) && $form_value['perbolehkan_tampil'] == '1' ? TRUE : FALSE), array('class' => 'flat')); ?>
                    Ya</label>
                    <label class="radio-inline">
                        <?php echo form_radio('perbolehkan_tampil', '0', set_radio('perbolehkan_tampil', '0', isset($form_value['perbolehkan_tampil']) && $form_value['perbolehkan_tampil'] == '0' ? TRUE : FALSE), array('class' => 'flat')); ?>
                    Tidak</label>
                </div>
            </div>
            
          </div>
        </div>

        

        

        <hr>

        <div class="form-group">
          <label for="inputEmail3" class="col-sm-1 control-label"></label>
          <div class="col-sm-10">
            <?php echo anchor($this->session->userdata('lolin_urlback_backend'), '<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Batal', array('class' => 'btn btn-warning btn-sm' )); ?>
            <?php echo form_submit('submit', 'Update', array('class'=>'btn btn-dark btn-sm')); ?>
          </div>
        </div>

        <?php echo form_close(); ?>

      </div>
    </div>
  </div>
</div>